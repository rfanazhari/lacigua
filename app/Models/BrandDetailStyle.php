<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BrandDetailStyle
 */
class BrandDetailStyle extends Model
{
    protected $table = 'brand_detail_style';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'BrandID',
        'StyleID'
    ];

    protected $guarded = [];
}