<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 */
class Brand extends Model
{
    protected $table = 'brand';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'SellerID',
        'Name',
        'TitleUnFeature',
        'Note',
        'MainCategory',
        'Mode',
        'Logo',
        'Banner',
        'Icon',
        'About',
        'ShowOnHeader',
        'LicenseSell',
        'LicenseFile',
        'HolidayMode',
        'Favorite',
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