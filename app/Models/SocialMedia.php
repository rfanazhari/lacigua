<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SocialMedia
 */
class SocialMedia extends Model
{
    protected $table = 'social_media';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Name',
        'IconSocialMediaID',
        'Link',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy',
        'permalink'
    ];

    protected $guarded = [];
}