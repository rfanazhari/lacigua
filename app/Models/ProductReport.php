<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductReport
 */
class ProductReport extends Model
{
    protected $table = 'product_report';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'ProductID',
        'Reason',
        'Detail',
        'CreatedDate'
    ];

    protected $guarded = [];
}