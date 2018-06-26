<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class ProductsController extends Controller
{
    protected $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 获取商品分类
        $data = $this->productModel->getProducts();

        return view('admin.products.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // 获取所有的商品分类（树状结构）
        $categories = (new Category)->getCategoriesTree();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * 保存商品
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->all();

        // 进行数据验证

        $result = $this->productModel->saveProduct($data);

        // TODO: 保存之后的动作
        if ($result['status']) {
            return redirect('admin/products');
        }
        return back()->with('status', $result['msg']);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        // 获取所有的商品分类（树状结构）
        $id = $product->goods_id;
        if (!$id) {
            return back()->with('status', '该商品不存在!');
        }
        // 取出所有的分类
        $categories = (new Category)->getCategoriesTree();

        // 取出该商品类型所有的属性列表
        $attrLists = DB::table('attributes as a')->join('goods_attr as b', function($join) use ($id) {
                            $join->on('a.attr_id', '=', 'b.attr_id')
                                ->where('b.goods_id', $id);
                        }, null, null, 'left')
                        ->where('a.type_id', '=', $product->type_id)
                        ->select('a.attr_id', 'a.attr_name', 'a.attr_type', 'a.attr_input_type', 'a.attr_values', 'b.attr_value', 'b.id')
                        ->get();;

        return view('admin.products.edit', compact('product', 'categories', 'attrLists'));
    }

    /**
     * 更新商品数据
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // 获取提交的数据
        $data  = $request->all();
        $result = $this->productModel->updateProduct($data, $product);
        if ($result) {
            return redirect('admin/products');
        }
        return back()->with('status', '更新失败');
    }

    /**
     * 删除商品
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($id = $product->goods_id) {
            $result = $this->productModel->delProductById($id);
            if ($result['status']) {
                return redirect('admin/products');
            }
            return back()->with('status', $result['msg']);
        }

        return back()->with('status', '无法删除!');
    }

    /**
     * ajax 删除商品属性 以及更新对应的库存量数据
     * @param int $id 属性的id
     */
    public function ajaxDelAttr(Request $request, int $id)
    {
        $data = $request->all();
        $goods_id = $data['goods_id'] ?? '';

        // 删除对应的属性
        DB::table('goods_attr')->where('id', $id)->delete();

        // TODO: 更新对应的库存量数据

        return json_encode(['status' => '1', 'msg' => $data]);
    }
}
