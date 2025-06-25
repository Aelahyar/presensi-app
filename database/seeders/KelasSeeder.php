<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelasList = [
            ['nama_kelas' => '10A', 'tingkat' => '10'],
            ['nama_kelas' => '10B', 'tingkat' => '10'],
            ['nama_kelas' => '11A', 'tingkat' => '11'],
            ['nama_kelas' => '11B', 'tingkat' => '11'],
            ['nama_kelas' => '12A', 'tingkat' => '12'],
            ['nama_kelas' => '12B', 'tingkat' => '12'],
        ];

        foreach ($kelasList as $kelas) {
            DB::table('kelas')->insert([
                'nama_kelas' => $kelas['nama_kelas'],
                'tingkat'    => $kelas['tingkat'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
