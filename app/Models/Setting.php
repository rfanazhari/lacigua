<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 */
class Setting extends Model
{
    protected $table = 'setting';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'BannerWomen',
        'TextWomen',
        'BannerMen',
        'TextMen',
        'BannerKids',
        'TextKids',
        'BannerLabels',
        'TextLabels',
        'SubscribeAmount',
        'SocialFollowers',
        'ActiveCustomer',
        'ListBrand',
        'ActiveProduct',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}