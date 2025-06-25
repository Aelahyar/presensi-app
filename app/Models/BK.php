<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BK extends Model
{
    use HasFactory;
    protected $table = 'bk';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'no_telepon',
    ];

    // Relasi ke tabel users
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
