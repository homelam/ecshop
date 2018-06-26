<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
