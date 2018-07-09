<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 */
class Country extends Model
{
    protected $table = 'country';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Code',
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