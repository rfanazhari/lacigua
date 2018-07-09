<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductLink
 */
class ProductLink extends Model
{
    protected $table = 'product_link';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'ProductID',
        'ProductLinkGroup'
    ];

    protected $guarded = [];
}