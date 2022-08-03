<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class identification extends Model
{
    use HasFactory;
    protected $table = 'identifications';
    protected $fillable = [
        'id_person',
        'code',
        'code2',
        'code3',
        'url_img', 
        'is_validate',
        'is_active',
        'id_adm_organization',
        'created_by',
        'updated_by'
    ];
}
