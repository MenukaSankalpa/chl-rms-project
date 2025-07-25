<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vessel_id')->nullable();
            $table->integer('voyage_id')->nullable();
            $table->string('container_number');
            $table->enum('loading_discharging',['L','D']);
            $table->string( 'yard_location');
            $table->enum('ts_local',['TS','LOCAL']);
            $table->enum('temperature_unit',['C','F']);
            $table->float('set_temp')->nullable();
            $table->date('plug_on_date')->nullable();
            $table->time('plug_on_time')->nullable();
            $table->float('plug_on_temp')->nullable();
            $table->float('rdt_temp')->nullable();
            $table->mediumText('remarks')->nullable();
            $table->integer('ex_on_career_vessel')->nullable();
            $table->integer('ex_on_career_voyage')->nullable();
            $table->integer('box_owner')->nullable();
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
        Schema::dropIfExists('containers');
    }
}
