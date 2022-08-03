<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RulePayment extends Model
{
    use HasFactory;

    protected $table = 'rule_payments';
    protected $fillable = [
        'name',
        'description',
        'code',
        'registration_amount',
        'is_required',
        'period',
        'id_cat_periodicity',
        'label_cat_periodicity',
        'code_cat_periodicity',
        'id_cat_type',
        'label_cat_type',
        'code_cat_type',
        'id_cat_frequency',
        'label_cat_frequency',
        'code_cat_frequency',
        'discount',
        'included',
        'is_active',
        'id_adm_organization',
        'created_by', 
        'updated_by',
        'is_private'
    ];

    public $incrementing = true;
}
