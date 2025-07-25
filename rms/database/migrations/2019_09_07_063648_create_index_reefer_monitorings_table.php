<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexReeferMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reefer_monitorings', function (Blueprint $table) {
            $table->index('container_id');
            $table->index(['container_id','date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reefer_monitorings', function (Blueprint $table) {
            $table->dropIndex('reefer_monitorings_container_id_index');
            $table->dropIndex('reefer_monitorings_container_id_date_index');
            //$table->dropIndex(['container_id','date']);
        });
    }
}
