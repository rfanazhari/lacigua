<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SaleBanner
 */
class SaleBanner extends Model
{
    protected $table = 'sale_banner';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'Title',
        'Description',
        'TextColor',
        'NoteTitle',
        'NoteDescription',
        'NoteColor',
        'Banner',
        'BannerColor',
        'IsActive',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'UpdatedDate',
        'UpdatedBy'
    ];

    protected $guarded = [];
}