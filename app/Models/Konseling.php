<?php

namespace App\Models;

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
}
