<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'access',
        'status',
    ];

    public function roles()
    {
        return $this->hasMany(AssignedRole::class);
    }
}
