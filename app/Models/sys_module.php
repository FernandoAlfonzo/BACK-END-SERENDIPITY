<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sys_module extends Model
{
    use HasFactory;
    protected $table = 'sys_modules';
    protected $fillable=[
        'id_parent',
        'title',
        'description',
        'active',
        'id_adm_organization',
        'register_by',
        'modify_by'
    ];

    public $incrementing = true;
}
