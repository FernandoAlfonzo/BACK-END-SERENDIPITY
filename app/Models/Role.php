<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'id_adm_organization',
        'created_by', 
        'updated_by'
    ];
}
