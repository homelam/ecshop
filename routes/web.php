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

/****************************************
 * 后台相关的路由
 * 1. 用户登录界面
 * 2. 用户登录
 * 3. 注销登录
 ****************************************/
Route::get('/admin/login' ,'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\Auth\LoginController@login');
Route::post('/admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
Route::group(['middleware' => ['admin.auth', 'admin.permission'], 'prefix'=>'admin', 'namespace'=>'Admin'], function() {
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

        /****************************************
     * 1. 用户后台的管理路由
     * 2. 管理员后台的管理路由
     * 3. 角色的后台管理路由
     ****************************************/
    // Route::resource('/users', 'UsersController', ['only' => ['index']]);
    Route::resource('/admins', 'AdminsController');
    Route::resource('/roles', 'RolesController');
});
