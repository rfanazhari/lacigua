<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubCategory
 */
class SubCategory extends Model
{
    protected $table = 'sub_category';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'IDCategory',
        'Name',
        'ShowOnHeader',
        'Priority',
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