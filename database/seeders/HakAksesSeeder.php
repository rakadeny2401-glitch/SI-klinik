<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HakAkses;

class HakAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HakAkses::insert([
            [
                'id_akses' => 1,
                'nama_akses' => 'Admin',
            ],
            [
                'id_akses' => 2,
                'nama_akses' => 'Dokter',
            ],
            [
                'id_akses' => 3,
                'nama_akses' => 'Pasien',
            ],
        ]);
    }
}