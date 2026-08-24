<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tindak_lanjut', function (Blueprint $table) {
            $table->id('id_tindaklanjut');

            $table->unsignedBigInteger('id_pelanggaran');
            $table->unsignedBigInteger('id_user');

            $table->date('tanggal');
            $table->string('jenis_tindakan', 100);
            $table->text('hasil');

            $table->foreign('id_pelanggaran')
                ->references('id_pelanggaran')
                ->on('pelanggaran')
                ->onDelete('cascade');

            $table->foreign('id_user')
                ->references('id_user')
                ->on('user')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tindak_lanjut');
    }
};