<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cat_catalog extends Model
{
    use HasFactory;
    protected $table = 'cat_catalogs';
    protected $fillable = [
        'label',
        'description',
        'short_code',
        'code',
        'code2',
        'code3',        
        'long_code',
        'id_cat_types',
        'url_imagen',
        'is_active',
        'is_private', 
        'created_by',
        'updated_by',
        'alias',
        'order_number',
        'status',
        'id_adm_organization'
    ];

    public $incrementing = true;
}
