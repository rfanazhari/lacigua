<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MasterMenu
 */
class MasterMenu extends Model
{
    protected $table = 'master_menu';

    protected $primaryKey = 'idMMenu';

	public $timestamps = false;

    protected $fillable = [
        'idMParrent',
        'priority',
        'name',
        'permalink',
        'menu',
        'route',
        'icon',
        'desc_en',
        'desc_id'
    ];

    protected $guarded = [];

    public function _child() {
        return $this->hasMany('\App\Models\MasterMenu', 'idMParrent')->with(['_child' => function($query) {
            $query->orderBy('priority');
        }])->orderBy('priority');
    }

    public function _getparrent() {
        return $this->hasOne('\App\Models\MasterMenu', 'idMMenu', 'idMParrent');
    }

    public function _getaction() {
        return $this->hasOne('\App\Models\MasterMenuAccess', 'idMMenu');
    }

    public function _getfunction() {
        return $this->hasOne('\App\Models\MasterUserAccess', 'idMMenu');
    }
}