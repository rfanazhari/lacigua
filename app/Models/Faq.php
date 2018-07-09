<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Faq
 */
class Faq extends Model
{
    protected $table = 'faq';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Name',
        'Image',
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