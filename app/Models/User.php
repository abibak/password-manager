<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'email',
        'password',
        'is_admin',
        'is_blocked',
        'is_deactivate',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'deleted_at',
    ];

    public function getPasswordAttribute()
    {
        return $this->attributes['password'];
    }

    public function assigned_roles()
    {
        return $this->hasMany(AssignedRole::class);
    }

    public function folders()
    {
        return $this->hasMany(UserFolder::class);
    }

    public function settings()
    {
        return $this->hasMany(AccountSetting::class);
    }
}
