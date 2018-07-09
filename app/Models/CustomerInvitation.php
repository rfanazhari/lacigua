<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerInvitation
 */
class CustomerInvitation extends Model
{
    protected $table = 'customer_invitation';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'Email',
        'StatusSend',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}