<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjut';
    protected $primaryKey = 'id_tindaklanjut';
    protected $fillable = [
        'id_pelanggaran',
        'id_user',
        'tanggal',
        'jenis_tindakan',
        'hasil',
    ];
    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class, 'id_pelanggaran', 'id_pelanggaran');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
