<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GetStoreCredit
 */
class GetStoreCredit extends Model
{
    protected $table = 'get_store_credit';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'TransactionCode',
        'FromCustomerID',
        'ToCustomerID',
        'StoreCreditAmount',
        'CreatedDate',
        'Status'
    ];

    protected $guarded = [];
}