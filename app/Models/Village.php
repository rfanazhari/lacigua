<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Village
 */
class Village extends Model
{
    protected $table = 'village';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CountryID',
        'ProvinceID',
        'CityID',
        'DistrictID',
        'Name',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}