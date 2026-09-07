<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';
    protected $primaryKey = 'id_pelanggaran';
    protected $fillable = [
        'id_user',
        'id_siswa',
        'tanggal',
        'lokasi',
        'status',
        'id_jenis',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'id_jenis', 'id_jenis');
    }
}
