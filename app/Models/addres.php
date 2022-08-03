<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addres extends Model
{
    use HasFactory;
    protected $table = 'address';
    protected $fillable = [
        'id_person',
        'full_address',
        'location',
        'city',
        'state',
        'postal_code',
        'is_active',
        'id_adm_organization',
        'created_by',
        'updated_by'
    ];
}
