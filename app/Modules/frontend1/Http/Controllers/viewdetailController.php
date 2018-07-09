<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class viewdetailController extends Controller
{
	public function index()
	{
		if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

		$this->_geturi();

		if(isset($this->inv['getcode'])) {
			$request = \Request::instance()->request->all();

	        $TransactionCode = $Message = $AcceptTerm = '';
	        $SenderName = $SenderPhone = $SenderAddress = $PostalCode = $ProvinceID = $CityID = $DistrictID = '';
	        $errorSenderName = $errorSenderPhone = $errorSenderAddress = $errorPostalCode = $errorProvinceID = $errorCityID = $errorDistrictID = '';
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
				        $SenderName = $request['SenderName'];
				        $SenderPhone = $request['SenderPhone'];
				        $SenderAddress = $request['SenderAddress'];
				        $PostalCode = $request['PostalCode'];
				        $ProvinceID = $request['ProvinceID'];
				        $CityID = $request['CityID'];
				        $DistrictID = $request['DistrictID'];

				        if(!$SenderName) $errorSenderName = 'borderred';
				        if(!$SenderPhone) $errorSenderPhone = 'borderred';
				        if(!$SenderAddress) $errorSenderAddress = 'borderred';
				        if(!$PostalCode) $errorPostalCode = 'borderred';
				        if(!$ProvinceID) $errorProvinceID = 'borderred';
				        if(!$CityID) $errorCityID = 'borderred';
				        if(!$DistrictID) $errorDistrictID = 'borderred';

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
		        		if(!$Message && !$errorSenderName && !$errorSenderPhone && !$errorSenderAddress && !$errorPostalCode && !$errorProvinceID && !$errorCityID && !$errorDistrictID && !count($errorreason) && !count($errorsolution) && !count($errorqty)) {
		        			$ReturCode = 'RTLG' . date('ymdhis');

		        			$this->_loaddbclass(['ListReturn']);
			        		$this->ListReturn->creates([
			        			'ReturCode' => $ReturCode,
			        			'TransactionCode' => $TransactionCode,
			        			'SenderName' => $SenderName,
			        			'SenderPhone' => $SenderPhone,
			        			'SenderAddress' => $SenderAddress,
			        			'ProvinceID' => $ProvinceID,
			        			'CityID' => $CityID,
			        			'DistrictID' => $DistrictID,
			        			'PostalCode' => $PostalCode,
			        			'AWBNumber' => $PostalCode,
			        			'CreatedDate' => new \DateTime("now")
			        		]);

				        	$array = [];
			        		foreach ($retur as $key => $value) {
			        			$array[] = [
			        				'ReturCode' => $ReturCode,
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

			        		$SenderName = $SenderPhone = $SenderAddress = $PostalCode = $ProvinceID = $CityID = $DistrictID = '';
	        				$errorSenderName = $errorSenderPhone = $errorSenderAddress = $errorPostalCode = $errorProvinceID = $errorCityID = $errorDistrictID = '';
			        		$retur = $reason = $solution = $qty = [];
	        				$errorretur = $errorreason = $errorsolution = $errorqty = [];

	        				return \Redirect::to('print-return/code_'.$ReturCode);
		        		}
		        	} else $Message = 'Silahkan pilih pesanan yang ingin di retur.';
		        }
	        }

			$this->_loaddbclass(['ListReturn','ProductReturn']);

	        $ListReturn = $this->ListReturn->leftjoin([
	            ['order_transaction as ot', 'ot.TransactionCode', '=', 'list_return.TransactionCode'],
	            ['customer as c', 'c.ID', '=', 'ot.CustomerID'],
	            ['product_return as pr', 'pr.ReturCode', '=', 'list_return.ReturCode'],
	            ['order_transaction_detail as otd', 'otd.ID', '=', 'pr.OrderTransactionDetailID'],
	        ])->selectraw('
	            c.FullName as CustomerName,
	            list_return.*
	        ')->where([
	        	['ot.CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
	        	['list_return.ReturCode', '=', $this->inv['getcode']],
	        ]);

	        $ListReturn = $ListReturn->groupBy('list_return.ReturCode')->get();

	        if($ListReturn) {
	        	$ListReturn = $ListReturn->toArray();
	        	$SenderName = $ListReturn[0]['SenderName'];
	        	$SenderPhone = $ListReturn[0]['SenderPhone'];
	        	$SenderAddress = $ListReturn[0]['SenderAddress'];
	        	$ProvinceID = $ListReturn[0]['ProvinceID'];
	        	$CityID = $ListReturn[0]['CityID'];
	        	$DistrictID = $ListReturn[0]['DistrictID'];
	        	$PostalCode = $ListReturn[0]['PostalCode'];
	        	$AWBNumber = $ListReturn[0]['AWBNumber'];
	        	
	        	foreach ($ListReturn as $key1 => $value1) {
		        	$ListReturn[$key1]['ListProduct'] = $this->ProductReturn->leftjoin([
	                    ['order_transaction_detail as otd', 'otd.ID', '=', 'product_return.OrderTransactionDetailID'],
	                    ['product as p', 'p.ID', '=', 'otd.ProductID'],
	                    ['colors as cs', 'cs.ID', '=', 'otd.ColorID'],
	                    ['brand as b', 'b.ID', '=', 'p.BrandID'],
	                    ['size_variant as sv', 'sv.ID', '=', 'otd.SizeVariantID'],
	                    ['district as d', 'd.ID', '=', 'otd.DistrictID'],
	                    ['city as c', 'c.ID', '=', 'otd.CityID'],
	                    ['shipping as sg', 'sg.ID', '=', 'otd.ShippingID'],
	                ])->selectraw('
	                    cs.Name as ColorName,
	                    b.Name as BrandName,
	                    sv.Name as SizeName,
	                    d.Name as DistrictName,
	                    c.Name as CityName,
	                    sg.Name as ShippingName,
	                    p.permalink as ProductPermalink,
	                    (select SUM(Qty) from product_return as pr where pr.OrderTransactionDetailID = otd.ID) as TotalReturnQty,
	                    p.*,
	                    otd.*
	                ')->where([
	                    ['product_return.ReturCode', '=', $value1['ReturCode']],
	                ])->get();

	                if($ListReturn[$key1]['ListProduct']) {
	                	$ListReturn[$key1]['ListProduct'] = $ListReturn[$key1]['ListProduct']->toArray();
	                } else $ListReturn[$key1]['ListProduct'] = [];
		        }
	        } else $ListReturn = [];
        } else $ListReturn = [];
        $this->inv['ListReturn'] = $ListReturn;

        $this->inv['TransactionCode'] = $TransactionCode;
        $this->inv['Message'] = $Message;
        $this->inv['AcceptTerm'] = $AcceptTerm;
        $this->inv['SenderName'] = $SenderName; $this->inv['errorSenderName'] = $errorSenderName;
        $this->inv['SenderPhone'] = $SenderPhone; $this->inv['errorSenderPhone'] = $errorSenderPhone;
        $this->inv['SenderAddress'] = $SenderAddress; $this->inv['errorSenderAddress'] = $errorSenderAddress;
        $this->inv['PostalCode'] = $PostalCode; $this->inv['errorPostalCode'] = $errorPostalCode;
        $this->inv['ProvinceID'] = $ProvinceID; $this->inv['errorProvinceID'] = $errorProvinceID;
        $this->inv['CityID'] = $CityID; $this->inv['errorCityID'] = $errorCityID;
        $this->inv['DistrictID'] = $DistrictID; $this->inv['errorDistrictID'] = $errorDistrictID;
        $this->inv['retur'] = $retur; $this->inv['errorretur'] = $errorretur;
        $this->inv['reason'] = $reason; $this->inv['errorreason'] = $errorreason;
        $this->inv['solution'] = $solution; $this->inv['errorsolution'] = $errorsolution;
        $this->inv['qty'] = $qty; $this->inv['errorqty'] = $errorqty;

        $this->_loaddbclass([ 'Province' ]);
        $arrprovince = $this->Province->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrprovince'] = $arrprovince;

        $arrcity = [];
        if($ProvinceID) {
        	$this->_loaddbclass([ 'City' ]);
        	$arrcity = $this->City->where([['ProvinceID','=',$ProvinceID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        }
        $this->inv['arrcity'] = $arrcity;

        $arrdistrict = [];
        if($CityID) {
        	$this->_loaddbclass([ 'District' ]);
        	$arrdistrict = $this->District->where([['CityID','=',$CityID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        }
        $this->inv['arrdistrict'] = $arrdistrict;

		return $this->_showviewfront(['viewdetail']);
	}
}