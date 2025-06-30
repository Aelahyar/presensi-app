<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar lengkap mata pelajaran dari semua gambar
        $mapelList = [
            'PKn',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Bahasa Arab',
            'Fiqih',
            'Qur\'an Hadist',
            'Akidah Akhlaq',
            'Tarikh/SKI',
            'PM Fisika',
            'PM Biologi',
            'PM Kimia',
            'MTK WAJIB',
            'PM Ekonomi',
            'PM Geografi',
            'PM Sosiologi',
            'Sejarah WAJIB',
            'Penjaskes',
            'Nahwu',
            'Falak',
            'Prakarya',
            'PM Matematika',
            'PM Sejarah',
            'LM Fisika',
            'LM Biologi',
            'LM Geografi',
            'LM Sosiologi',
            'PM Ilmu Tafsir',
            'PM Ilmu Hadis',
            'PM Ushul Fikih',
            'PM Bahasa arab',
            'LM Tahfidz Al Qur\'an',
            'TIK',
            'Bulughulmarom',
            'Jawahirulkalamiyya',
            'Alfiyah',
            'khulashoh nurulyaq',
            'Al baiquniyyah',
            'Al Amstilatuttashrif',
            'Ajjurumiyyah',
            'Hidayatul Mustafid',
            'Kifayatul\'awam',
            'Fathul Qorib',
            'Taisyir Mustholahul',
            'Attahrir',
            'Durusul falakiyyah',
            'Al\'imrithi',
            'Rohabiyyah',
            'Nadzom Almaqsud',
            'LM Bahasa Inggris',
            'Sulamunnoyiruin',
            'Dasuqi Ummul Baro',
            'Mabadi Ushul Fiqih',
        ];

        // Looping untuk memasukkan setiap mata pelajaran
        // Menggunakan updateOrInsert untuk mencegah duplikasi data
        foreach ($mapelList as $namaMapel) {
            DB::table('mata_pelajarans')->updateOrInsert(
                ['nama_mapel' => $namaMapel],
                [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
