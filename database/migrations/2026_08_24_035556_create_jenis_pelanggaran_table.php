<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->id('id_jenis');
            $table->string('nama_pelanggaran', 100);
            $table->string('tingkat', 50);
            $table->integer('point');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_pelanggaran');
    }
};