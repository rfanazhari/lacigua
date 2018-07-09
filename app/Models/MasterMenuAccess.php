<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterMenuAccess
 */
class MasterMenuAccess extends Model
{
    protected $table = 'master_menu_access';

    protected $primaryKey = 'idMMaccess';

	public $timestamps = false;

    protected $fillable = [
        'idMMenu',
        'idGroup'
    ];

    protected $guarded = [];

        
}