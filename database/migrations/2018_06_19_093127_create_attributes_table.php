<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('attr_id');
            $table->unsignedSmallInteger('type_id')->default(0)->comment('商品类型');
            $table->string('attr_name', 60)->default('')->comment('属性名称')->index('attr_name');
            $table->unsignedTinyInteger('attr_input_type')->default('1')->comment('属性录入方式');
            $table->unsignedTinyInteger('attr_type')->default('1')->comment('属性是否可选');
            $table->text('attr_values')->comment('可选值列表');
            $table->mediumInteger('sort_order')->default(50)->comment('分类显示排序,值越大，权重越高');
            $table->integer('created_time')->comment('添加时间')->index('created_time');
            $table->integer('updated_time')->comment('最后一次更新时间')->index('updated_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
