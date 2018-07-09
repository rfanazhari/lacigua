<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExchangePoint
 */
class ExchangePoint extends Model
{
    protected $table = 'exchange_point';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Point',
        'StoreCredit',
        'Status',
        'IsActive',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}