<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationFolder extends Model
{
    use HasFactory;

    public function logins()
    {
        return $this->hasMany(OrganizationLogin::class);
    }

    public function users()
    {
        return $this->hasMany(AccessOrganizationFolder::class);
    }
}
