<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SlidingBanner
 */
class SlidingBanner extends Model
{
    protected $table = 'sliding_banner';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Banner',
        'BannerURL',
        'Title',
        'Text1',
        'SubTitle1',
        'Text2',
        'SubTitle2',
        'BgColorNote',
        'BrandName',
        'BrandBy',
        'BgColorNote2',
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