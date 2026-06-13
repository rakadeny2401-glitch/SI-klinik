<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::insert([
            [
                'nama_admin' => 'Admin Utama',
                'waktu_jaga' => '08:00:00',
                'passwordadmin' => '123456', 
                'id_akses' => 1, 
                'no_identitas' => '1234567890123456',
            ],
        ]);
    }
}