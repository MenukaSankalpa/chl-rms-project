<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTemperatureColumnsInReeferMonitoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reefer_monitorings', function (Blueprint $table) {
            $table->string('schedule_4')->change();
            $table->string('schedule_8')->change();
            $table->string('schedule_12')->change();
            $table->string('schedule_16')->change();
            $table->string('schedule_20')->change();
            $table->string('schedule_24')->change();
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
            $table->float('schedule_4')->change();
            $table->float('schedule_8')->change();
            $table->float('schedule_12')->change();
            $table->float('schedule_16')->change();
            $table->float('schedule_20')->change();
            $table->float('schedule_24')->change();

        });
    }
}
