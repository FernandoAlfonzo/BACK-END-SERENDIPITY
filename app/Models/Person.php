<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $table = 'persons';
    protected $fillable = [
        'name',
        'last_father_name',
        'last_mother_name',
        'gender',
        'birth_date',
        'phone',
        'facebook',
        'interest_list',
        'is_active',
        'id_adm_organization',
        'created_by', 
        'updated_by'
    ];

    public $incrementing = true;

    /**
     * Relación de la persona con los demás modelos
     */
    public function user() {
        return $this->hasOne(User::class, 'id_person');
    }

    public function collaborator() {
        return $this->hasOne(Collaborator::class, 'id_person');
    }

    public function student() {
        return $this->hasOne(Student::class, 'id_person');
    }
}
