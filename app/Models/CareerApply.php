<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CareerApply
 */
class CareerApply extends Model
{
    protected $table = 'career_apply';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'CareerID',
        'Note',
        'CVFile',
        'PortfolioFile',
        'CreatedDate'
    ];

    protected $guarded = [];
}