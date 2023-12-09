<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnSekbidToSekbidIdAtSekbidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eskul', function (Blueprint $table) {
            $table->dropColumn('sekbid');
            $table->foreignId('sekbid_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eskul', function (Blueprint $table) {
            //
        });
    }
}
