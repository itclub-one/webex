<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEskulDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eskul_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eskul_id');
            $table->string('pembina')->nullable();
            $table->string('ketua')->nullable();
            $table->string('wakil_ketua')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('program_kerja')->nullable();
            $table->text('sosial_media')->nullable();
            $table->string('logo_url')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eskul_detail');
    }
}
