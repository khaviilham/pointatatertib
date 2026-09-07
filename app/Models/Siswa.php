<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'id_kelas',
        'nis',
        'nama',
        'total_point',
    ];

    protected function casts(): array
    {
        return [
            'total_point' => 'integer',
        ];
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'id_siswa', 'id_siswa');
    }

    public function sesiKonseling()
    {
        return $this->hasMany(SesiKonseling::class, 'id_siswa', 'id_siswa');
    }
}
