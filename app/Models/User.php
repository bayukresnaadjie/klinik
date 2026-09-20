<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'aktif',
        'no_hp',
        'last_login_at',
    'foto_profil',
    'no_telepon',
    'jabatan',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'aktif'             => 'boolean',
        'password'          => 'hashed',
    ];


    // ── Role constants ────────────────────────────────────────────
    const ROLE_ADMIN    = 'admin';
    const ROLE_APOTEKER = 'apoteker';
    const ROLE_KASIR    = 'kasir';
    const ROLE_DOKTER   = 'dokter';
const ROLE_MANAJER  = 'manajer';

    const ROLES = [
        'admin'    => 'Administrator',
        'apoteker' => 'Apoteker',
        'kasir'    => 'Kasir',
        'dokter'   => 'Dokter',    // ← tambah
    'manajer'  => 'Manajer',
    ];

    // ── Role checks ───────────────────────────────────────────────
    public function isAdmin(): bool    { return $this->role === self::ROLE_ADMIN; }
    public function isApoteker(): bool { return $this->role === self::ROLE_APOTEKER; }
    public function isKasir(): bool    { return $this->role === self::ROLE_KASIR; }
public function isDokter(): bool  { return $this->role === self::ROLE_DOKTER; }
public function isManajer(): bool { return $this->role === self::ROLE_MANAJER; }

    public function hasRole(string|array $roles): bool
    {
        return in_array($this->role, (array) $roles);
    }

    // ── Accessor: label role ──────────────────────────────────────
    public function getRoleLabelAttribute(): string
    {
        return self::ROLES[$this->role] ?? ucfirst($this->role);
    }

    // ── Accessor: inisial nama ────────────────────────────────────
    public function getInisialAttribute(): string
    {
        $words = explode(' ', trim($this->name));
        $init  = strtoupper(substr($words[0], 0, 1));
        if (count($words) > 1) $init .= strtoupper(substr(end($words), 0, 1));
        return $init;
    }

    // ── Scope ─────────────────────────────────────────────────────
    public function scopeAktif($q)    { return $q->where('aktif', true); }
    public function scopeByRole($q, $role) { return $q->where('role', $role); }
}
