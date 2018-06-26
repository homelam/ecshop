<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $primaryKey = 'brand_id'; // 声明表的主键

    protected $fillable = ['brand_name', 'brand_logo', 'site_url', 'brand_desc', 'is_show', 'sort_order'];

    public $timestamps = true;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * 获取所有的品牌
     *
     */
    public function getAllBrands($sort_order = 'desc', $limit = 10)
    {
        return $this->orderby('sort_order', $sort_order)->paginate($limit);
    }
}
