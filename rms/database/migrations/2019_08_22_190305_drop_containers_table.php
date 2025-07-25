<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('containers');
        Schema::create('containers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vessel_id')->nullable();
            $table->integer('voyage_id')->nullable();
            $table->string('container_number');
            $table->string('loading_discharging')->nullable();
            $table->string( 'yard_location');
            $table->string('ts_local');
            $table->string('temperature_unit');
            $table->float('set_temp')->nullable();
            $table->date('plug_on_date')->nullable();
            $table->time('plug_on_time')->nullable();
            $table->float('plug_on_temp')->nullable();
            $table->float('rdt_temp')->nullable();
            $table->mediumText('remarks')->nullable();
            $table->integer('ex_on_career_vessel')->nullable();
            $table->integer('ex_on_career_voyage')->nullable();
            $table->integer('box_owner')->nullable();
            $table->integer('file_id')->nullable();
            $table->date('plug_off_date')->nullable();
            $table->time('plug_off_time')->nullable();
            $table->float('plug_off_temp')->nullable();
            $table->unique(['plug_on_date','container_number']);
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
