<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presensi_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('siswa_id');
            $table->date('tanggal');
            $table->dateTime('waktu_presensi');
            $table->enum('status_presensi', ['Telat', 'Bolos', 'Alpa', 'Izin', 'Sakit', 'Hadir']);
            $table->text('materi');
            $table->unsignedBigInteger('guru_id');
            $table->text('keterangan')->nullable();

            // Foreign keys
            $table->foreign('jadwal_id')->references('id')->on('jadwal_pelajarans');
            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->foreign('guru_id')->references('id')->on('gurus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_siswas');
    }
};
