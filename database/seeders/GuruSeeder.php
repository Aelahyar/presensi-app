<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dengan role 'guru'
        $guruUser = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.role_name', 'guru')
            ->select('users.id', 'users.username', 'users.email')
            ->first();

        if ($guruUser) {
            DB::table('gurus')->insert([
                'user_id'      => $guruUser->id,
                'nama_lengkap' => ucfirst($guruUser->username),
                'nip'          => '1980' . rand(100000, 999999), // contoh NIP random
                'email'        => $guruUser->email,
                'no_telepon'   => '081234567893',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]);
        }
    }
}
