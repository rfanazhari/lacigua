<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Zipcode
 */
class Zipcode extends Model
{
    protected $table = 'zipcode';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CountryID',
        'ProvinceID',
        'CityID',
        'DistrictID',
        'VillageID',
        'PostalCode',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}