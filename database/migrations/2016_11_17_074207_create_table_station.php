<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->increments('station_line_id');
            $table->integer('prov_code');
            $table->string('prov_name');
            $table->integer('prov_rank_no');
            $table->integer('rail_line_id');
            $table->string('rail_line_name');
            $table->integer('rail_line_rank_no');
            $table->integer('station_id');
            $table->string('station_name');
            $table->integer('station_rank_no');
            $table->string('area_name');
            $table->integer('integration_id');
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
        Schema::dropIfExists('stations');
    }
}
