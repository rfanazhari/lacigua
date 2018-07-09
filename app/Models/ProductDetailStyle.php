<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductDetailStyle
 */
class ProductDetailStyle extends Model
{
    protected $table = 'product_detail_style';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'ProductID',
        'StyleID'
    ];

    protected $guarded = [];
}