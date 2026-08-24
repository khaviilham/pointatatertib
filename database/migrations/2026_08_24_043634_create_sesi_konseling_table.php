<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_konseling', function (Blueprint $table) {
            $table->id('id_sesi_konseling');

            $table->unsignedBigInteger('id_konseling');
            $table->unsignedBigInteger('id_siswa');

            $table->date('tanggal');
            $table->text('permasalahan');

            $table->foreign('id_konseling')
                ->references('id_konseling')
                ->on('konseling')
                ->onDelete('cascade');

            $table->foreign('id_siswa')
                ->references('id_siswa')
                ->on('siswa')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_konseling');
    }
};