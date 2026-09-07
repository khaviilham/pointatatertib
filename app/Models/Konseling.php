<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    use HasFactory;

    protected $table = 'konseling';
    protected $primaryKey = 'id_konseling';

    protected $fillable = [
        'tanggal',
        'permasalahan',
        'solusi_bimbingan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function sesiKonseling()
    {
        return $this->hasMany(SesiKonseling::class, 'id_konseling', 'id_konseling');
    }
}
