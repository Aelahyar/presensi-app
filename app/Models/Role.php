<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles'; // Menentukan nama tabel secara eksplisit

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'role_name', // Kolom yang dapat diisi saat membuat atau memperbarui Role
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }
}
