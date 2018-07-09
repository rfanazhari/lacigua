<?php

namespace App\Modules\api\Http\Controllers\sprintcallback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class bcavaController extends Controller
{
    public function index()
    {
    	$request = \Request::instance()->request->all();
        if(!count($request)) $response = ['error'];
        else {
            $this->_loaddbclass(['SprintBcava']);

            $SprintBcava = $this->SprintBcava->where([['TransactionCode', '=', $request['transactionNo']]])->first();

            if($SprintBcava) {
                $this->_loadfcclass([ 'SprintBCAVA' ]);

                $response = $this->SprintBCAVA->_response($request, $SprintBcava);

                $array = [
                    'PackageDataSprint' => json_encode($request, JSON_FORCE_OBJECT),
                    'TransactionStatus' => $request['transactionStatus'],
                    'TransactionMessage' => $request['transactionMessage'],
                    'FlagType' => $request['flagType'],
                    'PaymentReffID' => $request['paymentReffId'],
                    'AuthCode' => $request['authCode'],
                    'PackageDataResponse' => json_encode($response, JSON_FORCE_OBJECT)
                ];

                if($response['paymentStatus'] == '00') {
                    $array['Status'] = 'PAID';
                }

                $SprintBcava->update($array);
            } else {
                $response = array(
                    "channelId"           => $request['channelId'],
                    "currency"            => $request['currency'],
                    "paymentStatus"       => "",
                    "paymentMessage"      => "",
                    "flagType"            => $request['flagType'],
                    "paymentReffId"       => $request['paymentReffId'],
                );
                $response['paymentStatus']  = "01";
                $response['paymentMessage'] = "Invalid Transaction";
            }
        }

        header('Content-Type: application/json');
    	
        die(json_encode($response));
    }
}
