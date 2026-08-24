<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id('id_pelanggaran');

            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_siswa');

            $table->date('tanggal');
            $table->string('lokasi', 100);
            $table->string('status', 50);

            $table->unsignedBigInteger('id_jenis');

            $table->foreign('id_user')
                ->references('id_user')
                ->on('user')
                ->onDelete('cascade');

            $table->foreign('id_siswa')
                ->references('id_siswa')
                ->on('siswa')
                ->onDelete('cascade');

            $table->foreign('id_jenis')
                ->references('id_jenis')
                ->on('jenis_pelanggaran')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};