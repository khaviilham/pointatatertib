<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    User::create([
        'username' => 'admin',
        'nama' => 'Admin Test',
        'password' => 'password123',
        'role' => 'Kepala sekolah',
    ]);

    User::create([
        'username' => 'walikelas1',
        'nama' => 'Wali Kelas Test',
        'password' => 'password123',
        'role' => 'Wali kelas',
    ]);

    User::create([
        'username' => 'bk1',
        'nama' => 'Guru BK Test',
        'password' => 'password123',
        'role' => 'BK',
    ]);
}
}