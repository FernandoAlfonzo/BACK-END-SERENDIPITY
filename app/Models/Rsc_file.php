<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rsc_file extends Model
{
    use HasFactory;

    protected $table = 'rsc_files';
    protected $fillable = [
        'id_user',
        'id_notification',
        'cat_mime_type',
        'content_type',
        'default_file',
        'extention',
        'is_blob',
        'path_file',
        'resource_file',
        'is_downloadable',
        'is_image',
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
