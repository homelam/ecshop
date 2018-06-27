<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    //
    public function __construct()
    {
        // 获取首页导航的分类信息;
        $cateData = (new Category)->getNavData();
        // dd($cateData);
        // 所有前台页面共享
        View::share('cateData', $cateData);
    }
}
