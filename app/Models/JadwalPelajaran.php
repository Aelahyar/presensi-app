<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    use HasFactory;
    protected $table = 'jadwal_pelajarans';

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mapel_id',
        'lokasi_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    // Relasi
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function lokasiPresensi()
    {
        return $this->belongsTo(LokasiPresensi::class, 'lokasi_id');
    }
}
