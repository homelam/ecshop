<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'cat_id'; // 声明表的主键

    protected $fillable = ['cat_name', 'parent_id', 'cat_desc', 'show_in_nav', 'is_show', 'sort_order'];

    public $timestamps = false;

    protected $guarded = [];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // 获取分类的树状结构
    public function getCategoriesTree()
    {
        $categories = $this->orderBy('sort_order', 'desc')->get();
        return $this->getTree($categories, 'cat_name');
    }

    public function getTree($data, $field_name, $parent_id = 0, $level = 0)
    {
        static $ret = [];

        foreach ($data as $key => $val) {
            if ($val->parent_id == $parent_id) {
                $data[$key]['_'.$field_name] = str_repeat('|----', $level) . $data[$key][$field_name];

				$ret[] = $val;
				// 找该分类的子分类
				$this->getTree($data, $field_name, $val->cat_id, $level+1);
            }
        }
        return $ret;
    }

    public function getChildren(int $cat_id)
    {
        $data = $this->all();

        return $this->getChildrenIds($data, $cat_id, TRUE);
    }

    /**
     * 根据分类id获取该分类所有的子分类
     *
     * @param Illuminate\Database\Eloquent\Collection $data 需要查找的数据集合
     * @param int $cat_id 需要查找子集的条件
     * @param boolean $is_clear 是否清空静态数组
     *
     * @return array $ids
     */
    protected function getChildrenIds($data, $cat_id, $is_clear = FALSE)
    {
        static $ids = [];  // 保存找到的子分类的ID
        if($is_clear)
            $ids = [];
		// 循环所有的分类找子分类
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $cat_id)
			{
				$ids[] = $v['cat_id'];
				// 再找这个$v的子分类
				$this->getChildrenIds($data, $v['cat_id']);
			}
		}
		return $ids;
    }

    public function getNavData()
    {
        // TODO: 存进缓存
        // 获取所有的分类数据
        $categories = $this->orderBy('sort_order', 'desc')->get();
        $ret = [];

        // 循环所有的分类取出所有的顶级分类
        foreach ($categories as $k => $v) {
            if ($v->parent_id ==0) {
                // 循环所有的分类取出这个低级分类分类的子分类
                $data1 = [];
                foreach ($categories as $k1 => $v1) {
                    if ($v1->parent_id == $v->cat_id) {
                        // 循环所有的分类找出该分类的二级分类
                        $data2 = [];
                        foreach ($categories as $k2 => $v2)
                        {
                            if ($v2->parent_id == $v1->cat_id) {
                                $data2[] = $v2;
                            }
                        }
                        $v1['children'] = $data2;
                        $data1[] = $v1;
                    }
                }
                $v['children'] = $data1;
                $ret[] = $v;
            }
        }

        return $ret;
    }

    public function getFloorData()
    {
        // TODO: 判断缓存中是否有数据，如果有直接获取

        // 如果没有,从数据库总获取
        $ret = $this->where([
            'parent_id'=> 0,
            'show_in_nav' => 1
        ])->get();

        foreach ($ret as $k => $v) {
            $goodsId = (new product)->getGoodsIdByCatId($v->cat_id);

            // 取出这些商品所用到品牌
            $ret[$k]['brand'] =  DB::table('products as a')->leftJoin('brands as b', 'a.brand_id', '=', 'b.brand_id')
                ->select('b.brand_id',  'b.brand_name', 'b.brand_logo', 'b.site_url')
                ->distinct('b.brand_id')
                ->whereIn('a.goods_id', $goodsId)->take(9)
                ->get();

            // 取出未推荐的二级分类并保存在这个顶级分类的subCat字段中
            $ret[$k]['subCat'] = $this->where(['parent_id'=> $v->cat_id, 'show_in_nav' => 0])->get();

            // 取出未推荐的二级分类并保存在这个顶级分类的recSubCat字段中
            $ret[$k]['recSubCat'] = $this->where(['parent_id'=> $v->cat_id, 'show_in_nav' => 1])->get();

            // 循环每个推荐的二级分类取出分类下的8件被推荐到楼层的商品
            foreach ($ret[$k]['recSubCat'] as $k1 => &$v1) {
                $gids = (new product)->getGoodsIdByCatId($v1->cat_id);
                $v1['goods'] = DB::table('products')->select('goods_id', 'mid_img', 'goods_name', 'shop_price')
                    ->where([
                        'is_on_sale' => 1,
                        'show_in_floor' => 1  // TODO: 数据库中增加一个字段，商品是否显示在楼层
                    ])->whereIn('goods_id', $gids)
                    ->orderBy('sort_order', 'desc')
                    ->take(8)->get();
            }
        }
        return $ret;
    }
}
