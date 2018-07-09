<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerVoucher
 */
class CustomerVoucher extends Model
{
    protected $table = 'customer_voucher';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'VoucherCode',
        'VoucherAmount',
        'ValidDate',
        'IsUsed'
    ];

    protected $guarded = [];
}