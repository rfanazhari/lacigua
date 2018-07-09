<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 */
class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'SellerID',
        'BrandID',
        'ModelType',
        'CategoryID',
        'SubCategoryID',
        'TypeProduct',
        'ColorID',
        'GroupSizeID',
        'Name',
        'NameShow',
        'Description',
        'SizingDetail',
        'CurrencyCode',
        'SellingPrice',
        'SalePrice',
        'ProductGender',
        'Weight',
        'SKUPrinciple',
        'SKUSeller',
        'CompositionMaterial',
        'CareLabel',
        'Measurement',
        'MostWanted',
        'Popularity',
        'StatusNew',
        'StatusSale',
        'Image1',
        'Image2',
        'Image3',
        'Image4',
        'Image5',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy',
        'permalink'
    ];

    protected $guarded = [];
}