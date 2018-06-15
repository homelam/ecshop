<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => ['web'], 'prefix'=>'admin', 'namespace'=>'Admin'], function() {
     /****************************************
     * 1. 后台主页
     * 2. 主页显示的欢迎页面
     ****************************************/
    Route::get('/index', 'IndexController@index');
    Route::get('/welcome', 'IndexController@welcome')->name('admin.welcome');

    // 商品分类模块，资源路由
    Route::resource('category', "CategoryController");

});
