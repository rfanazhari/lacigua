<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OurBank
 */
class OurBank extends Model
{
    protected $table = 'our_bank';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'BankName',
        'BankAccountNumber',
        'BankBeneficiaryName',
        'BankCode',
        'BankLogo',
        'BankBranch',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}