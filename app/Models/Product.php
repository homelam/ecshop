<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Intervention\Image\Facades\Image;
use App\Models\Traits\ProductTrait;
use App\Models\Category;

class Product extends Model
{
    use ProductTrait;

    protected $table = 'products';

    protected $primaryKey = 'goods_id'; // 声明表的主键

    public $timestamps = false;

    // 获取商品
    public function getProducts($limit = 15)
    {
        return DB::table('products')
            ->orderBy('goods_id', 'desc')
            ->orderBy('sort_order', 'desc')
            ->paginate($limit);
    }

    /**
     * 转化商品数据
     *
     * @param array $data  表单提交上来的数据
     * @param string $behavior 数据的行为  新建 create  更新 update
     * @return array
     */
    public function transProductData(array $data, $images = [], $behavior = 'create')
    {
        if ($data) {
            $product = [
                'goods_name' => $data['goods_name'],
                'goods_sn' => $data['goods_sn'] ?: $this->generateGoodsNumber(), // 如果没有则系统自动生成
                'cat_id' => $data['cat_id'],
                'brand_id' => $data['brand_id'],
                'shop_price' => $data['shop_price'],
                'market_price' => $data['market_price'],
                'virtual_sales' => $data['virtual_sales'] ?: 0,
                'promote_price' => $data['promote_price']>0 ? $data['promote_price'] : 0,
                'promote_start_date' => $data['promote_start_date'] ? strtotime($data['promote_start_date']) : 0,
                'promote_end_date' => $data['promote_end_date'] ? strtotime($data['promote_end_date']) : 0,
                'goods_weight' => $data['goods_weight'] ?: 0,
                'goods_qty' => $data['goods_qty'] ?: 0,
                'warn_number' => $data['warn_number'] ?: 0,
                'sort_order' => $data['sort_order'] ?? '',
                'give_integral' => $data['give_integral'] ?? '-1',
                'rank_integral' => $data['rank_integral'] ?? '-1',
                'integral' => $data['integral'] ?? 0,
                'is_best' => $data['is_best'] ?? '0',
                'is_hot' => $data['is_hot'] ?? '0',
                'is_new' => $data['is_new'] ?? '0',
                'is_shipping' => $data['is_shipping'] ?? '0',
                'seller_note' => $data['seller_note'] ?: '',
                'type_id' => $data['type_id'],
                'description' => $data['description'] ?? '',
                'short_desc' => $data['short_desc'] ?? ''
            ];

            if ($product['sort_order'] == '') {
                unset($product['sort_order']);
            }

            if ($data['original_img']) {
                $product['original_img'] = $data['original_img'];
                $product['small_img'] = $images['images'][0] ?? '';
                $product['mid_img'] = $images['images'][1] ?? '';
                $product['big_img'] = $images['images'][2] ?? '';
            }

            if ($behavior == 'create') {
                $product['created_time'] = $product['updated_time'] = time();
            } elseif ($behavior == 'update') {
                $product['updated_time'] = time();
            }
        }

        return $product ?? [];
    }

    public function saveProduct(array $data= [])
    {
        if ($data) {
            $images = [];
            if (!empty($data['original_img'])) {
                // 为图片生成缩略图
                $images = uploadSizeImage($data['original_img']);
            }

            $product = $this->transProductData($data, $images, 'create');
            DB::beginTransaction();
            try {
                $goods_id = DB::table('products')->insertGetId($product);
                if ($goods_id) {
                    $attr_values = $data['attr_value'] ?? [];
                    // 保存商品属性
                    $result = $this->saveGoodsAttrs($attr_values, $goods_id);

                    // TODO: 保存商品相册
                }
                DB::commit();
                return ['status' => true, 'msg' => '保存成功'];
            } catch (QueryException $e) {
                DB::rollBack();
                $msg = $e->getMessage();
            }
        }
        return ['status' => false, 'msg' => $msg ?? '新增失败！'];
    }

    /**
     * 更新商品数据
     * @param array $data 提交的商品数据
     * @param App\Models\Product $product
     */
    public function updateProduct(array $data, Product $product)
    {
        // dd(config('image.upload.disks'));
        $images = [];
        /** 处理商品图片 */
        if (!empty($data['original_img'])) {
            // 为图片生成缩略图
           $images = uploadSizeImage($data['original_img']);

           $data['small_img'] = $images['images'][0] ?? '';
           $data['mid_img'] = $images['images'][1] ?? '';
           $data['big_img'] = $images['images'][2] ?? '';

            /** 删除原来的图片 */
            $oldImages = [
                'original_img' => $product->original_img,
                'small_img' => $product->small_img,
                'mid_img' => $product->mid_img,
                'big_img' => $product->big_img,
            ];
            deleteImage($oldImages);
        }

        // 商品数据
        $productData = $this->transProductData($data, $images, 'update');
        // 影响到几个表的更新，所以启用事务处理
        DB::beginTransaction();
        try {
            $result = DB::table('products')->where('goods_id', $product->goods_id)->update($productData);
            if ($result) {
                $attr_values = $data['attr_value'] ?? [];
                // 更新商品属性
                $goods_attr_id = $data['goods_attr_id'];
                $result = $this->updateGoodsAttrs($attr_values, $product->goods_id, $goods_attr_id);

                // TODO: 更新商品相册
            }
            DB::commit();
            return $result;
        } catch (QueryException $e) {
            if (isset($oldImages)) {
                deleteImage($oldImages);
            }
            DB::rollBack();
        }

        return false;

    }

    /**
     * 保存商品的属性
     * @param array $attr_value 商品属性列表
     * @param int $id 商品的id
     * @return boolean
     */
    public function saveGoodsAttrs($attr_values, $id)
    {
        if ($attr_values) {
            foreach ($attr_values as $k => $v) {
                // 把属性值的数组去重
                $v = array_unique($v);
                foreach ($v as $k1 => $v1) {
                    if ($v1) {
                        $goodsAttrs[] = [
                            'goods_id' => $id,
                            'attr_id' => $k,
                            'attr_value' => $v1
                        ];
                    }
                }
            }
            // 保存商品属性
            $result = DB::table('goods_attr')->insert($goodsAttrs);
        }
        return $result;
    }

    /**
     * 更新商品修改商品属性
     *
     * @param array $attr_values 商品属性值
     * @param int $id 需要修改的商品id
     * @param array $gaid 属性对应的id
     */
    public function updateGoodsAttrs($attr_values, $id, $gaId)
    {
        $i = 0; // 循环的次数
        foreach ($attr_values as $k => $v) {
            $v = array_unique($v);
            foreach ($v as $k1 => $v1) {
                if ($gaId[$i] == '') {
                    // 如果有属性值再进行该属性的插入
                    if ($v1) {
                        // 说明是新增的属性，添加
                        DB::table('goods_attr')->insert([
                            'goods_id' => $id,
                            'attr_id' => $k,
                            'attr_value' => $v1
                        ]);
                    }
                } else {
                    // 修改
                    DB::table('goods_attr')->where('id', $gaId[$i])->update(['attr_value' => $v1]);
                }
                $i++;
            }
        }
        return true;
    }

    /**
     * 删除商品
     * @param Request $product
     * @return response
     */
    public function delProductById($id)
    {
        if (preg_match('/^[1-9]\d*$/', $id)) {
            DB::beginTransaction();
            try {
                $product = $this->find($id);
                /** 删除原来的图片 */
                $oldImages = [
                    'original_img' => $product->original_img,
                    'small_img' => $product->small_img,
                    'mid_img' => $product->mid_img,
                    'big_img' => $product->big_img,
                ];
                deleteImage($oldImages);

                // 删除商品信息
                $this->where('goods_id', '=', $id)->delete();

                // 删除商品属性
                DB::table('goods_attr')->where('goods_id', $id)->delete();

                // 删除商品图片
                DB::table('goods_gallery')->where('goods_id', $id)->delete();

                // 删除商品库存
                $this->deleteGoodQuantityById($id);
                DB::commit();
                return ['status' => true, 'msg' => '删除成功！'];
            } catch (QueryException $e) {
                DB::rollback();
                return ['status' => false, 'msg' => $e->getMessage()];
            }
        }
        return ['status' => false, 'msg' => '该商品不存在！'];
    }

    /**
     * 根据商品id获取商品的属性列表
     *
     * @param int $id 商品id
     *
     * @return Illuminate\Support\Collection $gaData
     */
    public function getProductAttrsById(int $id)
    {
        $gaData = DB::table('goods_attr as a')->leftJoin('attributes as b', 'a.attr_id', '=', 'b.attr_id')
            ->select('a.*', 'b.attr_name', 'b.attr_type', 'b.attr_input_type', 'b.attr_values')
            ->where('a.goods_id', $id)
            ->get();
        // dd($gaData);
        return $gaData;
    }

    /**
     * 获取正在促销的商品
     * @param int $limit
     * @return Illuminate\Support\Collection
     */
    public function getPromoteGoods($limit = 5, $sort = 'desc')
    {
        $now = time();

        return DB::table('products')->select('goods_id', 'goods_name', 'shop_price', 'promote_price', 'mid_img')
            ->where('is_on_sale', '=', 1)
            ->where('promote_price', '>', 0)
            ->where('promote_start_date', '<=', $now)
            ->where('promote_end_date', '>=', $now)
            ->orderBy('sort_order', $sort)
            ->take($limit)
            ->get();
    }

    /**
     * 获取推荐类型的数据
     * @param string $recType 推荐类型
     * @param int $limit 获取的记录数
     * @param string $sort 排序
     * @return Illuminate\Support\Collection
     */
    public function getRecommendGoods(string $recType, $limit = 5, $sort = 'desc')
    {
        return DB::table('products')->select('goods_id', 'goods_name', 'shop_price', 'mid_img')
            ->where([
                'is_on_sale' => 1,
                $recType => 1
            ])
            ->orderBy('sort_order', $sort)
            ->take($limit)
            ->get();
    }

    /**
     * 通过分类获取该分类所有的商品
     * @param int $cat_id 分类id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getGoodsIdByCatId($cat_id)
    {
        // 先取出所有子分类id
        $childrenId = (new Category)->getChildren($cat_id);
        $childrenId[] = $cat_id;

        // 取出商品
        $gids = $this->select('goods_id')->whereIn('cat_id', $childrenId)->get();

        return $gids;
    }
}
