<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Home\CommonController;
use App\Models\Product;
use App\Models\Category;

class HomeController extends CommonController
{
    protected $goodsModel;

    public function __construct(Product $goodsModel)
    {
        parent::__construct();
        $this->goodsModel = $goodsModel;
    }
    //
    public function index()
    {
        /**  推荐层   */
        // 取出推荐商品
        $promoteGoods = $this->goodsModel->getPromoteGoods();
        $newGoods = $this->goodsModel->getRecommendGoods('is_new');
        $bestGoods = $this->goodsModel->getRecommendGoods('is_best');
        $hotGoods = $this->goodsModel->getRecommendGoods('is_hot');

        //TODO: 去除楼层数据
        /* 取出楼层数据 */
        $floorData = (new Category)->getFloorData();

        return view('home.homes.index', compact('promoteGoods', 'newGoods', 'bestGoods', 'hotGoods', 'floorData'));
    }
}
