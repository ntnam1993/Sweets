<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexForTableStations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('stations')) {
            Schema::table('stations', function (Blueprint $table) {
                $table->index('prov_code');
                $table->index('rail_line_rank_no');
                $table->index('rail_line_id');
                $table->index('station_line_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('stations')) {
            Schema::table('stations', function (Blueprint $table) {
                $table->dropIndex('prov_code');
                $table->dropIndex('rail_line_rank_no');
                $table->dropIndex('rail_line_id');
                $table->dropIndex('station_line_id');
            });
        }
    }
}
