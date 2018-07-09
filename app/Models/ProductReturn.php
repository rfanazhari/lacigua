<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductReturn
 */
class ProductReturn extends Model
{
    protected $table = 'product_return';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'OrderTransactionDetailID',
        'Qty',
        'Reason',
        'Solution',
        'ImageBroken',
        'NewProductID',
        'NewSizeVariantID',
        'CreatedDate'
    ];

    protected $guarded = [];
}