<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Discount
 */
class Discount extends Model
{
    protected $table = 'discount';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Priority',
        'Name',
        'Description',
        'DiscountCode',
        'CityID',
        'CurrencyID',
        'Date',
        'Day',
        'DeliveryDate',
        'PaymentTypeID',
        'PaymentTypeDetailID',
        'BinNumber',
        'CategoryID',
        'ProductID',
        'SubTotal',
        'Email',
        'Quota',
        'PID',
        'NewCustomer',
        'ForCustomer',
        'ActionPercentage',
        'ActionAmount',
        'ActionProducts',
        'Status',
        'IsActive',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}