<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterGroupPatern
 */
class MasterGroupPattern extends Model
{
    protected $table = 'master_group_pattern';

    protected $primaryKey = 'idGroupPattern';

	public $timestamps = false;

    protected $fillable = [
        'idGroup',
        'pattern'
    ];

    protected $guarded = [];

        
}