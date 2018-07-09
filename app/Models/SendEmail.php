<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SendEmail
 */
class SendEmail extends Model
{
    protected $table = 'send_email';

    protected $primaryKey = 'ID';

	public $timestamps = false;

    protected $fillable = [
        'MailTo',
        'MailToName',
        'Subject',
        'Body',
        'Status',
        'DateTimeEntry',
        'DateTimeSend',
        'Type',
        'DescriptionType',
        'MailFrom',
        'MailFromName',
        'FromSource'
    ];

    protected $guarded = [];
}