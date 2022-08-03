<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'id_person',
        'enrollment',
        'status',
        'is_active',
        'id_adm_organization',
        'created_by', 
        'updated_by'
    ];

    public $incrementing = true;

    /**
         * Relación con el modelo persona
     */
    public function person() {
        return $this->belongsTo(Person::class, 'id_person');
    }
}
