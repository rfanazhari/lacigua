<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MainCategory
 */
class MainCategory extends Model
{
    protected $table = 'main_category';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'ModelType',
        'Title',
        'Note',
        'Image',
        'URL',
        'Text1',
        'Text2',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}