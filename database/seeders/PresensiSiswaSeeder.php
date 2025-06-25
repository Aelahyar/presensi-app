<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PresensiSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $jadwals = DB::table('jadwal_pelajarans')->get();
        $siswaList = DB::table('siswas')->get();

        if ($jadwals->isEmpty() || $siswaList->isEmpty()) {
            $this->command->warn('Jadwal atau siswa tidak tersedia. Seeder tidak dijalankan.');
            return;
        }

        $statusList = ['Hadir', 'Telat', 'Izin', 'Sakit', 'Alpa', 'Bolos'];

        $today = Carbon::today();

        foreach ($jadwals as $jadwal) {
            // Ambil siswa berdasarkan kelas dari jadwal
            $siswaKelas = $siswaList->where('kelas_id', $jadwal->kelas_id);

            foreach ($siswaKelas as $siswa) {
                DB::table('presensi_siswas')->insert([
                    'jadwal_id'       => $jadwal->id,
                    'siswa_id'        => $siswa->id,
                    'tanggal'         => $today->toDateString(),
                    'waktu_presensi'  => Carbon::now(),
                    'status_presensi' => $statusList[array_rand($statusList)],
                    'materi'          => 'Materi pelajaran ' . $jadwal->mapel_id,
                    'guru_id'         => $jadwal->guru_id,
                    'keterangan'      => null,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        }
    }
}
