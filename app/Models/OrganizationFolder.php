<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'status',
    ];

    public function logins()
    {
        return $this->hasMany(OrganizationLogin::class);
    }

    public function users()
    {
        return $this->hasMany(AccessOrganizationFolder::class);
    }

    public function history()
    {
        return $this->hasMany(FolderHistory::class);
    }
}
