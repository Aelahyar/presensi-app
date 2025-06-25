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
        Schema::create('catatans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal_kejadian');
            $table->string('jenis_pelanggaran', 255);
            $table->text('deskripsi_pelanggaran');
            $table->enum('status_penanganan', [
                'Dilaporkan',
                'Ditangani Wali Kelas',
                'Dilimpahkan ke BK',
                'Ditangani BK',
                'Selesai'
            ]);
            $table->text('tindakan_wali_kelas')->nullable();
            $table->text('tindakan_bk')->nullable();
            $table->dateTime('tanggal_dilaporkan')->useCurrent();
            $table->dateTime('tanggal_selesai_penanganan')->nullable();

            // Foreign keys
            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatans');
    }
};
