<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $fillable = [
        'id_user',
        'label',
        'description',
        'cat_type_notification_id',
        'cat_type_notification_code',
        'cat_type_notification_label',
        'status',
        'is_view',
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

    public $incrementing = true;
}
