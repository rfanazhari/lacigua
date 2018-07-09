<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MainCategoryBanner
 */
class MainCategoryBanner extends Model
{
    protected $table = 'main_category_banner';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'ModelType',
        'BannerType',
        'BrandID',
        'Banner',
        'BannerURL',
        'Title',
        'Note',
        'BgColorNote',
        'BannerStart',
        'BannerEnd',
        'ShowTime',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}