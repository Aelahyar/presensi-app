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
        Schema::create('presensi_gurus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_id');
            $table->unsignedBigInteger('guru_id');
            $table->date('tanggal');
            $table->dateTime('waktu_presensi');
            $table->enum('status_presensi', ['Hadir', 'Alpa']);
            $table->boolean('lokasi_valid')->default(false);
            $table->text('keterangan')->nullable();

            // Foreign keys
            $table->foreign('jadwal_id')->references('id')->on('jadwal_pelajarans');
            $table->foreign('guru_id')->references('id')->on('gurus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_gurus');
    }
};
