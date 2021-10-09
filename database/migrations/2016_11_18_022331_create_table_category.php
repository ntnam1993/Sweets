<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('product_category_id');
            $table->integer('parent_product_category_id');
            $table->integer('order_no');
            $table->tinyInteger('level');
            $table->string('end_flg');
            $table->string('category_name');
            $table->string('image_file_name');
            $table->string('display_flg');
            $table->string('create_user_no');
            $table->timestamp('create_date')->nullable();
            $table->string('modify_user_no');
            $table->timestamp('modify_date')->nullable();
            $table->integer('data_version');
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
