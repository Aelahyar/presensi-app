<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role ID dari tabel 'roles'
        $roles = DB::table('roles')->pluck('id', 'role_name');

        // Data user yang akan dibuat
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'role_name' => 'admin',
            ],
            [
                'username' => 'kepsek',
                'email' => 'kepsek@example.com',
                'role_name' => 'kepala_sekolah',
            ],
            [
                'username' => 'walikelas',
                'email' => 'walikelas@example.com',
                'role_name' => 'wali_kelas',
            ],
            [
                'username' => 'guru',
                'email' => 'guru@example.com',
                'role_name' => 'guru',
            ],
            [
                'username' => 'bk',
                'email' => 'bk@example.com',
                'role_name' => 'bk',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => Hash::make('123'), // gunakan password default 'password'
                'role_id' => $roles[$user['role_name']],
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
