<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'login_id',
        'user_id',
        'action_text',
    ];

    public function login()
    {
        return $this->belongsTo(OrganizationLogin::class);
    }
}