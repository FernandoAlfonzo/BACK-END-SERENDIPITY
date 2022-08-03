<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_detail extends Model
{
    use HasFactory;
    protected $table = 'payment_detail';
    protected $fillable = [
        'id_payment',
        'id_account_calendar_detail',
        'folio',
        'folio1',
        'folio2',
        'folio3',
        'description',
        'payment_date',
        'payment_amount',
        'tax_payment_amount',
        'amount',
        'percentage_tax_amount',
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
