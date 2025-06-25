<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dengan role 'admin'
        $adminUser = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.role_name', 'admin')
            ->select('users.id', 'users.username', 'users.email')
            ->first();

        if ($adminUser) {
            DB::table('admins')->insert([
                'user_id'      => $adminUser->id,
                'nama_lengkap' => ucfirst($adminUser->username), // contoh nama lengkap dari username
                'email'        => $adminUser->email,
                'no_telepon'   => '081234567890', // isi default
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]);
        }
    }
}
