<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BrandSocialMedia
 */
class BrandSocialMedia extends Model
{
    protected $table = 'brand_social_media';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'BrandID',
        'Name',
        'IconSocialMediaID',
        'Link',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}