<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Validation\Rule;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Repositories\CategoryRepository;

class CategoriesController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    // 查找所有的分类
    public function index()
    {
        $categories = $this->categoryRepository->categoryLst();
        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $result = $this->categoryRepository->store($request);

        if ($result['status'] == 1) {
            return response()->json($result, 200);
        } else  {
            // TODO: 状态码
            return response()->json($result, 111);
        }
    }

    // 更新
    public function update(Request $request, Category $category)
    {
        if (!$category->cat_id) {
            return response()->json(['stauts' => 2, 'msg' => '分类不存在'], 404);
        }

        $result = $this->categoryRepository->update($request, $category);
        if ($result['status'] == 1) {
            return response()->json($category, 200);
        }
        // TODO: 修改失败的状态码？
        return response()->json(['stauts' => 2, 'msg' => '更新分类失败'], 111);
    }

    /**
     * 删除分类
     *
     * @param  App\Models\Category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $data = $this->categoryRepository->delete($category);

        return response()->json($data, 200);
    }

    /**
     * 根据分类id显示分类信息以及可以修改的分类集合
     *
     * @param int $cat_id
     * @return \Illuminate\Http\Response
     */
    public function show($cat_id)
    {
        if ($cat_id) {
            //修改的分类所属分类不能是自己以及自己的子分类
            $data = $this->categoryRepository->getAllowCategoryById($cat_id);
            $category = Category::find($cat_id);
            return response()->json(['category' => $category, 'allowCategory' => $data], 200);
        } else {
            return response()->json(['stauts' => 2, 'msg' => '分类不存在'], 404);
        }
    }
}
