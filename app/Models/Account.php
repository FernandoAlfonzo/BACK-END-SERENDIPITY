<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'account';
    protected $fillable = [
        'id_sale',
        'original_amount',
        'subtotal',
        // 'id_generation',
        // 'label_generations',
        // 'code_generations',
        // 'start_at_generations',
        'id_user',
        'name_user',
        'last_father_name_user',
        'last_mother_name_user',
        'id_payment_rules',
        'name_rule',
        'code_rule',
        'registration_amount_rule',
        'is_required_rule',
        'period_rule',
        'id_cat_periodicity_rule',
        'label_cat_periodicity_rule',
        'code_cat_periodicity_rule',
        'id_cat_type_rule',
        'label_cat_type_rule',
        'code_cat_type_rule',
        'id_cat_frequency_rule',
        'label_cat_frequency_rule',
        'code_cat_frequency_rule',
        'discount_type_rule',
        'included_rule',
        'id_collaborator',
        'collaborator_code',
        'id_cat_type_payment',
        'label_cat_type_payment',
        'code_cat_type_payment',
        // 'id_commercial_product',
        // 'label_commercial_product',
        // 'code_commercial_product',
        // 'duration_type_commercial_product',
        'is_private',
        'is_active',
        'status',
        'alias1',
        'alias2',
        'alias3',
        'short_code',
        'code',
        'long_code',
        'id_adm_organization',
        'name_adm_organization',
        'created_by',
        'updated_by',
    ];
}
