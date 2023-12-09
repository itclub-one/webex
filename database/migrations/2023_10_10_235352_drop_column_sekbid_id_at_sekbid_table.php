<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnSekbidIdAtSekbidTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sekbid', function (Blueprint $table) {
            // $table->dropColumn('sekbid_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sekbid', function (Blueprint $table) {
            // $table->dropColumn('sekbid_id');
        });
    }
}
