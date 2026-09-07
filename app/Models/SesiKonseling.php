<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiKonseling extends Model
{
    use HasFactory;
    protected $table = 'sesi_konseling';
    protected $primaryKey = 'id_sesi_konseling';
    protected $fillable = [
        'id_konseling',
        'id_siswa',
        'tanggal',
        'permasalahan',
    ];
    public function konseling()
    {
        return $this->belongsTo(Konseling::class, 'id_konseling', 'id_konseling');
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}
