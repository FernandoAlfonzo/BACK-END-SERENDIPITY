<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generations extends Model
{
    use HasFactory;

    protected $table = 'generations'; //generations
    protected $fillable = [
        'id_service',
        'name',
        'description',
        'modules_teachers',
        'id_coordinator',
        'name_coordinator',
        'discount',
        'start_at',
        'finish_at',
        'short_code',
        'code',
        'long_code',
        //'generation',
        'status',
        'min_price',
        'max_price',
        'payment_rules',
        'salesmen',
        'profesions',
        'consider',
        'educative_platform',
        'is_active',
        'is_private',
        'id_adm_organization',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public $incrementing = true;

    /**
         * Relación con el modelo commercial_product
     */
    public function commercial_product() {
        return $this->belongsTo(commercial_product::class, 'id_service');
    }
}
