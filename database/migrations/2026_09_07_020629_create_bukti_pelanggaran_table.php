<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('bukti_pelanggaran', function (Blueprint $table) {
        $table->id('id_bukti');
        $table->unsignedBigInteger('id_pelanggaran');
        $table->enum('jenis_bukti', ['foto', 'video', 'catatan_saksi', 'lainnya']);
        $table->string('file_path')->nullable();   // buat foto/video
        $table->text('keterangan')->nullable();    // buat catatan saksi / "lainnya"

        $table->foreign('id_pelanggaran')
            ->references('id_pelanggaran')
            ->on('pelanggaran')
            ->onDelete('cascade');

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('bukti_pelanggaran');
}
};
