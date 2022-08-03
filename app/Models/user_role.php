<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{
    use HasFactory;
    protected $table = 'user_roles';
    protected $fillable = [
        'id_user',
        'id_role',
        'created_by',
        'updated_by',
        'id_adm_organization',
    ];
}
