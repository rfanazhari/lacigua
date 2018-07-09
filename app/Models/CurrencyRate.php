<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CurrencyRate
 */
class CurrencyRate extends Model
{
    protected $table = 'currency_rate';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CurrencyCodeFrom',
        'CurrencyCodeTo',
        'Value',
        'Status',
        'IsActive',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}