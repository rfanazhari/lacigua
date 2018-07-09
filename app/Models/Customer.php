<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 */
class Customer extends Model
{
    protected $table = 'customer';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerUniqueID',
        'FirstName',
        'LastName',
        'FullName',
        'Email',
        'Gender',
        'Mobile',
        'Phone',
        'DOB',
        'Username',
        'Password',
        'StoreCredit',
        'Point',
        'IsSubscribeMen',
        'IsSubscribeWomen',
        'AsGuest',
        'ReferralCustomerID',
        'CountReferral',
        'CountReferralTransaction',
        'CustomerShareLink',
        'IsActive',
        'Status',
        'LastLogin',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy',
        'permalink'
    ];

    protected $guarded = [];
}