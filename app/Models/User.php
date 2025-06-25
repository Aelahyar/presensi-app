<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
/**
 * @property-read \App\Models\Role|null $role
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function kepalaSekolah(): HasOne
    {
        return $this->hasOne(KepalaSekolah::class);
    }

    public function waliKelas(): HasOne
    {
        return $this->hasOne(WaliKelas::class);
    }

    public function guru(): HasOne
    {
        return $this->hasOne(Guru::class);
    }

    public function bk(): HasOne
    {
        return $this->hasOne(BK::class);
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->role_name === $roleName;
    }

    // public function profile()
    // {
    //     if ($this->isAdmin()) {
    //         return $this->hasOne(Admin::class);
    //     } elseif ($this->isKepalaSekolah()) {
    //         return $this->hasOne(KepalaSekolah::class);
    //     } elseif ($this->isWaliKelas()) {
    //         return $this->hasOne(WaliKelas::class);
    //     } elseif ($this->isGuru()) {
    //         return $this->hasOne(Guru::class);
    //     } elseif ($this->isBK()) {
    //         return $this->hasOne(BK::class);
    //     }

    //     return null;
    // }

    // // Helper untuk mendapatkan data profile
    // public function getProfileData()
    // {
    //     if ($this->isAdmin()) {
    //         return $this->admin;
    //     } elseif ($this->isKepalaSekolah()) {
    //         return $this->kepalaSekolah;
    //     } elseif ($this->isWaliKelas()) {
    //         return $this->waliKelas;
    //     } elseif ($this->isGuru()) {
    //         return $this->guru;
    //     } elseif ($this->isBK()) {
    //         return $this->bk;
    //     }

    //     return null;
    // }
}
