<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapelList = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Ilmu Pengetahuan Alam',
            'Ilmu Pengetahuan Sosial',
            'Pendidikan Pancasila dan Kewarganegaraan',
            'Pendidikan Jasmani',
            'Seni Budaya',
            'Prakarya',
            'Agama Islam',
        ];

        foreach ($mapelList as $namaMapel) {
            DB::table('mata_pelajarans')->insert([
                'nama_mapel' => $namaMapel,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
