<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SellerShipping
 */
class SellerShipping extends Model
{
    protected $table = 'seller_shipping';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'SellerID',
        'ShippingID'
    ];

    protected $guarded = [];
}