<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->unsignedBigInteger('created_by')->nullable();
            $table->string('nama_program');
            $table->dateTime('mula_at');
            $table->dateTime('tamat_at')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('penganjur')->nullable();
            $table->string('peringkat')->nullable();
            $table->text('agensi_terlibat')->nullable();
            $table->string('pegawai_rujukan')->nullable();
            $table->text('pautan')->nullable();
            $table->longText('catatan')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('events');
    }
}