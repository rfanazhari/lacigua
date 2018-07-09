<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderTransactionDetail
 */
class OrderTransactionDetail extends Model
{
    protected $table = 'order_transaction_detail';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'TransactionCode',
        'ArrayIndex',
        'SellerID',
        'ShippingID',
        'ShippingPackageID',
        'IDDistrict',
        'ProductID',
        'ProductPrice',
        'Qty',
        'Weight',
        'ColorID',
        'GroupSizeID',
        'SizeVariantID',
        'Notes',
        'CustomerAddressID',
        'AddressInfo',
        'RecepientName',
        'RecepientPhone',
        'Address',
        'ProvinceID',
        'CityID',
        'DistrictID',
        'PostalCode',
        'ShippingPackage',
        'ShippingPrice',
        'FeedbackAccuration',
        'FeedbackQuality',
        'FeedbackService',
        'FeedbackDate'
    ];

    protected $guarded = [];
}