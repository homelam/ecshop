<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attribute extends Model
{
    protected $table = 'attributes';

    protected $primaryKey = 'attr_id'; // 声明表的主键

    protected $fillable = ['type_id', 'attr_name', 'attr_input_type', 'attr_type', 'attr_values', 'sort_order', 'created_time', 'updated_time'];

    public $timestamps = false;

    protected $guarded = [];

    // 一种商品类型可以有多个属性 一对多的关系
    public function getGoodsType()
    {
        return $this->belongsTo(Type::class, 'type_id', 'attr_id');
    }

    public function getAttributesByTypeId($type_id)
    {
        if (preg_match('/^\d+$/', $type_id)) {
            return DB::table('attributes')
                    ->leftJoin('goods_type', 'attributes.type_id', '=', 'goods_type.type_id')
                    ->where('goods_type.type_id', $type_id)
                    ->select('attributes.*', 'goods_type.type_name')
                    ->get();
        }

        return [];
    }
}
