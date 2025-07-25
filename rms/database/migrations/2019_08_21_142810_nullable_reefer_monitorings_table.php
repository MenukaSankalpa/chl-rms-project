<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableReeferMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reefer_monitorings', function (Blueprint $table) {
            $table->float('schedule_4')->nullable()->change();
            $table->float('schedule_8')->nullable()->change();
            $table->float('schedule_12')->nullable()->change();
            $table->float('schedule_16')->nullable()->change();
            $table->float('schedule_20')->nullable()->change();
            $table->float('schedule_24')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
