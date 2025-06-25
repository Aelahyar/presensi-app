<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KepalaSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dengan role 'kepala sekolah'
        $kepsekUser = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.role_name', 'kepala_sekolah')
            ->select('users.id', 'users.username', 'users.email')
            ->first();

        if ($kepsekUser) {
            DB::table('kepala_sekolahs')->insert([
                'user_id'      => $kepsekUser->id,
                'nama_lengkap' => ucfirst($kepsekUser->username),
                'email'        => $kepsekUser->email,
                'no_telepon'   => '081234567891',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]);
        }
    }
}
