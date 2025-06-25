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
        Schema::create('nilai_siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('mapel_id');
            $table->unsignedBigInteger('guru_id');
            $table->string('jenis_nilai', 100);
            $table->decimal('nilai', 5, 2);
            $table->dateTime('tanggal_input')->useCurrent();
            $table->text('keterangan')->nullable();

            // Foreign keys
            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->foreign('mapel_id')->references('id')->on('mata_pelajarans');
            $table->foreign('guru_id')->references('id')->on('gurus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_siswas');
    }
};
