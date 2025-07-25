<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlugOnDateUniqueInContainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('containers', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('containers');

            if(array_key_exists('containers_unique_columns', $indexesFound))
                $table->dropUnique('containers_unique_columns');

        });
        Schema::table('containers', function (Blueprint $table) {
            $table->unique(['container_number','vessel_id','voyage_id','loading_discharging','plug_on_date'],'containers_unique_columns');
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
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('containers');

            if(array_key_exists('containers_unique_columns', $indexesFound))
                $table->dropUnique('containers_unique_columns');

        });
    }
}
