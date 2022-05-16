<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class UserLogin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_folder_id',
        'name',
        'login',
        'password',
        'url',
        'tags',
        'note',
    ];

    public function folder()
    {
        return $this->belongsTo(UserFolder::class, 'user_folder_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany(FavoritePassword::class, 'user_login_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    public function setNoteAttribute($value)
    {
        $this->attributes['note'] = Crypt::encryptString($value);
    }
}
