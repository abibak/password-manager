<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderHistory extends Model
{
    use HasFactory;

    protected $table = 'folders_history';

    public function folder()
    {
        return $this->belongsTo(OrganizationFolder::class);
    }
}
