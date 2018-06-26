<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Traits\ProductTrait;

class InventoriesController extends Controller
{
    use ProductTrait;

    /**
     * 商品库存量的编辑
     *
     * @param int $id 商品id
     */
    public function quantity(Request $request, $id)
    {
        if (!preg_match('/^[1-9]\d*$/', $id)) {
            return back()->with('status', '该商品不存在!');
        }

        // 根据商品id取出这件商品所有可选属性的值
        $gaData = $this->getGoodsAttr($id);


        // 把该二维数转为三维数组，把属性相同的放在一起
        $gaAttrs = [];
        foreach ($gaData as $k => $v) {
            $gaAttrs[$v->attr_name][] = $v;
        }

        // 查询已经保存好的库存脸设置
        $gnData = DB::table('goods_number')->where('goods_id', '=', $id)->get();
        return view('admin.products.inventory', compact('gaAttrs', 'id', 'gnData'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $gaId = $data['goods_attr_id'];
        $gn = $data['goods_number']; // 库存量

        // 计算商品属性Id和库存量的比例
        $gaIdCount = count($gaId);
        $gnCount = count($gn);
        $rate = intdiv($gaIdCount, $gnCount); // 一个库存量对应多少个可选属性组合

        $gid = 0; // 取出第几个商品属性Id
        $goodsNumbers = [];
        foreach ($gn as $k => $v) {
            $goodsAttrId = [];
            for ($i = 0; $i<$rate; $i++) {
                $goodsAttrId[] = $gaId[$gid];
                $gid++;
            }
            if ($v==0 || count($goodsAttrId) == 0) {
                continue;
            }
            // 把去出来的属性id按照升序处理
            sort($goodsAttrId, SORT_NUMERIC);
            // 把取出来的商品属性Id转化成字符串
            $gaIdStr = (string)implode(',', $goodsAttrId);
            // 以转化后的字符为下标以便去重
            $goodsNumbers[$gaIdStr] = [
                'goods_id' => $data['goods_id'],
                'goods_attr_id' => $gaIdStr,
                'goods_number' => $v
            ];
        }
        if ($goodsNumbers && $this->deleteGoodQuantityById($data['goods_id'])) {
            // 先把原来的库存量删除
            $qtyTotal = array_sum($gn);
            $result = $this->updateInventories($goodsNumbers, $data['goods_id'], $qtyTotal);
            if ($result) {
                // 成功
                return redirect('admin/products');
            }
        }
        // 失败
        return back()->with('status', '保存失败');
    }
}
