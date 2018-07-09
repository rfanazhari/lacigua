<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TransferConfirmation
 */
class TransferConfirmation extends Model
{
    protected $table = 'transfer_confirmation';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'TransactionCode',
        'BankName',
        'BankBeneficiaryName',
        'GrandTotal',
        'TransferDate',
        'OurBankID',
        'ImageTransfer',
        'CreatedDate'
    ];

    protected $guarded = [];
}