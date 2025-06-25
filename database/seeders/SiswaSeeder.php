<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kelas pertama (misal: 7A)
        $kelas = DB::table('kelas')->first();

        if ($kelas) {
            $jenisKelamin = ['L', 'P'];
            $alamatList = [
                'Jl. Merpati No. 10',
                'Jl. Kenari No. 5',
                'Jl. Cendrawasih No. 7',
                'Jl. Anggrek No. 12',
                'Jl. Melati No. 3',
                'Jl. Mawar No. 18',
                'Jl. Cemara No. 9',
                'Jl. Jambu No. 22',
                'Jl. Durian No. 15',
                'Jl. Kamboja No. 8',
            ];

            for ($i = 1; $i <= 20; $i++) {
                DB::table('siswas')->insert([
                    'nisn'           => '12345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'nama_lengkap'   => 'Siswa Ke-' . $i,
                    'tanggal_lahir'  => '2010-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                    'jenis_kelamin'  => $jenisKelamin[$i % 2], // Bergantian L/P
                    'alamat'         => $alamatList[$i % count($alamatList)],
                    'kelas_id'       => $kelas->id,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ]);
            }
        }
    }
}

