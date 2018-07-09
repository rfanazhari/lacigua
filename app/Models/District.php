<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class District
 */
class District extends Model
{
    protected $table = 'district';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CountryID',
        'ProvinceID',
        'CityID',
        'Name',
        'JNECode',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}