<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LokasiPresensiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasiList = [
            [
                'nama_lokasi'    => 'Gedung Utama',
                'koordinat_lat'  => -7.5654321,
                'koordinat_lon'  => 112.1234567,
            ],
            [
                'nama_lokasi'    => 'Laboratorium',
                'koordinat_lat'  => -7.5665432,
                'koordinat_lon'  => 112.1245678,
            ],
            [
                'nama_lokasi'    => 'Lapangan Sekolah',
                'koordinat_lat'  => -7.5676543,
                'koordinat_lon'  => 112.1256789,
            ],
        ];

        foreach ($lokasiList as $lokasi) {
            DB::table('lokasi_presensis')->insert([
                'nama_lokasi'   => $lokasi['nama_lokasi'],
                'koordinat_lat' => $lokasi['koordinat_lat'],
                'koordinat_lon' => $lokasi['koordinat_lon'],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }
    }
}
