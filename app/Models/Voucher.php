<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Voucher
 */
class Voucher extends Model
{
    protected $table = 'voucher';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'VoucherCode',
        'VoucherAmount',
        'ValidDate',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}