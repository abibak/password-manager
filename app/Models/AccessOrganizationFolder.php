<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessOrganizationFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'organization_folder_id',
        'user_id',
        'access'
    ];

    protected $casts = [
      'access' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folder()
    {
        return $this->belongsTo(OrganizationFolder::class);
    }
}
