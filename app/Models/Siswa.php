<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'nisn',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'kelas_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Contoh relasi ke presensi siswa jika diperlukan
    // public function presensi()
    // {
    //     return $this->hasMany(PresensiSiswa::class, 'siswa_id');
    // }

    // public function nilai()
    // {
    //     return $this->hasMany(NilaiSiswa::class, 'siswa_id');
    // }
}
