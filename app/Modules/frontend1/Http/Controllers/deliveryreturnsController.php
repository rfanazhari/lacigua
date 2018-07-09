<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class deliveryreturnsController extends Controller
{
	public function ajaxpost()
    {
        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'GoSlipReturn' :
                	if(!\Session::get('customerdata')) {
                		$return = 'Not OK';
            			$data = 'Silahkan Daftar atau Login terlebih dahulu !';
                	} else {
                		if($request['OrderID']) {
                			$OrderID = $request['OrderID'];
	                		$this->_loaddbclass(['OrderTransaction']);

	                		$OrderTransaction = $this->OrderTransaction->where([['TransactionCode', '=', $OrderID]])->first();

	                		if($OrderTransaction) {
	                			$return = 'OK';
	                			$data = $this->inv['basesite'].'print-return/code_'.$OrderID;
	                		} else {
	                			$return = 'Not OK';
	                			$data = 'Order ID tidak terdaftar !';
	                		}
                		} else {
                			$return = 'Not OK';
                			$data = 'Silahkan masukkan Order ID !';
                		}
                	}

            		die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
            }
        }
    }

	public function index()
	{
		return $this->_showviewfront(['deliveryreturns']);
	}
}