<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerDiscountCode
 */
class CustomerDiscountCode extends Model
{
    protected $table = 'customer_discount_code';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'DiscountCode',
        'DiscountAmount',
        'ExpiredDate',
        'IsUsed',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}