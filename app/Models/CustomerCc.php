<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerCc
 */
class CustomerCc extends Model
{
    protected $table = 'customer_cc';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'CCType',
        'CCNumber',
        'CCName',
        'CCMonth',
        'CCYear',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}