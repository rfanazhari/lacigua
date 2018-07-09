<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentType
 */
class PaymentType extends Model
{
    protected $table = 'payment_type';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Type',
        'OurBankID',
        'Name',
        'Notes',
        'Image',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}