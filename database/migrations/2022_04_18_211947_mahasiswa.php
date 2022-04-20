<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Mahasiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->string('Nim', 10)->index();
            $table->string('Nama', 255);
            $table->string('Kelas', 10);
            $table->string('Jurusan', 50);
            $table->string('No_Handphone', 15);
            $table->string('Email', 255);
            $table->string('Alamat',255);
            $table->date('TanggalLahir');
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
        Schema::dropIfExists('mahasiswa');
    }
}
