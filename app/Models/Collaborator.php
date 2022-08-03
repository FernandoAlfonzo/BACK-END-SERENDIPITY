<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    protected $table = 'collaborators';
    protected $fillable = [
        'id_person',
        'collaborator_code',
        'is_coordinator',
        'business_unit',
        'salary',
        'is_teacher',
        'is_salesmen',
        'is_organization',
        'specialties',
        'characteristics',
        'start_at',
        'finished_at',
        'id_adm_organization',
        'office_id',
        'area',
        'activities',
        'status',
        'url_photo',
        'is_active',
        'id_adm_organization',
        'created_by', 
        'updated_by',
        'created_at',
        'updated_at',
        'is_private'
    ];

    public $incrementing = true;

    /**
         * Relación con el modelo persona
     */
    public function person() {
        return $this->belongsTo(Person::class, 'id_person');
    }
}
