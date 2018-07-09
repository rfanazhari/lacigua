<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Return
 */
class Return extends Model
{
    protected $table = 'return';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'ReturCode',
        'TransactionCode',
        'SenderName',
        'SenderPhone',
        'SenderAddress',
        'ProvinceID',
        'CityID',
        'DistrictID',
        'PostalCode',
        'AWBNumber',
        'CreatedDate'
    ];

    protected $guarded = [];
}