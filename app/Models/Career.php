<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Career
 */
class Career extends Model
{
    protected $table = 'career';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CareerDivisionID',
        'Position',
        'SimpleRequirement',
        'Requirement',
        'ClosedDate',
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