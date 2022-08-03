<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_calendar_detail extends Model
{
    use HasFactory;
    protected $table = 'account_calendar_detail';
    protected $fillable = [
        'id_account',
        'date_calendar',
        'is_not_required',
        'status',
        'system_comment',
        'original_amount',
        'tax_charge_amount',
        'charge_amount',
        'tax_payment_amount',
        'payment_amount',
        'order_number',
        'order_number_calendar',
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
