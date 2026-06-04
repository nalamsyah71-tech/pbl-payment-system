<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesertaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pesertas')->insert([
            [
                'nama' => 'Budi Santoso',
                'nis' => '2024001',
                'kelas' => 'XII RPL 1',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
                'no_hp' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ani Wijaya',
                'nis' => '2024002',
                'kelas' => 'XII RPL 1',
                'alamat' => 'Jl. Sudirman No. 5, Jakarta',
                'no_hp' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Citra Dewi',
                'nis' => '2024003',
                'kelas' => 'XII RPL 2',
                'alamat' => 'Jl. Gatot Subroto No. 15, Jakarta',
                'no_hp' => '081234567892',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Doni Prasetyo',
                'nis' => '2024004',
                'kelas' => 'XII RPL 2',
                'alamat' => 'Jl. Thamrin No. 8, Jakarta',
                'no_hp' => '081234567893',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Eka Saputri',
                'nis' => '2024005',
                'kelas' => 'XI RPL 1',
                'alamat' => 'Jl. Kuningan No. 12, Jakarta',
                'no_hp' => '081234567894',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Fajar Hidayat',
                'nis' => '2024006',
                'kelas' => 'XI RPL 1',
                'alamat' => 'Jl. Mampang No. 3, Jakarta',
                'no_hp' => '081234567895',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Gita Permata',
                'nis' => '2024007',
                'kelas' => 'XI RPL 2',
                'alamat' => 'Jl. Fatmawati No. 20, Jakarta',
                'no_hp' => '081234567896',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Hendra Gunawan',
                'nis' => '2024008',
                'kelas' => 'X RPL 1',
                'alamat' => 'Jl. Lebak Bulus No. 7, Jakarta',
                'no_hp' => '081234567897',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}