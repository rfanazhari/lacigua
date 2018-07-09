<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerPointHistory
 */
class CustomerPointHistory extends Model
{
    protected $table = 'customer_point_history';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'CreatedDate',
        'Total',
        'TransactionCode',
        'TransactionTotal'
    ];

    protected $guarded = [];
}