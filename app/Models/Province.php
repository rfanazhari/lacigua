<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Province
 */
class Province extends Model
{
    protected $table = 'province';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CountryID',
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