<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        /**
     * Jalankan migrasi.
     * Tabel 'roles' harus dijalankan sebelum tabel 'users' karena adanya foreign key.
     */
    public function up(): void
    {
        // Migrasi untuk tabel 'roles' (pastikan ini dijalankan terlebih dahulu)
        // Jika Anda sudah memiliki migrasi roles, Anda bisa mengabaikan bagian ini,
        // tapi pastikan skema roles sesuai dengan yang diharapkan (PRIMARY KEY 'id' dan kolom 'role_name').
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id(); // Ini akan menjadi 'role_id' di rancangan database kita
                $table->string('role_name')->unique(); // Contoh: 'Admin', 'Guru', 'Wali Kelas'
                $table->timestamps();
            });
        }

        // Migrasi untuk tabel 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Ini akan menjadi 'user_id' di rancangan database kita
            $table->string('username')->unique(); // Menambahkan constraint UNIQUE seperti di rancangan
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Menambahkan kolom foreign key untuk 'role_id'
            // unsignedBigInteger digunakan karena id() menghasilkan BIGINT unsigned
            $table->unsignedBigInteger('role_id');

            // Mendefinisikan foreign key constraint
            // Mengacu pada kolom 'id' di tabel 'roles' (sesuai konvensi Laravel)
            // onDelete('cascade') berarti jika sebuah role dihapus, user yang terkait juga akan dihapus.
            // Pertimbangkan apakah ini adalah perilaku yang diinginkan. Alternatif: onDelete('set null')
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Urutan drop harus dibalik dari urutan create
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
