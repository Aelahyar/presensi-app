<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
    ];


    // Contoh relasi jika diperlukan di kemudian hari:
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function waliKelas()
    {
        return $this->hasOne(WaliKelas::class);
    }
}
