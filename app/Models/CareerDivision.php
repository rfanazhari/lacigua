<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CareerDivision
 */
class CareerDivision extends Model
{
    protected $table = 'career_division';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Name',
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