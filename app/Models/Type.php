<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'goods_type';

    protected $primaryKey = 'type_id'; // 声明表的主键

    protected $fillable = ['type_name', 'is_enabled', 'attr_group'];

    public $timestamps = false;

    protected $guarded = [];

    /**
     * TODO: 如何通过模型关联获取对应的数据？？？
     */
    public function getAttributes()
    {
        // 第二个和第三个参数是 attributes表的外键和主键
        return $this->hasMany(Attribute::class, 'type_id', 'attr_id');
    }

    /**
     * 获取所有的商品类型
     */
    public function getGoodsTypes($sort_order = 'desc', $limit = 10)
    {
        return $this->orderby('type_id', $sort_order)->paginate($limit);
    }
}
