<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable = [
        'nama_kelas',
        'angkatan',
        'jurusan',
    ];
    public function siswa()
    {
        // hasMany(NamaModel::class, 'foreign_key_di_tabel_tujuan', 'primary_key_di_tabel_ini')
        return $this->hasMany(Siswa::class, 'id_kelas', 'id_kelas');
    }
}
