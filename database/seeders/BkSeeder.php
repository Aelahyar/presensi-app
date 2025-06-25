<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dengan role 'bk'
        $bkUser = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.role_name', 'bk')
            ->select('users.id', 'users.username', 'users.email')
            ->first();

        if ($bkUser) {
            DB::table('bk')->insert([
                'user_id'      => $bkUser->id,
                'nama_lengkap' => ucfirst($bkUser->username),
                'email'        => $bkUser->email,
                'no_telepon'   => '081234567894',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]);
        }
    }
}
