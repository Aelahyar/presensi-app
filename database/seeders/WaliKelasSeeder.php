<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WaliKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dengan role 'wali kelas'
        $waliUser = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.role_name', 'wali_kelas')
            ->select('users.id', 'users.username', 'users.email')
            ->first();

        if ($waliUser) {
            DB::table('wali_kelas')->insert([
                'user_id'      => $waliUser->id,
                'nama_lengkap' => ucfirst($waliUser->username),
                'email'        => $waliUser->email,
                'no_telepon'   => '081234567892',
                'kelas_id'     => 1, // Belum ditugaskan ke kelas tertentu
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]);
        }
    }
}
