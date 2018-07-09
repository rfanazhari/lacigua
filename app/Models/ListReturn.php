<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ListReturn
 */
class ListReturn extends Model
{
    protected $table = 'list_return';

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