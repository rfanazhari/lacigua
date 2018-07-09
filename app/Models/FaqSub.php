<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FaqSub
 */
class FaqSub extends Model
{
    protected $table = 'faq_sub';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'FaqID',
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