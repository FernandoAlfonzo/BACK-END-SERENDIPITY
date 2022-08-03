<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing_information extends Model
{
    use HasFactory;
    protected $table = 'billing_informations';
    protected $fillable = [
        'id_person',
        'name',
        'tax_regime',
        'cat_id_type_person_billing',
        'cat_label_type_person_billing',
        'RFC',
        'cat_id_CFDI',
        'cat_label_CFDI',
        'address',
        'cat_id_type_payment',
        'cat_label_type_payment',
        'cat_id_way_to_pay',
        'cat_label_way_to_pay',
        'cat_id_currency',
        'cat_label_currency',
        'full_address',
        'location',
        'city',
        'state',
        'country',
        'postal_code',
        'id_address',
        'address_check',
        'is_private',
        'is_active',
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
