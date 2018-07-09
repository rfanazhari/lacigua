<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerProductWishlist
 */
class CustomerProductWishlist extends Model
{
    protected $table = 'customer_product_wishlist';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'ProductID',
        'GroupSizeID',
        'SizeVariantID',
        'StatusWishlist',
        'CreatedDate'
    ];

    protected $guarded = [];
}