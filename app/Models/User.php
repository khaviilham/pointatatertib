<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'nama',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'id_user', 'id_user');
    }

    public function tindakLanjut()
    {
        return $this->hasMany(TindakLanjut::class, 'id_user', 'id_user');
    }

    public function sesiKonseling()
    {
        return $this->hasMany(SesiKonseling::class, 'id_user', 'id_user');
    }
}