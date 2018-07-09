<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomerFeedback
 */
class CustomerFeedback extends Model
{
    protected $table = 'customer_feedback';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CustomerID',
        'ProductID',
        'Accuracy',
        'Quality',
        'Service',
        'Result'
    ];

    protected $guarded = [];
}