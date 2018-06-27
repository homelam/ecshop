<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Repositories\CategoryRepository;

class CategoriesController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->categoryLst();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 获取所有的分类（tree struct）
        $categories = $this->categoryRepository->categoryLst();

        return view('admin.categories.create', compact('categories'));
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
            return back()->with('status', '分类 ' . $request['cat_name'] . ' 创建成功');
        } else  {
            return back()->with('status', '分类 ' . $request['cat_name'] . ' 创建失败');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if ($category->cat_id) {
            //修改的分类所属分类不能是自己以及自己的子分类
            $data = $this->categoryRepository->getAllowCategoryById($category->cat_id);
            return view('admin.categories.edit', compact('data', 'category'));
        } else {
            return back()->with('error', '分类不存在！');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if (!$category->cat_id) {
            return back()->with('error', '分类不存在');
        }

        $result = $this->categoryRepository->update($request, $category);
        if ($result['status'] == 1) {
            return redirect()->route('categories.index')->with('success', '分类' . $request['cat_name'] . '修改成功');
        }

        return back()->withInput()->withErrors('分类' . $request['cat_name'] . '修改失败');
    }

    /**
     * 删除分类
     *
     * @param  App\Models\Categoryy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $data = $this->categoryRepository->delete($category);
        // 如果是ajax请求
        if (request()->ajax()) {
            return response()->json($data, 204);
        }

        return back()->with('status', $data['msg']);
    }
}
