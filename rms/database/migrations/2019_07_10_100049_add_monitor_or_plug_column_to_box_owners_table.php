<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonitorOrPlugColumnToBoxOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('box_owners', function (Blueprint $table) {
            $table->string('monitor_or_plug')->after('name')->default('monitor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('box_owners', function (Blueprint $table) {
            $table->dropColumn('monitor_or_plug');
        });
    }
}
