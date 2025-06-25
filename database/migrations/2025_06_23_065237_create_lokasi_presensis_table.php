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
        Schema::create('lokasi_presensis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasi', 100)->unique();
            $table->decimal('koordinat_lat', 10, 7)->nullable();
            $table->decimal('koordinat_lon', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_presensis');
    }
};
