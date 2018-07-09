<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderTransactionSeller
 */
class OrderTransactionSeller extends Model
{
    protected $table = 'order_transaction_seller';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'TransactionCode',
        'TransactionSellerCode',
        'SellerID',
        'ShippingID',
        'ShippingPackageID',
        'IDDistrict',
        'QtyProductShip',
        'WeightProductShip',
        'PriceProductShip',
        'DescProductShip',
        'ShippingPrice',
        'AWBNumber',
        'PackageData',
        'StatusShipment',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}