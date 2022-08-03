<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment';
    protected $fillable = [
        'id_account',
        'id_cat_currency',
        'currency_name',
        'currency_code',
        'id_cat_method',
        'method_name',
        'method_code',
        'id_cat_payment_type',
        'payment_type_name',
        'payment_type_code',
        'payment_code',
        'id_cat_way',
        'way_name',
        'way_code',
        'id_cat_source',
        'source_name',
        'source_code',
        'id_type_source',
        'source',
        'type_source_name',
        'type_source_code',
        'id_source',
        'source_name_aux',
        'source_code_aux',
        'id_charge_type',
        'charge_type_name',
        'charge_type_code',
        'client_account',
        'folio',
        'folio1',
        'folio2',
        'folio3',
        'description',
        'payment_date',
        'amount',
        'id_account_bank',
        'label_account_bank',
        'code_account_bank',
        'user_comment',
        'system_comment',
        'status',
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
