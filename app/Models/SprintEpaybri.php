<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SprintEpaybri
 */
class SprintEpaybri extends Model
{
    protected $table = 'sprint_epaybri';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'TransactionCode',
        'CreatedDate',
        'ExpiredDate',
        'GrandTotalUnshipping',
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