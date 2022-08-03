<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commercial_product extends Model
{
    use HasFactory;
    protected $table = 'commercial_product';
    protected $fillable = [
        'name',
        'description',
        'category',
        'duration_time',
        'duration_type',
        'min_cost',
        'max_cost',
        'id_type',
        'short_code',
        'code',
        'long_code',
        'status',
        'url_image',
        'is_active',
        'id_adm_organization',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];
    public $autoincrement = true;

    public function type_service() {
        return $this->belongsTo(type_service::class, 'id_type');
    }

    public function generation() {
        return $this->hasOne(Generation::class, 'id_service');
    }
}
