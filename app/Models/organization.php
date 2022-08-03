<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organization extends Model
{
    use HasFactory;
    protected $table = 'organizations';
    protected $fillable = [
        'name_commercial',
        'name_business',
        'address',
        'RFC',
        'phone',
        'email',
        'social_networks',
        'url_logo',
        'code',
        'is_active',
        'id_adm_organization',
        'created_by',
        'updated_by',
    ];

    public $incrementing = true;
}
