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
    Route::resource('categories', "CategoriesController");

    // 商品品牌模块，资源路由
    Route::resource('brands', "BrandsController");

    // 商品属性模块，资源路由
    Route::resource('types', "TypesController");

    // 商品类型对应属性列表
    // Route::resource('attributes', 'AttributesController');
    Route::get('attributes/{goods_type}', 'AttributesController@index')->name('attributes.goods_type.list');
    Route::get('attributes/create/{goods_type}', 'AttributesController@create')->name('attributes.create');

    Route::resource('attributes', 'AttributesController')->only(['store', 'destroy', 'edit', 'update']);

    // 商品模块
    Route::resource('products', 'ProductsController');


    // 图片上传
    Route::any('upload', 'CommonController@uploadImage');

    // ajax 删除商品属性
    Route::get('products/delAttr/{id}', 'ProductsController@ajaxDelAttr')->name('products.ajaxdelattr');

    // 商品库存量
    // Route::resource('inventories', 'InventoriesController');
    Route::get('quantities/{goods_id}', 'InventoriesController@quantity')->name('products.inventories.create');
    Route::post('quantities', 'InventoriesController@store')->name('products.inventories.store');
});
