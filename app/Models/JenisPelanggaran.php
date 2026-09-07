<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelanggaran';
    protected $primaryKey = 'id_jenis';
    protected $fillable = [
        'nama_pelanggaran',
        'tingkat',
        'point',
    ];
    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'id_jenis', 'id_jenis');
    }
}
