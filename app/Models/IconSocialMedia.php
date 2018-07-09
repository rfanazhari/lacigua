<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IconSocialMedia
 */
class IconSocialMedia extends Model
{
    protected $table = 'icon_social_media';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Name',
        'Image',
        'ImageHover',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}