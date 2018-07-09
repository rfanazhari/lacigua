<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GroupSize
 */
class GroupSize extends Model
{
    protected $table = 'group_size';

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