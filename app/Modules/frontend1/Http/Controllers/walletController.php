<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class walletController extends Controller
{
	// $this->_debugvar();
	public function ajaxpost()
    {
    	if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'RedeemPoint' :
                	if(!\Session::get('customerdata')) $data['error'][] = 'Please contact admin';
                	else {
                		$Point = $request['Point'];

		                if(!$Point)
	            			$data['error'][] = 'Please contact admin';
	                    else {
							$this->_loaddbclass([ 'Customer' ]);

							$Customer = $this->Customer->where([['ID','=',\Session::get('customerdata')['ccustomerid']]])->first();

	                    	if($Customer) {
	                    		if($Customer->Point > $Point) {
	                    			$this->_loaddbclass([ 'ExchangePoint' ]);

									$ExchangePoint = $this->ExchangePoint->where([['Point', '=', $Point],['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Point', 'ASC')->first();

									if($ExchangePoint) {
										$Customer->update([
			                    			'StoreCredit' => $Customer->StoreCredit + $ExchangePoint->StoreCredit,
			                    			'Point' => $Customer->Point - $ExchangePoint->Point,
			                    			'UpdatedDate' => new \DateTime('now'),
			                    			'UpdatedBy' => 0
			                    		]);

	                    				$this->_loaddbclass([ 'CustomerPointHistory' ]);

	                    				$this->CustomerPointHistory->inserts([
											'CustomerID' => \Session::get('customerdata')['ccustomerid'],
											'CreatedDate' => new \DateTime('now'),
											'Total' => $ExchangePoint->Point,
										]);

										$return = 'OK';
										$data = '';
									} else $data['error'][] = 'Please contact admin';
	                    		} else $data['error'][] = 'Point anda tidak mencukupi !';
	                    	} else $data['error'][] = 'Please contact admin';
	                    }
                	}
	                
                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
            }
        }
    }

	public function index()
	{
		$this->_geturi();

		if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

    	$this->_loaddbclass([ 'Customer' ]);

		$CustomerData = $this->Customer->where([['ID','=',\Session::get('customerdata')['ccustomerid']]])->first();
		$this->inv['CustomerData'] = $CustomerData;
		
		$LastLogin = date("l, d F Y | h:m:s", strtotime($CustomerData->LastLogin));
		$this->inv['LastLogin'] = $LastLogin;

        if(isset($this->inv['getaction']) && $this->inv['getaction'] == 'voucher') {
			$vouchercode = $errorvouchercode = '';
			
			$request = \Request::instance()->request->all();

			if(isset($request['submit'])) {
				if(isset($request['vouchercode']) && $request['vouchercode']) {
					$vouchercode = $request['vouchercode'];

					$this->_loaddbclass([ 'Voucher' ]);

					$Voucher = $this->Voucher->where([['VoucherCode', '=', $vouchercode]])->first();

					if($Voucher) {
						$this->_loaddbclass([ 'CustomerVoucher' ]);

						$CustomerVoucher = $this->CustomerVoucher->where([['VoucherCode', '=', $vouchercode]])->first();
						
						if(!$CustomerVoucher) {
							$this->CustomerVoucher->inserts([
								'CustomerID' => \Session::get('customerdata')['ccustomerid'],
								'VoucherCode' => $Voucher->VoucherCode,
								'VoucherAmount' => $Voucher->VoucherAmount,
								'ValidDate' => $Voucher->ValidDate,
								'IsUsed' => 0
							]);

							$vouchercode = '';
						} else $errorvouchercode = 'Voucher sudah ada !<br/>';
					} else $errorvouchercode = 'Voucher tidak valid !<br/>';
				} else $errorvouchercode = 'null';
			}

			if($errorvouchercode) $errorvouchercode = rtrim($errorvouchercode, '<br/>');

			$this->inv['vouchercode'] = $vouchercode;
			$this->inv['errorvouchercode'] = $errorvouchercode;

			$this->_loaddbclass([ 'CustomerVoucher' ]);

			$CustomerVoucher = $this->CustomerVoucher->getmodel()->leftJoin('order_transaction as ot', function($join) { 
	            $join->on('ot.CustomerID', '=', 'customer_voucher.CustomerID')
	            	->on('ot.VoucherCode', '=', 'customer_voucher.VoucherCode'); 
	        })->selectraw('
	        	ot.TransactionCode,
	        	customer_voucher.*
	        ')->where([['customer_voucher.CustomerID','=',\Session::get('customerdata')['ccustomerid']]])->get();
			$this->inv['CustomerVoucher'] = $CustomerVoucher;
		}

		if(isset($this->inv['getaction']) && $this->inv['getaction'] == 'points') {
			$this->_loaddbclass([ 'ExchangePoint' ]);

			$ExchangePoint = $this->ExchangePoint->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Point', 'DESC')->get();
			$this->inv['ExchangePoint'] = $ExchangePoint;

			$this->_loaddbclass([ 'CustomerPointHistory' ]);

			$CustomerPointHistory = $this->CustomerPointHistory->leftjoin([
				['order_transaction as ot', 'ot.TransactionCode', '=', 'customer_point_history.TransactionCode']
			])->where([['customer_point_history.CustomerID', '=', \Session::get('customerdata')['ccustomerid']]])
			->selectraw('
				ot.CurrencyCode,
				customer_point_history.*
			')->get();
			$this->inv['CustomerPointHistory'] = $CustomerPointHistory;
    	}

		return $this->_showviewfront(['wallet']);
	}
}