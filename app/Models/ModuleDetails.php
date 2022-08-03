<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleDetails extends Model
{
    use HasFactory;

    protected $table = 'module_details';
    protected $fillable = [
        'id_generation',
        'id_coordinator',
        'module',
        'weeks_duration',
        'id_teacher',
    ];

    public $incrementing = true;
}
