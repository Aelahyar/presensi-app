<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'admin'],
            ['role_name' => 'kepala_sekolah'],
            ['role_name' => 'wali_kelas'],
            ['role_name' => 'guru'],
            ['role_name' => 'bk'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
