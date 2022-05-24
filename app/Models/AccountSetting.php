<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email_notification',
        'auto_logout',
    ];

    protected $casts = [
        'email_notification' => 'boolean',
        'auto_logout' => 'boolean',
    ];
}
