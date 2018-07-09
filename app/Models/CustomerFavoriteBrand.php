<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerFavoriteBrand
 */
class CustomerFavoriteBrand extends Model
{
    protected $table = 'customer_favorite_brand';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'BrandID',
        'StatusFavorite',
        'CreatedDate'
    ];

    protected $guarded = [];
}