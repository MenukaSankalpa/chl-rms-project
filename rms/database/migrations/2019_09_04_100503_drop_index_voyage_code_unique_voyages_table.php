<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropIndexVoyageCodeUniqueVoyagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('voyages', function (Blueprint $table) {
//            $table->dropUnique('voyages_code_unique');
//            //$table->dropUnique('code');
//            $table->unique(['vessel_id','code']);
//        });

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
