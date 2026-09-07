<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'poin',
        'waktu_kejadian',
        'kronologi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'        => 'date',
            'waktu_kejadian' => 'string',
            'poin'           => 'integer',
        ];
    }

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

    public function buktiPelanggaran()
    {
        return $this->hasMany(BuktiPelanggaran::class, 'id_pelanggaran', 'id_pelanggaran');
    }

    public function tindakLanjut()
    {
        return $this->hasOne(TindakLanjut::class, 'id_pelanggaran', 'id_pelanggaran');
    }
}
