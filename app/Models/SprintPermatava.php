<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SprintPermatava
 */
class SprintPermatava extends Model
{
    protected $table = 'sprint_permatava';

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