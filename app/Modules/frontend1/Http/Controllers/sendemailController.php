<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class sendemailController extends Controller
{
    public function index()
    {
        $this->_loaddbclass([ 'SendEmail' ]);

        foreach($this->SendEmail->where([['Status', '=', 0]])->get() as $obj) {
            $condition = [
                'subject' => $obj->Subject,
                'from' => $obj->MailFrom,
                'fromname' => $obj->MailFromName,
                'to' => $obj->MailTo,
                'toname' => $obj->MailToName,
                'message' => $obj->Body,
                'successmessage' => 'success send email : ',
            ];

            $success = $this->_sendemail($condition);
            
            if($success == $condition['successmessage']) {
                $obj->update(['Status' => 1, 'DateTimeSend' => new \DateTime("now")]);
                \Log::info($condition['successmessage'].\Carbon\Carbon::now().' | '.json_encode($condition));
            } else {
                $errorforget = $success;
            }
        }
    }
}