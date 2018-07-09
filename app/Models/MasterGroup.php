<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterGroup
 */
class MasterGroup extends Model
{
    protected $table = 'master_group';

    protected $primaryKey = 'idGroup';

	public $timestamps = false;

    protected $fillable = [
        'namaGroup',
        'permalink'
    ];

    protected $guarded = [];

        
}