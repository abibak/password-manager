<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class OrganizationLogin extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_folder_id',
        'name',
        'login',
        'password',
        'url',
        'tags',
        'note',
    ];

    public function folder()
    {
        return $this->belongsTo(OrganizationFolder::class, 'organization_folder_id', 'id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    public function setNoteAttribute($value)
    {
        $this->attributes['note'] = Crypt::encryptString($value);
    }
}
