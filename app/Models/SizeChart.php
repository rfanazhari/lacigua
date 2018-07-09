<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SizeChart
 */
class SizeChart extends Model
{
    protected $table = 'size_chart';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'GroupSizeID',
        'ModelType',
        'CategoryID',
        'SubCategoryID',
        'Image',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}