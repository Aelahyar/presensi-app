<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiGuru extends Model
{
    use HasFactory;

    protected $table = 'presensi_gurus';

    protected $fillable = [
        'jadwal_id',
        'guru_id',
        'tanggal',
        'waktu_presensi',
        'status_presensi',
        'lokasi_valid',
        'keterangan',
    ];

    // Relasi
    public function jadwal()
    {
        return $this->belongsTo(JadwalPelajaran::class, 'jadwal_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
}
