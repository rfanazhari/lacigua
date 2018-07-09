<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SellerPartner
 */
class SellerPartner extends Model
{
    protected $table = 'seller_partner';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CompanyName',
        'FullName',
        'Email',
        'Phone',
        'Website',
        'Note',
        'CreatedDate',
        'Approve',
        'SendEmail'
    ];

    protected $guarded = [];
}