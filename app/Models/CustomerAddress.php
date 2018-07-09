<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerAddress
 */
class CustomerAddress extends Model
{
    protected $table = 'customer_address';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'AddressInfo',
        'RecepientName',
        'RecepientPhone',
        'Address',
        'PostalCode',
        'ProvinceID',
        'CityID',
        'DistrictID',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}