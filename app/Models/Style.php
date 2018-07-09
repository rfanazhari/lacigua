<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Style
 */
class Style extends Model
{
    protected $table = 'style';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Name',
        'StyleImage',
        'Priority',
        'ShowOnHeader',
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