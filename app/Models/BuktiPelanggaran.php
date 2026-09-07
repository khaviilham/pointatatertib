<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'bukti_pelanggaran';
    protected $primaryKey = 'id_bukti';

    protected $fillable = [
        'id_pelanggaran',
        'jenis_bukti',
        'file_path',
        'keterangan',
    ];

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'id_pelanggaran', 'id_pelanggaran');
    }
}