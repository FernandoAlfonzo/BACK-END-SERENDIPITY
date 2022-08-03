<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_module_rol extends Model
{
    use HasFactory;
    protected $table = 'user_module_rols';
    protected $fillable=[
        'id_role',
        'id_sysmodules',
        'is_active',
        'id_adm_organization',
        'access_granted',
        'register_by',
        'modify_by'
    ];

    public $incrementing = true;
}
