<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 */
class City extends Model
{
    protected $table = 'city';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CountryID',
        'ProvinceID',
        'Alias',
        'Name',
        'Code',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}