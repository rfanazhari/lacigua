<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterUserLogBackup
 */
class MasterUserLogBackup extends Model
{
    protected $table = 'master_user_log_backup';

    protected $primaryKey = 'idUserLog';

	public $timestamps = false;

    protected $fillable = [
        'namaGroup',
        'namaUser',
        'pageLog',
        'actionLog',
        'descLog',
        'dateLog'
    ];

    protected $guarded = [];

        
}