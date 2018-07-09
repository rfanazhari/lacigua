<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Shipping
 */
class Shipping extends Model
{
    protected $table = 'shipping';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Name',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy',
        'permalink'
    ];

    protected $guarded = [];

    public function _child() {
        return $this->hasMany('\App\Models\ShippingPackage', 'ShippingID')->orderBy('Price');
    }
}