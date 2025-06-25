<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            KepalaSekolahSeeder::class,
            KelasSeeder::class,
            WaliKelasSeeder::class,
            GuruSeeder::class,
            BkSeeder::class,
            SiswaSeeder::class,
            MataPelajaranSeeder::class,
            LokasiPresensiSeeder::class,
            JadwalPelajaranSeeder::class,
            PresensiSiswaSeeder::class,
        ]);
    }
}
