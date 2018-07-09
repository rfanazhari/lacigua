<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterUserLog
 */
class MasterUserLog extends Model
{
    protected $table = 'master_user_log';

    protected $primaryKey = 'idUserLog';

	public $timestamps = false;

    protected $fillable = [
        'idGroup',
        'idUser',
        'pageLog',
        'actionLog',
        'descLog',
        'dateLog'
    ];

    protected $guarded = [];

        
}