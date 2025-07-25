<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropReeferMonitoringsTableAndCreateNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('reefer_monitorings');
        Schema::create('reefer_monitorings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('container_id');
            $table->date('date');
            $table->boolean('plug_off');
            $table->float('schedule_4');
            $table->float('schedule_8');
            $table->float('schedule_12');
            $table->float('schedule_16');
            $table->float('schedule_20');
            $table->float('schedule_24');
            $table->timestamps();
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
