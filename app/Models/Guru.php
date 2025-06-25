<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nip',
        'email',
        'no_telepon',
    ];

    // Relasi ke tabel users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Contoh relasi ke jadwal, jika diperlukan
    // public function jadwal()
    // {
    //     return $this->hasMany(JadwalPelajaran::class, 'guru_id');
    // }
}
