<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->mediumIncrements('cat_id')->unsigned()->comment('分类id');
            $table->string('cat_name')->default('')->comment('分类名称')->index('cat_name');
            $table->mediumInteger('parent_id')->default('0')->comment('分类父级id')->index('parent_id');
            $table->text('cat_desc')->comment('分类描述');
            $table->unsignedTinyInteger('show_in_nav')->default(0)->comment('是否显示在导航栏,0:不显示，1: 显示');
            $table->unsignedTinyInteger('is_show')->default(1)->comment('是否显示');
            $table->mediumInteger('sort_order')->default(50)->comment('分类显示排序,值越大，权重越高');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
