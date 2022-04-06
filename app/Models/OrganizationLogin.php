<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationLogin extends Model
{
    use HasFactory;

    public function folder()
    {
        return $this->belongsTo(OrganizationFolder::class);
    }
}
