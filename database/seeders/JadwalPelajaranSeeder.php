<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JadwalPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = DB::table('gurus')->pluck('id')->toArray();
        $kelas = DB::table('kelas')->pluck('id')->toArray();
        $mapels = DB::table('mata_pelajarans')->pluck('id')->toArray();
        $lokasis = DB::table('lokasi_presensis')->pluck('id')->toArray();
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        if (empty($gurus) || empty($kelas) || empty($mapels) || empty($lokasis)) {
            $this->command->warn('Data guru, kelas, mapel, atau lokasi belum tersedia. Seeder tidak dijalankan.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            // Random jam pelajaran (07:00 s.d 14:00)
            $jamMulai = Carbon::createFromTime(rand(7, 13), rand(0, 1) ? 0 : 30); // Mulai setiap 30 menit
            $jamSelesai = (clone $jamMulai)->addMinutes(90); // Durasi 1.5 jam

            DB::table('jadwal_pelajarans')->insert([
                'guru_id'     => $gurus[array_rand($gurus)],
                'kelas_id'    => $kelas[array_rand($kelas)],
                'mapel_id'    => $mapels[array_rand($mapels)],
                'lokasi_id'   => $lokasis[array_rand($lokasis)],
                'hari'        => $hariList[array_rand($hariList)],
                'jam_mulai'   => $jamMulai->format('H:i:s'),
                'jam_selesai' => $jamSelesai->format('H:i:s'),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
