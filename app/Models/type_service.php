<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_service extends Model
{
    use HasFactory;
    protected $table = 'type_service';
    protected $fillable = [
        'name',
        'description',
        'short_code',
        'code',
        'long_code',
        'is_active',
        'status',
        'id_adm_organization',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'url_image',
    ];

    public $autoincrement = true;

    public function commercial_product() {
        return $this->hasOne(commercial_product::class, 'id_type');
    }
}
