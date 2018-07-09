<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FaqSubDetail
 */
class FaqSubDetail extends Model
{
    protected $table = 'faq_sub_detail';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'FaqSubID',
        'Title',
        'Description',
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