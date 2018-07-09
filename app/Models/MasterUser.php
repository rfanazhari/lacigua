<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterUser
 */
class MasterUser extends Model
{
    protected $table = 'master_user';

    protected $primaryKey = 'idUser';

	public $timestamps = false;

    protected $fillable = [
        'idGroup',
        'username',
        'pass',
        'name',
        'imagepath',
        'imagesignature',
        'address',
        'phone',
        'mobile',
        'email',
        'dateCreate',
        'loginDate',
        'statususer',
        'permalink'
    ];

    protected $guarded = [];

        
}