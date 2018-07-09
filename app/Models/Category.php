<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 */
class Category extends Model
{
    protected $table = 'category';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'ModelType',
        'Name',
        'CategoryImage',
        'ShowOnHeader',
        'Priority',
        'ColumnMode',
        'ShowOnSubHeader',
        'Favorite',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy',
        'permalink'
    ];

    protected $guarded = [];

    public function _child() {
        return $this->hasMany('\App\Models\SubCategory', 'IDCategory')->orderBy('priority');
    }
}