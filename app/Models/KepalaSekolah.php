<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KepalaSekolah extends Model
{
    use HasFactory;
    protected $table = 'kepala_sekolahs';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'no_telepon',
    ];

    // Relasi ke tabel Users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
