<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'code',
        'registration_amount',
        'is_required',
        'period',
        'periodicity',
        'type',
        'frequency',
        'discount',
        'included',
        'is_active',
        'id_adm_organization',
        'created_by', 
        'updated_by',
        'is_private'
    ];
}
