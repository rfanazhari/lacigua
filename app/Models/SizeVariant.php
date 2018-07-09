<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SizeVariant
 */
class SizeVariant extends Model
{
    protected $table = 'size_variant';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Type',
        'GroupSizeID',
        'ModelType',
        'CategoryID',
        'SubCategoryID',
        'Name',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}