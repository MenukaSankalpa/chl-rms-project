<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlugOffDateTimeToContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('containers', function (Blueprint $table) {
            $table->date('plug_off_date')->nullable();
        });
        Schema::table('containers', function (Blueprint $table) {
            $table->time('plug_off_time')->nullable();
        });
        Schema::table('containers', function (Blueprint $table) {
            $table->float('plug_off_temp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('containers', function (Blueprint $table) {
            $table->dropColumn('plug_off_date');
        });
        Schema::table('containers', function (Blueprint $table) {
            $table->dropColumn('plug_off_time');
        });
        Schema::table('containers', function (Blueprint $table) {
            $table->dropColumn('plug_off_temp');
        });
    }
}
