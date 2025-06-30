<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;

    protected $table = 'catatans';

    protected $fillable = [
        'siswa_id',
        'user_id',
        'tanggal_kejadian',
        'jenis_pelanggaran',
        'deskripsi_pelanggaran',
        'status_penanganan',
        'tindakan_wali_kelas',
        'tindakan_bk',
        'tanggal_dilaporkan',
        'tanggal_selesai_penanganan',
    ];

    // Relasi
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
