<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class accountController extends Controller
{
	// $this->_debugvar();
	public function ajaxpost()
    {
    	if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

    	$errormessage = [];

    	$this->_loaddbclass([ 'Customer' ]);

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'updatecontact' :
	                $FirstName = $request['FirstName'];
	                if(empty($FirstName)) {
		                $errormessage = array_merge($errormessage, [
		                	'FirstName' => $this->_trans('validation.mandatory', 
			                    ['value' => $this->_trans('frontend.account.FirstName')]
			                )
			            ]);
		            }

	                $LastName = $request['LastName'];
	                if(empty($LastName)) {
		                $errormessage = array_merge($errormessage, [
		                	'LastName' => $this->_trans('validation.mandatory', 
			                    ['value' => $this->_trans('frontend.account.LastName')]
			                )
			            ]);
		            }

		            $Customer = $this->Customer->where([['permalink','=',$this->_permalink($FirstName.' '.$LastName)]])->first();
		            if($Customer) {
		            	if($Customer->ID != \Session::get('customerdata')['ccustomerid']) {
		            		$errormessage = array_merge($errormessage, [
			                	'LastName' => $this->_trans('validation.already', 
				                    ['value' => $this->_trans('frontend.account.FirstName').' '.$this->_trans('frontend.account.LastName')]
				                )
				            ]);
		            	}
			        }

	                $Email = $request['Email'];
	                if(empty($Email)) {
		                $errormessage = array_merge($errormessage, [
		                	'Email' => $this->_trans('validation.mandatory', 
			                    ['value' => $this->_trans('frontend.account.Email')]
			                )
			            ]);
		            } elseif ($this->_email($Email)) {
		            	$errormessage = array_merge($errormessage, [
		                	'Email' => $this->_trans('validation.formatemail', 
			                    ['value' => $this->_trans('frontend.account.Email')]
			                )
			            ]);
		            }

		            $Customer = $this->Customer->where([['Email','=',$Email]])->first();
		            if($Customer) {
		            	if($Customer->ID != \Session::get('customerdata')['ccustomerid']) {
			            	$errormessage = array_merge($errormessage, [
			                	'Email' => $this->_trans('validation.already', 
				                    ['value' => $this->_trans('frontend.login.Email')]
				                )
				            ]);
			            }
			        }

	                $DOB = $request['DOB'];
	                if(empty($DOB)) {
		                $errormessage = array_merge($errormessage, [
		                	'DOB' => $this->_trans('validation.mandatoryselect', 
			                    ['value' => $this->_trans('frontend.account.DOB')]
			                )
			            ]);
		            }

	                $Mobile = $request['Mobile'];
	                if(empty($Mobile)) {
		                $errormessage = array_merge($errormessage, [
		                	'Mobile' => $this->_trans('validation.mandatory', 
			                    ['value' => $this->_trans('frontend.account.Mobile')]
			                )
			            ]);
		            }

		            if(!$errormessage) {
		            	$CustomerData = $this->Customer->where([['ID','=',\Session::get('customerdata')['ccustomerid']]])->first();
		            	$CustomerData->update([
		            		'FirstName' => $FirstName,
					        'LastName' => $LastName,
					        'FullName' => $FirstName.' '.$LastName,
					        'Username' => $Email,
					        'Email' => $Email,
					        'Mobile' => $Mobile,
					        'DOB' => $this->_dateformysql($DOB),
					        'permalink' => $this->_permalink($FirstName.' '.$LastName),
		            	]);
		            	
		            	die(json_encode(['response' => 'OK'], JSON_FORCE_OBJECT));
		            }

	                die(json_encode(['response' => $errormessage], JSON_FORCE_OBJECT));
                break;
                case 'updatepassword' :
	                $OldPassword = $request['OldPassword'];
	                if(empty($OldPassword)) {
		                $errormessage = array_merge($errormessage, [
		                	'OldPassword' => $this->_trans('validation.mandatory', 
			                    ['value' => $this->_trans('frontend.account.OldPassword')]
			                )
			            ]);
		            }

		            $Customer = $this->Customer->where([['ID','=',\Session::get('customerdata')['ccustomerid']]])->first();

		            if($Customer) {
                    	if(!\Hash::check($OldPassword, $Customer->Password)) {
                    		$errormessage = array_merge($errormessage, [
			                	'OldPassword' => $this->_trans('validation.notsame', 
				                    ['value' => $this->_trans('frontend.account.OldPassword')]
				                )
				            ]);
                    	}
                    }

	                $NewPassword = $request['NewPassword'];
	                if(empty($NewPassword)) {
		                $errormessage = array_merge($errormessage, [
		                	'NewPassword' => $this->_trans('validation.mandatory', 
			                    ['value' => $this->_trans('frontend.account.NewPassword')]
			                )
			            ]);
		            }

	                $ReNewPassword = $request['ReNewPassword'];
	                if(empty($ReNewPassword)) {
		                $errormessage = array_merge($errormessage, [
		                	'ReNewPassword' => $this->_trans('validation.mandatory', 
			                    ['value' => $this->_trans('frontend.account.ReNewPassword')]
			                )
			            ]);
		            }

		            if($NewPassword && $ReNewPassword) {
			        	if($NewPassword != $ReNewPassword) {
			        		$errormessage = array_merge($errormessage, [
			                	'ReNewPassword' => $this->_trans('validation.notsame', 
				                    ['value' => $this->_trans('frontend.login.ReNewPassword')]
				                )
				            ]);
			        	}
			        }

		            if(!$errormessage) {
		            	$Customer = $this->Customer->where([['ID','=',\Session::get('customerdata')['ccustomerid']]])->first();
		            	$Customer->update(['Password' => \Hash::make($NewPassword)]);

		            	die(json_encode(['response' => 'OK'], JSON_FORCE_OBJECT));
		            }

	                die(json_encode(['response' => $errormessage], JSON_FORCE_OBJECT));
                break;
                case 'GetProvince' :
	                $this->_loaddbclass([ 'Province' ]);
			        $arrprovince = $this->Province->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();

	                die(json_encode(['response' => $arrprovince], JSON_FORCE_OBJECT));
                break;
                case 'GetCity' :
                	$ProvinceID = $request['ProvinceID'];
	                $this->_loaddbclass([ 'City' ]);
        			$arrcity = $this->City->where([['ProvinceID','=',$ProvinceID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();

        			die(json_encode(['response' => $arrcity], JSON_FORCE_OBJECT));
                break;
                case 'GetDistrict' :
                	$CityID = $request['CityID'];
	                $this->_loaddbclass([ 'District' ]);
        			$arrdistrict = $this->District->where([['CityID','=',$CityID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();

        			die(json_encode(['response' => $arrdistrict], JSON_FORCE_OBJECT));
                break;
                case 'SetAddress' :
                	if(isset(\Session::get('customerdata')['ccustomerid'])) {
                		$AddressInfo = $request['AddressInfo'];
	                	$RecepientName = $request['RecepientName'];
	                	$RecepientPhone = $request['RecepientPhone'];
	                	$Address = $request['Address'];
	                	$PostalCode = $request['PostalCode'];
	                	$ProvinceID = $request['ProvinceID'];
	                	$CityID = $request['CityID'];
	                	$DistrictID = $request['DistrictID'];

		                $this->_loaddbclass([ 'CustomerAddress' ]);

		                $IsActive = 0;

		                $CustomerAddress = $this->CustomerAddress->where([['CustomerID','=',\Session::get('customerdata')['ccustomerid']]])->first();

		                if(!$CustomerAddress) $IsActive = 1;

		                $array = [
		                	'CustomerID' => \Session::get('customerdata')['ccustomerid'],
		                	'AddressInfo' => $AddressInfo,
		                	'RecepientName' => $RecepientName,
		                	'RecepientPhone' => $RecepientPhone,
		                	'Address' => $Address,
		                	'PostalCode' => $PostalCode,
		                	'ProvinceID' => $ProvinceID,
		                	'CityID' => $CityID,
		                	'DistrictID' => $DistrictID,
		                	'IsActive' => $IsActive,
		                	'Status' => 0,
		                	'CreatedDate' => new \DateTime("now"),
		                	'CreatedBy' => \Session::get('customerdata')['ccustomerid'],
		                ];

	        			$CustomerAddress = $this->CustomerAddress->creates($array);

	        			die(json_encode(['response' => 'OK', 'data' => $CustomerAddress], JSON_FORCE_OBJECT));
                	}
                break;
                case 'SetFirstAddress' :
                	if(isset(\Session::get('customerdata')['ccustomerid'])) {
                		$ID = $request['ID'];

		                $this->_loaddbclass([ 'CustomerAddress' ]);

		                foreach($this->CustomerAddress->where([['CustomerID','=',\Session::get('customerdata')['ccustomerid']]])->get() as $obj) {
		                    $obj->update([
		                    	'IsActive' => 0,
		                    	'UpdatedDate' => new \DateTime("now"),
		                    	'UpdatedBy' => \Session::get('customerdata')['ccustomerid']
		                   	]);
		                }

	        			$CustomerAddress = $this->CustomerAddress->where([['ID','=',$ID]])->first();
	        			$CustomerAddress->update([
	        				'IsActive' => 1,
							'UpdatedDate' => new \DateTime("now"),
							'UpdatedBy' => \Session::get('customerdata')['ccustomerid']
						]);

	        			die(json_encode(['response' => 'OK'], JSON_FORCE_OBJECT));
                	}
                break;
                case 'DeleteAddress' :
                	if(isset(\Session::get('customerdata')['ccustomerid'])) {
                		$ID = $request['ID'];

		                $this->_loaddbclass([ 'CustomerAddress' ]);

	        			$CustomerAddress = $this->CustomerAddress->where([['ID','=',$ID]])->first();
	        			$CustomerAddress->update([
	        				'IsActive' => 0,
	        				'Status' => 1,
	        				'UpdatedDate' => new \DateTime("now"),
							'UpdatedBy' => \Session::get('customerdata')['ccustomerid']
						]);

	        			die(json_encode(['response' => 'OK'], JSON_FORCE_OBJECT));
                	}
                break;
                case 'GetLocation' :
                	if(isset(\Session::get('customerdata')['ccustomerid'])) {
                		$ProvinceID = $request['ProvinceID'];
                		$CityID = $request['CityID'];

		                $this->_loaddbclass([ 'Province','City','District' ]);

		                $arrprovince = $this->Province->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
		                $arrcity = $this->City->where([['ProvinceID','=',$ProvinceID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
		                $arrdistrict = $this->District->where([['CityID','=',$CityID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();

	        			die(json_encode(['response' => 'OK', 'data' => ['province' => $arrprovince, 'city' => $arrcity, 'district' => $arrdistrict]], JSON_FORCE_OBJECT));
                	}
                break;
                case 'EditAddress' :
                	if(isset(\Session::get('customerdata')['ccustomerid'])) {
                		$ID = $request['ID'];

		                $this->_loaddbclass([ 'CustomerAddress' ]);

	        			$CustomerAddress = $this->CustomerAddress->where([['ID','=',$ID]])->first();

	        			die(json_encode(['response' => 'OK', 'data' => $CustomerAddress], JSON_FORCE_OBJECT));
                	}
                break;
                case 'UpdateAddress' :
                	if(isset(\Session::get('customerdata')['ccustomerid'])) {
                		$ID = $request['ID'];
                		$AddressInfo = $request['AddressInfo'];
	                	$RecepientName = $request['RecepientName'];
	                	$RecepientPhone = $request['RecepientPhone'];
	                	$Address = $request['Address'];
	                	$PostalCode = $request['PostalCode'];
	                	$ProvinceID = $request['ProvinceID'];
	                	$CityID = $request['CityID'];
	                	$DistrictID = $request['DistrictID'];

		                $this->_loaddbclass([ 'CustomerAddress' ]);

		                $CustomerAddress = $this->CustomerAddress->where([['ID','=',$ID]])->first();

		                $array = [
		                	'AddressInfo' => $AddressInfo,
		                	'RecepientName' => $RecepientName,
		                	'RecepientPhone' => $RecepientPhone,
		                	'Address' => $Address,
		                	'PostalCode' => $PostalCode,
		                	'ProvinceID' => $ProvinceID,
		                	'CityID' => $CityID,
		                	'DistrictID' => $DistrictID,
		                	'UpdatedDate' => new \DateTime("now"),
		                	'UpdatedBy' => \Session::get('customerdata')['ccustomerid'],
		                ];

	        			$CustomerAddress->update($array);

	        			die(json_encode(['response' => 'OK', 'data' => $CustomerAddress], JSON_FORCE_OBJECT));
                	}
                break;
            }
        }
    }

	public function index()
	{
		$this->_geturi();
		
		if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

		$this->_loaddbclass([ 'Customer', 'CustomerAddress', 'CustomerCc' ]);

		$CustomerData = $this->Customer->where([['ID','=',\Session::get('customerdata')['ccustomerid']]])->first();
		$this->inv['CustomerData'] = $CustomerData;
		
		$LastLogin = date("l, d F Y | h:m:s", strtotime($CustomerData->LastLogin));
		$this->inv['LastLogin'] = $LastLogin;

		$CustomerAddress = $this->CustomerAddress->leftjoin([
			['province as p', 'p.ID', '=', 'customer_address.ProvinceID'],
			['city as c', 'c.ID', '=', 'customer_address.CityID'],
			['district as d', 'd.ID', '=', 'customer_address.DistrictID']
		])->select([
			'customer_address.*',
			'p.Name as ProvinceName',
			'c.Name as CityName',
			'd.Name as DistrictName',
		])->where([['customer_address.Status','=',0],['CustomerID','=',\Session::get('customerdata')['ccustomerid']]])->get();
		$this->inv['CustomerAddress'] = $CustomerAddress;

		$CustomerCc = $this->CustomerCc->where([['CustomerID','=',\Session::get('customerdata')['ccustomerid']]])->get();
		$this->inv['CustomerCc'] = $CustomerCc;

		return $this->_showviewfront(['account']);
	}
}