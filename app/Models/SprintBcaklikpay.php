<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SprintBcaklikpay
 */
class SprintBcaklikpay extends Model
{
    protected $table = 'sprint_bcaklikpay';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'TransactionCode',
        'CreatedDate',
        'ExpiredDate',
        'GrandTotalUnshipping',
        'GrandTotalFee',
        'CurrencyCode',
        'Description',
        'AdditionalData',
        'ItemDetail',
        'PackageData',
        'Status',
        'InsertStatus',
        'InsertMessage',
        'InsertID',
        'PackageDataSprint',
        'TransactionStatus',
        'TransactionMessage',
        'FlagType',
        'PaymentReffID',
        'AuthCode',
        'PackageDataResponse'
    ];

    protected $guarded = [];
}