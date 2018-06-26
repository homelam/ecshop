<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Type;
use App\Models\Traits\ApiTrait;

class AttributesController extends Controller
{
    use ApiTrait;

    protected $attrModel;

    public function __construct(Attribute $attrModel)
    {
        $this->attrModel = $attrModel;
    }

    /**
     * 商品类型对应的属性列表
     *
     * @param int $goods_type 商品类型id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $goods_type)
    {
        $attributes = $this->attrModel->getAttributesByTypeId($goods_type);
        // dd($attributes);
        if (request()->ajax()) {
            return response()->json($attributes);
        } else {
            return view('admin.attributes.list', compact('attributes'))->with('type_id', $goods_type);
        }
    }

    /**
     * 增加属性
     *
     * @return \Illuminate\Http\Response
     */
    public function create($goods_type)
    {
        // 获取所有的商品类型
        $goods_types = Type::all();

        return view('admin.attributes.create', compact('goods_types'))->with('type_id', $goods_type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_time'] = $data['updated_time'] = time();

        // 把中文逗号替换成英文逗号
        if(isset($data['attr_values']) && $data['attr_values'])  {
            $data['attr_values'] = str_replace('，', ',', $data['attr_values']);
        } else {
            $data['attr_values'] = '';
        }
        $result = Attribute::create($data);
        if ($result) {
            return redirect('admin/attributes/' . $result->type_id);
        }
        return back()->with('status', '添加失败！');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        //
        $goods_types = Type::all();

        return view('admin.attributes.edit', compact('attribute', 'goods_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attribute $attribute)
    {
        $data = $request->all();
        if(isset($data['attr_values']) && $data['attr_values'])  {
            $data['attr_values'] = str_replace('，', ',', $data['attr_values']);
        } else {
            $data['attr_values'] = '';
        }
        $result = $attribute->update($data);
        if ($result) {
            return redirect('admin/attributes/' . $attribute->type_id);
        } else {
            return back()->with('status', '更新失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        // 根据id删除对应的属性
        if ($attribute->attr_id > 0) {
            $result = $attribute->delete();
            if ($result) {
                $code = 200;
                $msg = '属性删除成功';
            } else {
                $code = 100;
                $msg = '失败';
            }
        } else {
            $code = 404;
            $msg = '属性不存在!';
        }

        return $this->setCode($code)->setMsg($msg)->toJson();
    }
}
