<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Guru BK
        User::create([
            'name' => 'Guru BK 1',
            'email' => 'gurubk@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru_bk',
            'kelas' => null,
            'phone' => '081234567890',
        ]);

        User::create([
            'name' => 'Ibu Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru_bk',
            'kelas' => null,
            'phone' => '081234567891',
        ]);

        // Siswa
        User::create([
            'name' => 'Ahmad Siswa',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'kelas' => 'XII-A',
            'phone' => '081234567892',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'kelas' => 'XI-B',
            'phone' => '081234567893',
        ]);

        User::create([
            'name' => 'Citra Dewi',
            'email' => 'citra@example.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'kelas' => 'X-C',
            'phone' => '081234567894',
        ]);
    }
}