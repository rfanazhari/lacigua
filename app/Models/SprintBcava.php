<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SprintBcava
 */
class SprintBcava extends Model
{
    protected $table = 'sprint_bcava';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'TransactionCode',
        'CreatedDate',
        'ExpiredDate',
        'GrandTotal',
        'CurrencyCode',
        'Description',
        'AdditionalData',
        'CustomerName',
        'ItemDetail',
        'PackageData',
        'VANumber',
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