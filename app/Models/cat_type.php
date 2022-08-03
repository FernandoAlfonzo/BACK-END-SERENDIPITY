<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cat_type extends Model
{
    use HasFactory;
    protected $table = 'cat_types';
    protected $fillable = [
        'label',
        'description',
        'short_code',
        'code',
        'long_code',
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
