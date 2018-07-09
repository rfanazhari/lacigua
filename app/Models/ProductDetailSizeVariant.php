<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductDetailSizeVariant
 */
class ProductDetailSizeVariant extends Model
{
    protected $table = 'product_detail_size_variant';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'ProductID',
        'SizeVariantID',
        'Qty',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}