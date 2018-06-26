<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 商品基本信息表
        Schema::create('products', function (Blueprint $table) {
            $table->increments('goods_id')->unsigned()->comment('商品id');
            $table->mediumInteger('cat_id')->unsigned()->comment('分类id');
            $table->mediumInteger('brand_id')->unsigned()->comment('品牌id');
            $table->mediumInteger('type_id')->unsigned()->comment('商品类型');
            $table->string('goods_name', 120)->default('')->comment('商品名称')->index('goods_name');
            $table->string('goods_sn', 20)->default('')->comment('商品货号')->index('goods_sn');
            $table->integer('click_count')->default(0)->comment('商品浏览次数')->index('click_count');
            $table->string('provider_name', 100)->default('')->comment('商品供应商')->index('provider_name');
            $table->mediuminteger('goods_qty')->default(0)->comment('商品数量')->index('goods_qty');
            $table->decimal('goods_weight', 10, 3)->default('0.000')->comment('商品重量')->index('godos_weight');
            $table->decimal('market_price', 10, 2)->default('0.00')->comment('市场售价');
            $table->decimal('shop_price', 10, 2)->default('0.00')->comment('本店售价');
            $table->smallInteger('virtual_sales')->default('0')->comment('虚拟销量');
            $table->decimal('promote_price', 10, 2)->default('0.00')->comment('促销价格');
            $table->integer('promote_start_date')->default(0)->comment('促销开始时间')->index('promote_start_date');
            $table->integer('promote_end_date')->default(0)->comment('商品促销结束时间')->index('promote_end_date');
            $table->unsignedTinyInteger('warn_number')->default('1')->comment('低库存提醒数量');
            $table->string('short_desc')->default('')->comment('商品简短描述');
            $table->text('description')->comment('商品描述');
            $table->string('original_img', 150)->default('')->comment('商品原图');
            $table->string('small_img', 150)->default('')->comment('商品小图');
            $table->string('mid_img', 150)->default('')->comment('商品中图');
            $table->string('big_img', 150)->default('')->comment('商品大图');
            $table->unsignedTinyInteger('is_on_sale')->default('1')->comment('是否上架');
            $table->unsignedTinyInteger('is_shipping')->default('0')->comment('是否免运费');
            $table->unsignedTinyInteger('is_best')->default('1')->comment('是否精品');
            $table->unsignedTinyInteger('is_hot')->default('1')->comment('是否热销');
            $table->unsignedTinyInteger('is_new')->default('1')->comment('是否新品');
            $table->mediumInteger('sort_order')->default(50)->comment('分类显示排序,值越大，权重越高');
            $table->integer('created_time')->comment('商品添加时间')->index('created_time');
            $table->integer('updated_time')->comment('商品最后一次更新时间')->index('updated_time');
            $table->integer('integral')->default('0')->comment('积分购买金额');
            $table->integer('give_integral')->default('-1')->comment('购买商品赠送消费积分');
            $table->integer('rank_integral')->default('-1')->comment('购买商品赠送等级积分');
            $table->string('seller_note', 150)->default('')->comment('商家寄语');
        });

        // 商品 分类中间表
        Schema::create('goods_cat', function (Blueprint $table) {
            $table->integer('goods_id')->unsigned()->comment('类型id');
            $table->mediumInteger('cat_id')->unsigned()->comment('分类id');
        });

        // 商品类型表
        Schema::create('goods_type', function (Blueprint $table) {
            $table->smallIncrements('type_id')->unsigned()->comment('商品id');
            $table->string('type_name', '60')->default('')->comment('类型名称');
            $table->unsignedTinyInteger('is_enabled')->default('1')->comment('是否启用');
            $table->string('attr_group', 255)->default('')->comment('属性分组');
        });

        // 商品相册表
        Schema::create('goods_gallery', function (Blueprint $table) {
            $table->increments('img_id')->unsigned()->comment('图片id');
            $table->integer('goods_id')->unsigned()->comment('商品id')->index('goods_id');
            $table->string('img_desc')->default('')->comment('图片描述');
            $table->string('sm_img', 150)->default('')->comment('小图');
            $table->string('thumb_img', 150)->default('')->comment('中图');
            $table->string('big_img', 150)->default('')->comment('大图');
            $table->string('original_img', 150)->default('')->comment('原图');
            $table->mediumInteger('sort_order')->default(50)->comment('分类显示排序,值越大，权重越高');
        });

        // 商品属性表
        Schema::create('goods_attr', function (Blueprint $table) {
            $table->increments('id')->unsigned()->comment('图片id');
            $table->integer('goods_id')->unsigned()->comment('商品id')->index('goods_id');
            $table->unsignedInteger('attr_id')->comment('属性id')->index('attr_id');
            $table->string('attr_value', 150)->default('')->comment('属性值');
        });

        // 商品库存量
        Schema::create('goods_number', function (Blueprint $table) {
            $table->integer('goods_id')->unsigned()->comment('商品id')->index('goods_id');
            $table->mediumInteger('goods_number')->unsigned()->default(0)->comment('商品库存量');
            $table->string('goods_attr_id', 50)->default('')->comment('商品属性表id，如果有多个，就用程序拼成字符串的形式保存');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('goods_cat');
        Schema::dropIfExists('goods_type');
        Schema::dropIfExists('goods_gallery');
        Schema::dropIfExists('goods_attr');
        Schema::dropIfExists('goods_number');
    }
}
