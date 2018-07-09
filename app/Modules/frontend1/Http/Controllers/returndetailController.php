<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class returndetailController extends Controller
{
	public function ajaxpost()
    {
        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setfavorite' :
                	$ID = $request['ID'];
                	if(!\Session::get('customerdata')) {
                		die(json_encode(['response' => 'Silahkan Daftar atau Login terlebih dahulu !'], JSON_FORCE_OBJECT));
                	} else {
                		$this->_loaddbclass(['Brand','CustomerFavoriteBrand']);

                		$Brand = $this->Brand->where([['permalink', '=', $ID]])->first();

                		$CustomerFavoriteBrand = $this->CustomerFavoriteBrand->where([
                			['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
                			['BrandID', '=', $Brand->ID],
                		])->first();

                		$return = '';
                		if($CustomerFavoriteBrand) {
                			if($CustomerFavoriteBrand->StatusFavorite == 1) {
								$CustomerFavoriteBrand->update([
									'StatusFavorite' => 0,
									'CreatedDate' => new \DateTime("now")
	                			]);
	                			$return = 'CANCEL';
                			} else {
                				$CustomerFavoriteBrand->update([
									'StatusFavorite' => 1,
									'CreatedDate' => new \DateTime("now")
	                			]);
	                			$return = 'OK';
                			}
                		} else {
                			$this->CustomerFavoriteBrand->creates([
                				'CustomerID' => \Session::get('customerdata')['ccustomerid'],
								'BrandID' => $Brand->ID,
								'StatusFavorite' => 1,
								'CreatedDate' => new \DateTime("now")
                			]);
                			$return = 'OK';
                		}

                		die(json_encode(['response' => $return], JSON_FORCE_OBJECT));
                	}
                break;
            }
        }
    }

	public function index()
	{
		if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

		$this->_geturi();

		if(isset($this->inv['getcode'])) {
			$request = \Request::instance()->request->all();

	        $TransactionCode = $Message = $AcceptTerm = '';
	        $retur = $reason = $solution = $qty = [];
	        $errorretur = $errorreason = $errorsolution = $errorqty = [];

	        if(isset($request['submit']) && isset($request['TransactionCode'])) {
	        	$TransactionCode = $request['TransactionCode'];
		        
	        	$this->_loaddbclass(['OrderTransactionDetail']);

		        $OrderTransactionDetail = $this->OrderTransactionDetail->where([['TransactionCode', '=', $TransactionCode]])->first();

		        if($OrderTransactionDetail) {
		        	if(isset($request['retur'])) {
		        		$retur = $request['retur'];
				        $reason = $request['reason'];
				        $solution = $request['solution'];
				        $qty = $request['qty'];

		        		foreach ($retur as $key => $value) {
	        				if(!(isset($reason[$value]) && $reason[$value]))
		        				$errorreason[$value] = "borderred";
		        			if(!(isset($solution[$value]) && $solution[$value]))
		        				$errorsolution[$value] = "borderred";
		        			if(!(isset($qty[$value]) && $qty[$value]))
		        				$errorqty[$value] = "borderred";
		        		}

				        if(!isset($request['AcceptTerm']) && !$Message) {
				        	$Message = 'Anda belum menyetujui syarat dan ketentuan.';
				       	} else {
				       		$AcceptTerm = true;
				       	}
		        		if(!$Message && !count($errorreason) && !count($errorsolution) && !count($errorqty)) {
				        	$array = [];
			        		foreach ($retur as $key => $value) {
			        			$array[] = [
			        				'OrderTransactionDetailID' => $value,
			        				'Qty' => $qty[$value],
			        				'Reason' => $reason[$value],
			        				'Solution' => $solution[$value],
			        				'CreatedDate' => new \DateTime("now")
			        			];
			        		}

			        		$this->_loaddbclass(['ProductReturn']);
			        		$this->ProductReturn->inserts($array);

			        		$Message = 'Permintaan Retur anda telah kami terima, silahkan kirimkan barang yang akan di proses.';

			        		$retur = $reason = $solution = $qty = [];
	        				$errorretur = $errorreason = $errorsolution = $errorqty = [];
		        		}
		        	} else $Message = 'Silahkan pilih pesanan yang ingin di retur.';
		        }
	        }

	        $this->inv['TransactionCode'] = $TransactionCode;
	        $this->inv['Message'] = $Message;
	        $this->inv['AcceptTerm'] = $AcceptTerm;
	        $this->inv['retur'] = $retur; $this->inv['errorretur'] = $errorretur;
	        $this->inv['reason'] = $reason; $this->inv['errorreason'] = $errorreason;
	        $this->inv['solution'] = $solution; $this->inv['errorsolution'] = $errorsolution;
	        $this->inv['qty'] = $qty; $this->inv['errorqty'] = $errorqty;

			$this->_loaddbclass(['OrderTransaction','OrderTransactionSeller','OrderTransactionDetail']);

	        $OrderTransaction = $this->OrderTransaction->leftjoin([
	            ['customer as c', 'c.ID', '=', 'order_transaction.CustomerID'],
	            ['order_transaction_detail as otd', 'otd.TransactionCode', '=', 'order_transaction.TransactionCode'],
	        ])->selectraw('
	            c.FullName as CustomerName,
	            order_transaction.*
	        ')->where([
	        	['order_transaction.CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
	        	['order_transaction.TransactionCode', '=', $this->inv['getcode']],
	        ]);

	        $OrderTransaction = $OrderTransaction->where([['order_transaction.StatusPaid', '=', 1]])->where(function($query) {
				$query->where('order_transaction.StatusOrder', 0)->orWhere('order_transaction.StatusOrder', 1)->orWhere('order_transaction.StatusOrder', 2);
			});

			$OrderTransaction = $OrderTransaction->where(function($query) {
				$query->where('FeedbackDate', '>', \Carbon\Carbon::now()->subDays(7))->orWhere('FeedbackDate', null);
			});

	        $OrderTransaction = $OrderTransaction->groupBy('order_transaction.TransactionCode')->get();

	        if($OrderTransaction) {
	        	$OrderTransaction = $OrderTransaction->toArray();
	        	foreach ($OrderTransaction as $key1 => $value1) {
		        	$OrderTransaction[$key1]['ListProduct'] = $this->OrderTransactionDetail->leftjoin([
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
	                    sv.ID as SizeVariantID,
	                    sv.Name as SizeName,
	                    d.Name as DistrictName,
	                    c.Name as CityName,
	                    sg.Name as ShippingName,
	                    p.permalink as ProductPermalink,
	                    (select SUM(Qty) from product_return as pr where pr.OrderTransactionDetailID = order_transaction_detail.ID) as TotalReturnQty,
	                    (select GROUP_CONCAT(CONCAT(sv.ID,"-",sv.Name) SEPARATOR ",") from product_detail_size_variant pds
	                    	left join size_link sl on sl.SizeVariantID = pds.SizeVariantID
	                    	left join size_variant sv on sv.ID = sl.SizeVariantIDLink
	                    	where 
	                    	sv.GroupSizeID = order_transaction_detail.GroupSizeID and
	                    	pds.ProductID = p.ID) as ListSize,
	                    p.*,
	                    order_transaction_detail.*
	                ')->where([
	                    ['order_transaction_detail.TransactionCode', '=', $value1['TransactionCode']],
	                ])->get();

	                if($OrderTransaction[$key1]['ListProduct']) {
	                	$OrderTransaction[$key1]['ListProduct'] = $OrderTransaction[$key1]['ListProduct']->toArray();
	                } else $OrderTransaction[$key1]['ListProduct'] = [];
		        }
	        } else $OrderTransaction = [];
        } else $OrderTransaction = [];
        $this->inv['OrderTransaction'] = $OrderTransaction;

		return $this->_showviewfront(['returndetail']);
	}
}