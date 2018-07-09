<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderTransaction
 */
class OrderTransaction extends Model
{
    protected $table = 'order_transaction';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'TransactionCode',
        'CustomerID',
        'AsGuest',
        'StoreCreditAmount',
        'VoucherCode',
        'VoucherAmount',
        'DiscountID',
        'DiscountAmount',
        'DiscountInfo',
        'CurrencyCode',
        'GrandTotal',
        'Type',
        'PaymentTypeID',
        'PaymentTypeName',
        'PaymentTypeImage',
        'AccountNumber',
        'BeneficiaryName',
        'UniqueOrder',
        'GrandTotalUnique',
        'VANumber',
        'Notes',
        'StatusOrder',
        'StatusPaid',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}