<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessOrganizationFolder extends Model
{
    use HasFactory;

    protected $fillable = ['organization_folder_id', 'user_id', 'access'];

    public function user()
    {
        return $this->belongsTo(OrganizationFolder::class);
    }
}
