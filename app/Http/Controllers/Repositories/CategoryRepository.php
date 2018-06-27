<?php

namespace App\Http\Controllers\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Validator;

class CategoryRepository
{
    protected $catModel;

    public function __construct(Category $catModel)
    {
        $this->catModel = $catModel;
    }

    public function categoryLst()
    {
        // 以树状结构返回所有的分类
        return $this->catModel->getCategoriesTree();
    }

    public function getAllowCategoryById(int $cat_id)
    {
        $categories = $this->categoryLst();
        $children = $this->catModel->getChildren($cat_id);

        //修改的分类所属分类不能是自己以及自己的子分类
        $data = [];
        foreach ($categories as $val) {
            if ($val->cat_id == $cat_id || in_array($val->cat_id, $children)) {
                continue;
            }
            $data[] = $val;
        }

        return $data;
    }

    /**
     * 新增保存
     *
     * @param Request $request
     *
     * @return Category
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($data['parent_id'] != 0) {
            // 如果该父分类存在
            $category = Category::query()->find($data['parent_id']);
            if (!$category) {
                return ['status' => 0, 'msg' => '输入信息有误'];
            }
        }

        $result = Category::create($data);
        if ($result) {
            return ['status' => 1, 'msg' => '分类添加成功!'];
        }

        return ['status' => 0, 'msg' => '分类添加失败!'];
    }

    public function update(Request $request, Category $category)
    {
        $rules = [
            'cat_name'=> [
                'required'
            ],
            'cat_desc' => 'bail|required'
        ];
        $valid = Validator::make($request->all(), $rules);

        if ($valid->passes()) {
            $result = $category->update($request->all());

            if ($result) {
                $data = ['status' => 1, 'msg' => '更新成功'];
            } else {
                $data = ['status' => 0, 'msg' => '分类更新失败'];
            }
        }

        return $data ?? ['status' => 2, 'msg' => $valid];
    }

    /**
     * 删除
     */
    public function delete(Category $category)
    {
        if ($category) {
            // 获取需要删除分类的分类id
            $cat_id = $category->cat_id;

            // 删除分类时，分类的子分类也一同删除
            $children = $this->catModel->getChildren($cat_id);
            $children[] = $cat_id;

            DB::beginTransaction();
            try {
                $result = Category::whereIn('cat_id', $children)->delete();
                $data = ['status' => 1, 'msg' => '分类删除成功!'];
                $code = 200;
                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();
                $data = ['status' => 0, 'msg' => "{$category->cat_name} 分类下有商品存在，不允许直接删除"];
                $code = 201;
            }
        }

        return $data ?? ['status' => 0, 'msg' => '分类不存在!'];
    }
}
