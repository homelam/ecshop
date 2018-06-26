<?php

namespace App\Http\Controllers\Repositories;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Validator;

class TypeRepository
{
    protected $typeModel;

    public function __construct(Type $typeModel)
    {
        $this->typeModel = $typeModel;
    }

    public function getAllTypes()
    {
        return $this->typeModel->getGoodsTypes();
    }

    public function store(Request $request)
    {
        $rules = [
            'type_name'=> 'required|max:60'
        ];

        $valid = Validator::make($request->all(), $rules);
        // 进行数据验证
        if ($valid->passes()) {
            $data = $request->all();
            if ($data['attr_group']) {
                $attr_groups = explode("\n", str_replace("\r", '', $data['attr_group']));
                $data['attr_group'] = implode(',', $attr_groups);
            }
            $data['attr_group'] = $data['attr_group'] ?: '';
            $result = Type::create($data);

            if ($result) {
                $data = ['status' => 1, 'msg' => '添加成功'];
            } else {
                $data = ['status' => 0, 'msg' => '商品类型添加失败'];
            }
        }

        return $data ?? ['status' => 2, 'msg' => $valid];
    }

    public function updateType(Request $request, $id)
    {
        $data = $request->all();

        $result = DB::table('goods_type')->where('type_id', $id)->update(['type_name' => $data['type_name']]);

        return $result;
    }

    public function destroy(Type $type)
    {
        DB::beginTransaction();
        try {
            $id = $type->type_id;
            $totalUsed = DB::table('products')->where('type_id', $id)->count();
            // 如果有商品用到该商品类型不允许删除
            if ($totalUsed > 0) {
                return ['status' => 0, 'msg' => '有商品已经使用该商品类型'];
            }
            // 把商品类型删除的同时需要把该商品类型对应的属性删除
            $type->delete();
            DB::table('attributes')->where('type_id', '=', $id)->delete();
            DB::commit();
            return ['status' => 1, 'msg' => '删除成功！'];
        } catch (QueryException $e) {
            DB::rollback();
            return ['status' => 0, 'msg' => '删除商品类型出错,请稍候重试!'];
        }
    }
}
