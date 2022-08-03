<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesmen extends Model
{
    use HasFactory;

    protected $table = 'salesmen';
    protected $fillable = [
        'id_generation',
        'id_salesmen',
    ];

    public $incrementing = true;
}
