<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterUserAccess
 */
class MasterUserAccess extends Model
{
    protected $table = 'master_user_access';

    protected $primaryKey = 'idAccess';

	public $timestamps = false;

    protected $fillable = [
        'idUser',
        'idMMenu',
        'access'
    ];

    protected $guarded = [];

        
}