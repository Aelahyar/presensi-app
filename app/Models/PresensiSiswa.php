<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiSiswa extends Model
{
    use HasFactory;

    protected $table = 'presensi_siswas';
    protected $fillable = [
        'jadwal_id',
        'siswa_id',
        'tanggal',
        'waktu_presensi',
        'status_presensi',
        'materi',
        'guru_id',
        'keterangan',
    ];

    // Relasi
    public function jadwal()
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
