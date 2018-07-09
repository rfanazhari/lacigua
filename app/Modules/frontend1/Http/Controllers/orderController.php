<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class orderController extends Controller
{
	// $this->_debugvar();
	public function ajaxpost()
    {
    	if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'CancelTransaction' :
                    $ID = $request['ID'];

            		if(!$ID) {
            			$data['error'][] = 'Please contact admin';
                    } else {
                    	$this->_loaddbclass(['OrderTransaction']);

                    	$OrderTransaction = $this->OrderTransaction->where([['TransactionCode', '=', $ID],['StatusOrder', '=', 0]])->first();
                    	if($OrderTransaction) {
                    		$OrderTransaction->update([
                    			'StatusOrder' => 4,
                    			'UpdatedDate' => new \DateTime('now'),
                    			'UpdatedBy' => 0
                    		]);
							$return = 'OK';
							$data = '';
                    	} else {
                        	$data['error'][] = 'Please contact admin';
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

		$this->_loaddbclass(['OrderTransaction','OrderTransactionSeller','OrderTransactionDetail']);

        $OrderTransaction = $this->OrderTransaction->leftjoin([
            ['customer as c', 'c.ID', '=', 'order_transaction.CustomerID'],
        ])->selectraw('
            c.FullName as CustomerName,
            order_transaction.*
        ')->where([
        	['order_transaction.CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
        ]);

        if(!isset($this->inv['getaction'])) {
        	$OrderTransaction = $OrderTransaction->where([['StatusOrder', '=', 0],['StatusPaid', '=', 0]]);
        } else {
        	if($this->inv['getaction'] == 'ordering')
        		$OrderTransaction = $OrderTransaction->where([['StatusPaid', '=', 1]])->where(function($query) {
        			$query->where('StatusOrder', 0)->orWhere('StatusOrder', 1);
        		});
        	if($this->inv['getaction'] == 'feedback')
        		$OrderTransaction = $OrderTransaction->where([['StatusOrder', '=', 2]]);
        	if($this->inv['getaction'] == 'history') {
        		$OrderTransaction = $OrderTransaction->where(function($query) {
        			$query->where('StatusOrder', 2)->orWhere('StatusOrder', 3)->orWhere('StatusOrder', 4);
        		});
        	}
        }

        $OrderTransaction = $OrderTransaction->get();

        if($OrderTransaction) {
        	$OrderTransaction = $OrderTransaction->toArray();
        	foreach ($OrderTransaction as $key1 => $value1) {
	        	$OrderTransaction[$key1]['ListSeller'] = $this->OrderTransactionSeller->leftjoin([
	                ['seller as s', 's.ID', '=', 'order_transaction_seller.SellerID'],
	                ['shipping as sg', 'sg.ID', '=', 'order_transaction_seller.ShippingID'],
	                ['district as d', 'd.ID', '=', 'order_transaction_seller.IDDistrict'],
	                ['city as c', 'c.ID', '=', 'd.CityID'],
	                ['province as p', 'p.ID', '=', 'd.ProvinceID'],
	            ])->selectraw('
	                s.FullName as SellerName,
	                sg.Name as ShippingName,
	                CONCAT(p.Name,"<br/>",c.Name," - ",d.Name) as DistrictName,
	                order_transaction_seller.*
	            ')->where([['TransactionCode', '=', $value1['TransactionCode']]])->get();

	            if($OrderTransaction[$key1]['ListSeller']) {
	            	$OrderTransaction[$key1]['ListSeller'] = $OrderTransaction[$key1]['ListSeller']->toArray();
	            	foreach ($OrderTransaction[$key1]['ListSeller'] as $key2 => $value2) {
                        $OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct'] = $this->OrderTransactionDetail->leftjoin([
                            ['product as p', 'p.ID', '=', 'order_transaction_detail.ProductID'],
                            ['colors as cs', 'cs.ID', '=', 'order_transaction_detail.ColorID'],
                            ['brand as b', 'b.ID', '=', 'p.BrandID'],
                            ['size_variant as sv', 'sv.ID', '=', 'order_transaction_detail.SizeVariantID'],
                            ['district as d', 'd.ID', '=', 'order_transaction_detail.DistrictID'],
                            ['city as c', 'c.ID', '=', 'order_transaction_detail.CityID'],
                            ['shipping as sg', 'sg.ID', '=', 'order_transaction_detail.ShippingID'],
                        ])->selectraw('
                            cs.Name as ColorName,
                            b.Name as BrandName,
                            sv.Name as SizeName,
                            d.Name as DistrictName,
                            c.Name as CityName,
                            sg.Name as ShippingName,
                            p.permalink as ProductPermalink,
                            p.*,
                            order_transaction_detail.*
                        ')->where([
                            ['order_transaction_detail.TransactionCode', '=', $value2['TransactionCode']],
                            ['order_transaction_detail.SellerID', '=', $value2['SellerID']],
                            ['order_transaction_detail.ShippingID', '=', $value2['ShippingID']],
                            ['order_transaction_detail.ShippingPackageID', '=', $value2['ShippingPackageID']],
                            ['order_transaction_detail.IDDistrict', '=', $value2['IDDistrict']],
                        ])->get();

                        if($OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct']) {
                        	$OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct'] = $OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct']->toArray();
                        } else $OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct'] = [];
                    }
	            } else $OrderTransaction[$key]['ListSeller'] = [];
	        }
        } else $OrderTransaction = [];

        $this->inv['OrderTransaction'] = $OrderTransaction;

        $arraypaymenttype = [
            0 => 'Bank Transfer',
            1 => 'Virtual Account',
            2 => 'Internet Banking',
            3 => 'Credit Card / Virtual Card',
            4 => 'Another / Gerai'
        ];
        $this->inv['arraypaymenttype'] = $arraypaymenttype;
        
        $arraystatusshipment = [
            0 => 'New Order',
            1 => 'Ready to Pickup',
            2 => 'Has Shipped',
            3 => 'Delivered'
        ];
        $this->inv['arraystatusshipment'] = $arraystatusshipment;
        
        $arrayrate = [
            1 => 'satu',
            2 => 'dua',
            3 => 'tiga',
            4 => 'empat',
            5 => 'lima'
        ];
        $this->inv['arrayrate'] = $arrayrate;
        
		return $this->_showviewfront(['order']);
	}
}