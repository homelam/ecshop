<?php

namespace App\Models\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

trait ProductTrait
{
    /**
     * 根据商品id删除商品库存量
     * @param int $id 商品id
     * @return bool
     */
    public function deleteGoodQuantityById($id)
    {
        if (!$id) {
            return false;
        }

        $result = DB::table('goods_number')->where('goods_id', '=', $id)->delete();
        if ($result === false) {
            return false;
        }

        return true;
    }

    /**
     * 根据商品id取出这件商品所有可选属性的值
     * @param int $id 商品id
     * @param int $type 属性类型
     * @return Collection
     */
    public function getGoodsAttr($id, $type = 1)
    {
        return DB::table('goods_attr as a')
            ->leftJoin('attributes as b', 'a.attr_id', '=', 'b.attr_id')
            ->where('a.goods_id', '=', $id)
            ->where('b.attr_type', '=', $type)
            ->get();
    }

    /**
     * 更新商品库存量
     * @param array $data 属性库存量
     * @param int $id 商品id
     * @param int $total  商品库存总数
     */
    public function updateInventories($data, $id, $total = 0)
    {
        try {
            DB::beginTransaction();
            $result = DB::table('goods_number')->insert($data); // 成功返回 true
            if ($result) {
                // 更新主表中的库存总数
                DB::table('products')->where('goods_id', '=', $id)->update(['goods_qty' => $total]);
            }
            DB::commit();
            return true;
        } catch(QueryException $e) {
            DB::rollback();
        }

        return false;
    }

    /**
     * 生成唯一的商品货号
     * @return string 生成的字符串
     */
    public function generateGoodsNumber()
    {
        return config('goods.goods_sn_prefix') . date('ydis') . str_pad(mt_rand(1, 99999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * 检查表单表单提交的数据
     * @param array $data 表单提交的数据
     * @return array
     */
    public function checkProductsData($data = [])
    {
        if ($data) {
            return $data;
        }

    }
}
