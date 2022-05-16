<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritePassword extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'favorites_password';

    protected $fillable = [
      'organization_login_id',
      'user_login_id',
      'user_id',
    ];

    public function organization_login()
    {
        return $this->belongsTo(OrganizationLogin::class);
    }

    public function user_login()
    {
        return $this->belongsTo(UserLogin::class);
    }
}
