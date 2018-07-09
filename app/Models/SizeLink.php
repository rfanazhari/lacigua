<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SizeLink
 */
class SizeLink extends Model
{
    protected $table = 'size_link';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'SizeVariantID',
        'SizeVariantIDLink'
    ];

    protected $guarded = [];
}