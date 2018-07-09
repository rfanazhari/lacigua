<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class productbeautyController extends Controller
{
	public function ajaxpost()
    {
        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'sendorder' :
                    $ProductID = $request['ProductID'];
                    $GroupSizeID = 0;
                    $SizeVariantID = $request['SizeVariantID'];
                    $Qty = $request['Qty'];
                    $ShippingID = $request['ShippingID'];
                    $ShippingPackageID = $request['ShippingPackageID'];
                    $IDCustomerAddress = $request['IDCustomerAddress'];
                    $TextAddressInfo = $request['TextAddressInfo'];
                    $TextRecepientName = $request['TextRecepientName'];
                    $TextRecepientPhone = $request['TextRecepientPhone'];
                    $TextAddress = $request['TextAddress'];
                    $IDProvince = $request['IDProvince'];
                    $TextDistrictName = $request['TextDistrictName'];
                    $IDDistrict = $request['IDDistrict'];
                    $TextCityName = $request['TextCityName'];
                    $IDCity = $request['IDCity'];
                    $TextPostalCode = $request['TextPostalCode'];
                	$Notes = $request['Notes'];

            		if(!$ProductID || !$SizeVariantID || !$Qty) {
            			$data['error'][] = 'Please contact admin';
            		} else if (!$IDDistrict) {
            			$data['error'][] = 'Please Input Address';
            		} else if (!$ShippingID) {
                        $data['error'][] = 'Please Select Delivery';
                    } else if (!$ShippingPackageID) {
                        $data['error'][] = 'Please Select Package Delivery';
                    } else {
                        $this->_loaddbclass(['Product']);

                        $Product = $this->Product->leftjoin([
                            ['brand as b', 'b.ID', '=', 'product.BrandID'],
                            ['seller as s', 's.ID', '=', 'product.SellerID'],
                            ['category as c', 'c.ID', '=', 'product.CategoryID'],
                            ['sub_category as sc', 'sc.ID', '=', 'product.SubCategoryID'],
                            ['colors as cs', 'cs.ID', '=', 'product.ColorID'],
                        ])->where([
                            ['product.ID', '=', $ProductID],
                            ['product.IsActive', '=', 1],
                            ['product.Status', '=', 0]
                        ])->selectraw('
                            product.*,
                            s.ID as SellerID,
                            s.FullName as SellerName,
                            s.PickupDistrictID as PickupDistrictID,
                            b.Name as BrandName,
                            b.permalink as BrandPermalink,
                            (CASE b.Mode
                                WHEN 0 THEN "feature"
                                WHEN 1 THEN "artist"
                                ELSE "indie"
                            END) as BrandMode,
                            c.ID as CategoryID,
                            c.Name as CategoryName,
                            sc.ID as SubCategoryID,
                            sc.Name as SubCategoryName,
                            cs.Name as ColorName,
                            cs.Hexa as ColorHexa,
                            cs.Hexa as ColorID,
                            (select GROUP_CONCAT(sc.ID SEPARATOR ",") from sub_category as sc where IDCategory = c.ID) as SubCategoryIDAll,
                            (select GROUP_CONCAT(CONCAT(sv.ID,"-",sv.Name) SEPARATOR ",") from product_detail_size_variant pdsv left join size_variant sv on pdsv.SizeVariantID = sv.ID where pdsv.ProductID = product.ID and pdsv.Status = 0) as SizeVariant
                        ');

                        $Product = $Product->first();
                        
                        if($Product) {
                            $checkkeys = '';
                            if(\Session::get('Cart')) {
                                $Cart = \Session::get('Cart');
                                foreach ($Cart as $key => $value) {
                                    if(!is_numeric($key)) continue;
                                    if(key($value) == 'SellerID-'.$Product->SellerID) {
                                        $checkkeys = $key;
                                        break;
                                    }
                                }
                            }

                            if(isset($Cart) && isset($Cart[$checkkeys]['SellerID-'.$Product->SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID])) {
                                $Cart[$checkkeys]['SellerID-'.$Product->SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID] = [$Qty,$GroupSizeID,$SizeVariantID,$Notes,$IDCustomerAddress,$TextAddressInfo,$TextRecepientName,$TextRecepientPhone,$TextAddress,$IDProvince,rtrim($TextDistrictName, ','),$IDDistrict,$TextCityName,$IDCity,$TextPostalCode];
                            } else {
                                if(is_numeric($checkkeys)) {
                                    $Cart[$checkkeys]['SellerID-'.$Product->SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID] = [$Qty,$GroupSizeID,$SizeVariantID,$Notes,$IDCustomerAddress,$TextAddressInfo,$TextRecepientName,$TextRecepientPhone,$TextAddress,$IDProvince,rtrim($TextDistrictName, ','),$IDDistrict,$TextCityName,$IDCity,$TextPostalCode];
                                } else {
                                    $Cart[]['SellerID-'.$Product->SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID] = [$Qty,$GroupSizeID,$SizeVariantID,$Notes,$IDCustomerAddress,$TextAddressInfo,$TextRecepientName,$TextRecepientPhone,$TextAddress,$IDProvince,rtrim($TextDistrictName, ','),$IDDistrict,$TextCityName,$IDCity,$TextPostalCode];
                                }
                            }

                            \Session::put('Cart', $Cart);
                            \Session::save();

                            $return = 'OK';

                            $data = $this->_constructViewCart($Cart);
                        } else {
                            $data['error'][] = 'Please contact admin';
                        }
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'getsize' :
                    $ModelType = $request['ModelType'];
                	$CategoryID = $request['CategoryID'];
                    $SubCategoryID = $request['SubCategoryID'];
                	$ProductID = $request['ProductID'];

            		$this->_loaddbclass(['Product','ProductDetailSizeVariant']);
                    
                    $Product = $this->Product->where([['ID', '=', $ProductID]])->first();

                    $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->leftjoin([
                        ['size_variant as sv', 'sv.ID', '=', 'product_detail_size_variant.SizeVariantID']
                    ])->where([
                        ['ProductID', '=', $ProductID],
                        ['product_detail_size_variant.Status', '=', 0],
                    ])->selectraw('
                        sv.ID as SizeVariantID,
                        sv.Name as SizeName,
                        product_detail_size_variant.Qty as SizeQty
                    ')->get();

                    $link_size = '';
                    if($ProductDetailSizeVariant) {
                        $response = 'OK';
                        $data = $ProductDetailSizeVariant->toArray();
                    } else {
                        $response = 'Not OK';
                        $data = '';
                    }
        			die(json_encode(['response' => $response, 'data' => $data, 'link_size' => $link_size], JSON_FORCE_OBJECT));
                break;
                case 'setwishlist' :
                    $ID = $request['ID'];
                	$SizeVariantID = $request['SizeVariantID'];
                	if(!\Session::get('customerdata')) {
                		die(json_encode(['response' => 'Silahkan Daftar atau Login terlebih dahulu !'], JSON_FORCE_OBJECT));
                	} else {
                		$this->_loaddbclass(['CustomerProductWishlist']);

                		$CustomerProductWishlist = $this->CustomerProductWishlist->where([
                			['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
                			['ProductID', '=', $ID],
                		])->first();

                		$return = '';
                		if($CustomerProductWishlist) {
                			if($CustomerProductWishlist->StatusWishlist == 1) {
								$CustomerProductWishlist->update([
                                    'SizeVariantID' => $SizeVariantID,
									'StatusWishlist' => 0,
									'CreatedDate' => new \DateTime("now")
	                			]);
	                			$return = 'CANCEL';
                			} else {
                				$CustomerProductWishlist->update([
                                    'SizeVariantID' => $SizeVariantID,
									'StatusWishlist' => 1,
									'CreatedDate' => new \DateTime("now")
	                			]);
	                			$return = 'OK';
                			}
                		} else {
                			$this->CustomerProductWishlist->creates([
                				'CustomerID' => \Session::get('customerdata')['ccustomerid'],
                                'ProductID' => $ID,
								'SizeVariantID' => $SizeVariantID,
								'StatusWishlist' => 1,
								'CreatedDate' => new \DateTime("now")
                			]);
                			$return = 'OK';
                		}

                		die(json_encode(['response' => $return], JSON_FORCE_OBJECT));
                	}
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
                case 'GetCityDistrict' :
                    $ProvinceID = $request['ProvinceID'];
                    $CityID = $request['CityID'];

                    $this->_loaddbclass([ 'City','District' ]);
                    $arrcity = $this->City->where([['ProvinceID','=',$ProvinceID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
                    $arrdistrict = $this->District->where([['CityID','=',$CityID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();

                    die(json_encode(['arrcity' => $arrcity, 'arrdistrict' => $arrdistrict], JSON_FORCE_OBJECT));
                break;
                case 'SetAddress' :
                    $AddressInfo = $request['AddressInfo'];
                    $RecepientName = $request['RecepientName'];
                    $RecepientPhone = $request['RecepientPhone'];
                    $Address = $request['Address'];
                    $PostalCode = $request['PostalCode'];
                    $ProvinceID = $request['ProvinceID'];
                    $CityID = $request['CityID'];
                    $DistrictID = $request['DistrictID'];

                    if(isset(\Session::get('customerdata')['ccustomerid'])) {
                        $this->_loaddbclass([ 'CustomerAddress' ]);

                        foreach($this->CustomerAddress->where([['IsActive','=',1],['CustomerID','=',\Session::get('customerdata')['ccustomerid']]])->get() as $obj) {
                            $obj->update([
                                'IsActive' => 0,
                                'UpdatedDate' => new \DateTime("now"),
                                'UpdatedBy' => \Session::get('customerdata')['ccustomerid']
                            ]);
                        }

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
                            'IsActive' => 1,
                            'Status' => 0,
                            'CreatedDate' => new \DateTime("now"),
                            'CreatedBy' => \Session::get('customerdata')['ccustomerid'],
                        ];

                        $CustomerAddress = $this->CustomerAddress->creates($array);

                        die(json_encode(['response' => 'OK', 'data' => $CustomerAddress], JSON_FORCE_OBJECT));
                    } else {
                        $array = [
                            'AddressInfo' => $AddressInfo,
                            'RecepientName' => $RecepientName,
                            'RecepientPhone' => $RecepientPhone,
                            'Address' => $Address,
                            'PostalCode' => $PostalCode,
                            'ProvinceID' => $ProvinceID,
                            'CityID' => $CityID,
                            'DistrictID' => $DistrictID,
                            'IsActive' => 1,
                            'Status' => 0,
                            'CreatedDate' => new \DateTime("now"),
                        ];
                        die(json_encode(['response' => 'OK', 'data' => $array], JSON_FORCE_OBJECT));
                    }
                break;
                case 'SelectShippingAddress' :
                    $ID = $request['ID'];

                    $this->_loaddbclass([ 'CustomerAddress' ]);

                    $SelectCustomerAddress = $this->CustomerAddress->leftjoin([
                        ['province as p', 'p.ID', '=', 'customer_address.ProvinceID'],
                        ['city as c', 'c.ID', '=', 'customer_address.CityID'],
                        ['district as d', 'd.ID', '=', 'customer_address.DistrictID']
                    ])->select([
                        'customer_address.*',
                        'p.ID as ProvinceID',
                        'p.Name as ProvinceName',
                        'c.ID as CityID',
                        'c.Name as CityName',
                        'd.ID as DistrictID',
                        'd.Name as DistrictName',
                    ])->where([
                        ['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
                        ['customer_address.Status', '=', 0],
                        ['customer_address.ID', '=', $ID],
                    ])->first();

                    foreach($this->CustomerAddress->where([['IsActive','=',1],['CustomerID','=',\Session::get('customerdata')['ccustomerid']]])->get() as $obj) {
                        $obj->update([
                            'IsActive' => 0,
                            'UpdatedDate' => new \DateTime("now"),
                            'UpdatedBy' => \Session::get('customerdata')['ccustomerid']
                        ]);
                    }

                    $SelectCustomerAddress->update([
                        'IsActive' => 1,
                        'UpdatedDate' => new \DateTime("now"),
                        'UpdatedBy' => \Session::get('customerdata')['ccustomerid']
                    ]);

                    die(json_encode(['response' => 'OK', 'data' => $SelectCustomerAddress], JSON_FORCE_OBJECT));
                break;
                case 'GetShippingPrice' :
                    $ShippingID = $request['ShippingID'];
                    $PickupDistrictID = $request['PickupDistrictID'];
                    $IDDistrict = $request['IDDistrict'];
                    $Weight = $request['Weight'];

                    $data = '';
                    if(!$ShippingID) $data['error'][] = 'Please select Delivery';
                    if(!$IDDistrict) $data['error'][] = 'Please select Shipping Address';

                    if($ShippingID && $PickupDistrictID && $IDDistrict && $Weight) {
                        switch ($ShippingID) {
                            case 1: // JNE
                                $this->_loaddbclass([ 'District' ]);

                                $arrdistrict = $this->District->where([['Status','=',0],['IsActive','=',1]])
                                                ->whereIn('ID', [$PickupDistrictID,$IDDistrict])->get()->toArray();

                                if(count($arrdistrict) == 2) {
                                    $from = $arrdistrict[array_search($PickupDistrictID, array_column($arrdistrict, 'ID'))]['JNECode'];
                                    $thru = $arrdistrict[array_search($IDDistrict, array_column($arrdistrict, 'ID'))]['JNECode'];

                                    if($from && $thru) {
                                        $this->_loadfcclass([ 'JNE' ]);

                                        $from = substr($from, 0, 4).'0000';

                                        if(!$this->inv['config']['JNETest']) {
                                            $data = json_decode($this->JNE->_getprice($from, $thru, $Weight), True); 
                                        } else {
                                            $data = '';
                                            if(!$data) {
                                                $data = json_decode('{"price":[{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR","service_code":"JTR","price":"40000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR250","service_code":"JTR250","price":"1100000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR<150","service_code":"JTR<150","price":"500000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR>250","service_code":"JTR>250","price":"1500000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"OKE","service_code":"OKE15","price":"16000","etd_from":"2","etd_thru":"3","times":"D"},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"REG","service_code":"REG15","price":"18000","etd_from":"1","etd_thru":"2","times":"D"},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"SPS","service_code":"SPS15","price":"443000","etd_from":"0","etd_thru":"0","times":"D"},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"YES","service_code":"YES15","price":"28000","etd_from":"1","etd_thru":"1","times":"D"}]}', True);
                                            }
                                        }

                                        $data = $data['price'];

                                        $dispayname = [
                                            'OKE' => '(Ongkos Kirim Ekonomis)',
                                            'REG' => '(Reguler)',
                                            'YES' => '(Yakin Esok Sampai)'
                                        ];

                                        foreach ($data as $key => $value) {
                                            if(!in_array($value['service_display'], array_keys($dispayname))) {
                                                unset($data[$key]);
                                            }
                                        }

                                        $data = array_values($data);

                                        $return = 'OK';
                                    } else $data['error'][] = 'Please contact admin';
                                } else $data['error'][] = 'Please contact admin';
                            break;
                        }
                    } else {
                        if(!($ShippingID && $IDDistrict)) {
                            $data['error'][] = 'Please contact admin';
                        }
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'CheckLogin' :
                    $InitialCart = \Session::get('InitialCart');

                    if(isset(\Session::get('customerdata')['ccustomerid'])) {
                        $newInitialCart['CustomerID'] = \Session::get('customerdata')['ccustomerid'];
                        
                        \Session::put('InitialCart', $newInitialCart);
                        \Session::save();

                        $return = 'OK';
                    } else if(isset($InitialCart['AsGuest']) && $InitialCart['AsGuest']) {
                        $return = 'OK';
                    } else {
                        $return = 'Not OK';
                    }
                    
                    die(json_encode(['response' => $return], JSON_FORCE_OBJECT));
                break;
                case 'Login' :
                    $email = $request['email'];
                    if(empty($email)) $data['error'][] = $this->_trans('validation.mandatory', ['value' => 'Email']);

                    $password = $request['password'];
                    if(empty($password)) $data['error'][] = $this->_trans('validation.mandatory', ['value' => 'Password']);
                    
                    if(isset($request['remember'])) $remember = $request['remember'];

                    if(!isset($data['error'])) {
                        $this->_loaddbclass(['Customer']);

                        $Customer = $this->Customer->where([['UserName','=',$email],['Status','=',0]])->orwhere([['Email','=',$password],['Status','=',0]])->first();

                        if($Customer) {
                            if(\Hash::check($password, $Customer->Password)) {
                                if($Customer->IsActive == 1) {
                                    $customerdata = array(
                                        'ccustomerid' => $Customer->ID,
                                        'ccustomeruniqueid' => $Customer->CustomerUniqueID,
                                        'ccustomerusername' => $Customer->UserName,
                                        'ccustomeremail' => $Customer->Email,
                                        'ccustomername' => $Customer->FullName,
                                        'ccustomer' => $Customer->permalink,
                                    );

                                    $array['LastLogin'] = new \DateTime("now");
                                    $Customer->update($array);
                                    
                                    \Session::put('customerdata', $customerdata);
                                    \Session::save();

                                    $oneday = 60 * 24;
                                    $onemonth = $oneday * 30;
                                    $oneyear = $onemonth * 12;

                                    $minute = $oneyear * 5;
                                    
                                    if(isset($request['remember'])) return \Redirect::to('')->withCookie('customerdata', $customerdata, $minute);
                                    else return \Redirect::to('');
                                } else {
                                    $data['error'][] = $this->_trans('backend.login.errornotactive');
                                }
                            } else {
                                $data['error'][] = $this->_trans('backend.login.errorinvalid');
                            }
                        } else {
                            $data['error'][] = $this->_trans('backend.login.errorinvalid');
                        }
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'Register' :
                    $firstname = $request['firstname'];
                    if(empty($firstname)) $data['error'][] = 'rfirstname'; 
                    $lastname = $request['lastname'];
                    if(empty($lastname)) $data['error'][] = 'rlastname'; 
                    $gender = $request['gender'];
                    if(!is_numeric($gender)) $data['error'][] = 'rgender';
                    $phone = $request['phone'];
                    if(empty($phone)) $data['error'][] = 'rphone';
                    $email = $request['email'];
                    if(empty($email)) $data['error'][] = 'remail'; 
                    $password = $request['password'];
                    if(empty($password)) $data['error'][] = 'rpassword'; 
                    $repassword = $request['repassword'];
                    if(empty($repassword)) $data['error'][] = 'rrepassword'; 
                    if($this->_email($email)) $data['error'][] = '--Format email salah';

                    $this->_loaddbclass(['Customer']);

                    $Customer = $this->Customer->where([['permalink','=',$this->_permalink($firstname.' '.$lastname)]])->first();
                    if($Customer) $data['error'][] = '--Kombinasi nama depan dan nama belakang telah terdaftar';

                    $Customer = $this->Customer->where([['Email','=',$email]])->first();
                    if($Customer) $data['error'][] = '--Email telah terdaftar';

                    if($password && $repassword) {
                        if($password != $repassword) {
                            $data['error'][] = '--Password tidak sesuai';
                        }
                    }

                    if(isset($request['remember'])) $remember = $request['remember'];
                    if(isset($request['subscribe'])) $subscribe = $request['subscribe'];

                    if(!isset($data['error'])) {
                        $LastCustomer = $this->_dbgetlastrow('customer', 'CustomerUniqueID');

                        if($LastCustomer) {
                            $LastCustomer = substr($LastCustomer, -2);
                            $LastCustomer = sprintf('%02d', $LastCustomer + 1);
                        } else $LastCustomer = sprintf('%02d', 1);

                        $CustomerUniqueID = 'LG' . date('ymdhms') . sprintf('%02d', $LastCustomer);

                        $array = array(
                            'CustomerUniqueID' => $CustomerUniqueID,
                            'Password' => \Hash::make($password),
                            'FirstName' => $firstname,
                            'LastName' => $lastname,
                            'FullName' => $firstname.' '.$lastname,
                            'Username' => $email,
                            'Gender' => $gender,
                            'Email' => $email,
                            'Mobile' => $phone,
                            'permalink' => $this->_permalink($firstname.' '.$lastname),
                        );

                        if(isset($request['subscribe'])) {
                            if($gender == 0) {
                                $array['IsSubscribeWomen'] = 1;
                            } else {
                                $array['IsSubscribeMen'] = 1;
                            }
                        } else {
                            $array['IsSubscribeMen'] = 0;
                            $array['IsSubscribeWomen'] = 0;
                        }

                        $array['IsActive'] = 1;
                        $array['Status'] = 0;
                        $array['CreatedDate'] = new \DateTime("now");
                        
                        $Customer = $this->Customer->creates($array);

                        $this->_loaddbclass([ 'SendEmail' ]);

                        $this->SendEmail->creates([
                            'MailTo' => $email,
                            'MailToName' => $firstname.' '.$lastname,
                            'Subject' => 'Registration - Lacigue',
                            'Body' => '<html>
    <body>
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="font-family: \'Roboto\'; margin: 0 auto; border: 1px solid #ededed;
            padding: 10px;">
            <tr>
                <td style="height: 50px; background: url('.$this->inv['basesite'].'assets/frontend/images/material/top_bar.png) repeat-x; color: white; font-size: 18px;" align="center">
                    Lacigue Registration Account
                </td>
            </tr>
            <tr>
                <td align="center" style="font-size: 17px;"><br/>Hello <b>'.$firstname.' '.$lastname.'</b> !</td>
            </tr>
            <tr>
                <td align="center"><br/>
                    Welcome to Lacigue!<br/>
                    Thanks for registering.<br/><br/>

                    Sincerely Yours,<br/><br/>
                    <img src="'.$this->inv['basesite'].'assets/frontend/images/material/logo.png" width="200px"><br/>
                <br/></td>
            </tr>
            <tr>
                <td style="height: 40px; background: url('.$this->inv['basesite'].'assets/frontend/images/material/top_bar.png) repeat-x; color: white; font-size: 13px;" align="center">
                    <a href="'.$this->inv['basesite'].'" target="_blank" style="text-decoration: none; color: white;">LACIGUE.COM</a> &copy; '.date('Y').'
                </td>
            </tr>
        </table>
    </body>
</html>',
                            'Status' => 0,
                            'DateTimeEntry' => new \DateTime("now"),
                            'Type' => 'REGISTER',
                            'DescriptionType' => 'Register Customer',
                            'MailFrom' => $this->inv['config']['email']['smtp_user'],
                            'MailFromName' => 'no-reply@lacigue.com',
                            'FromSource' => 'Product Detail Page',
                        ]);

                        foreach ($request as $key => $value) {
                            $$key = '';
                        }

                        $customerdata = array(
                            'ccustomerid' => $Customer->ID,
                            'ccustomeruniqueid' => $Customer->CustomerUniqueID,
                            'ccustomerusername' => $Customer->UserName,
                            'ccustomeremail' => $Customer->Email,
                            'ccustomername' => $Customer->FullName,
                            'ccustomer' => $Customer->permalink,
                        );

                        $array['LastLogin'] = new \DateTime("now");
                        $Customer->update($array);
                        
                        \Session::put('customerdata', $customerdata);

                        $oneday = 60 * 24;
                        $onemonth = $oneday * 30;
                        $oneyear = $onemonth * 12;

                        $minute = $oneyear * 5;
                        
                        if(isset($request['remember'])) return \Redirect::to('')->withCookie('customerdata', $customerdata, $minute);
                        else return \Redirect::to('');
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'Guest' : 
                    $email = $request['email'];
                    if(empty($email)) $data['error'][] = 'Email harus di isi';
                    else if($this->_email($email)) $data['error'][] = 'Format email salah';

                    if(!isset($data['error'])) {
                        $this->_loaddbclass([ 'Customer' ]);

                        $Customer = $this->Customer->where([['Email','=',$email]])->first();

                        if(!$Customer) {
                            $LastCustomer = $this->_dbgetlastrow('customer', 'CustomerUniqueID');

                            if($LastCustomer) {
                                $LastCustomer = substr($LastCustomer, -2);
                                $LastCustomer = sprintf('%02d', $LastCustomer + 1);
                            } else $LastCustomer = sprintf('%02d', 1);

                            $CustomerUniqueID = 'LG' . date('ymdhis') . sprintf('%02d', $LastCustomer);
                            
                            $password = uniqid();
                            $array = array(
                                'CustomerUniqueID' => $CustomerUniqueID,
                                'Password' => \Hash::make($password),
                                'Username' => $email,
                                'Email' => $email,
                            );

                            $array['AsGuest'] = 1;
                            $array['IsActive'] = 0;
                            $array['Status'] = 0;
                            $array['CreatedDate'] = new \DateTime("now");
                            
                            $Customer = $this->Customer->creates($array);

                            $this->_loaddbclass([ 'SendEmail' ]);

                            $this->SendEmail->creates([
                                'MailTo' => $email,
                                'MailToName' => $email,
                                'Subject' => 'Activate Your Account - Lacigue',
                                'Body' => '<html>
    <body>
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="font-family: \'Roboto\'; margin: 0 auto; border: 1px solid #ededed;
            padding: 10px;">
            <tr>
                <td style="height: 50px; background: url('.$this->inv['basesite'].'assets/frontend/images/material/top_bar.png) repeat-x; color: white; font-size: 18px;" align="center">
                    Welcome GUEST !
                </td>
            </tr>
            <tr>
                <td align="center" style="font-size: 17px;"><br/>Hello <b>'.$email.'</b> !</td>
            </tr>
            <tr>
                <td align="center"><br/>
                    System is automatically create your account.<br/><br/>
                    
                    Please activate your account !<br/><br/>
<table>
    <tr>
        <td style="background-color: #848484;border-color: #6D6D6D;border: 1px solid #6D6D6D;padding: 7px;text-align: center;">
            <a style="display: block;color: #ffffff;font-size: 11px;text-decoration: none;text-transform: uppercase;" href="'.$this->inv['basesite'].'activate/code_'.encrypt($CustomerUniqueID).'">
                Click me
            </a>
        </td>
    </tr>
</table><br/>
                    Sincerely Yours,<br/><br/>
                    <img src="'.$this->inv['basesite'].'assets/frontend/images/material/logo.png" width="200px"><br/>
                <br/></td>
            </tr>
            <tr>
                <td style="height: 40px; background: url('.$this->inv['basesite'].'assets/frontend/images/material/top_bar.png) repeat-x; color: white; font-size: 13px;" align="center">
                    <a href="'.$this->inv['basesite'].'" target="_blank" style="text-decoration: none; color: white;">LACIGUE.COM</a> &copy; '.date('Y').'
                </td>
            </tr>
        </table>
    </body>
</html>',
                                'Status' => 0,
                                'DateTimeEntry' => new \DateTime("now"),
                                'Type' => 'REGISTER',
                                'DescriptionType' => 'Guest Customer',
                                'MailFrom' => $this->inv['config']['email']['smtp_user'],
                                'MailFromName' => 'no-reply@lacigue.com',
                                'FromSource' => 'Product Detail Page',
                            ]);
                        }
                        
                        $InitialCart = \Session::get('InitialCart');

                        $InitialCart['CustomerID'] = $Customer->ID;
                        $InitialCart['AsGuest'] = $Customer->Email;

                        \Session::put('InitialCart', $InitialCart);
                        \Session::save();

                        $return = 'OK';
                        $data = '';
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

		if(isset($this->inv['getid'])) {
			$this->_loaddbclass(['Product', 'ProductLink', 'ProductDetailSizeVariant', 'SellerShipping']);

			$ID = explode('-', $this->inv['getid']);

			$Product = $this->Product->leftjoin([
				['brand as b', 'b.ID', '=', 'product.BrandID'],
				['seller as s', 's.ID', '=', 'product.SellerID'],
				['category as c', 'c.ID', '=', 'product.CategoryID'],
                ['sub_category as sc', 'sc.ID', '=', 'product.SubCategoryID'],
				['colors as cs', 'cs.ID', '=', 'product.ColorID'],
			])->where([
				['product.ID','=',end($ID)],
				['product.IsActive', '=', 1],
				['product.Status', '=', 0]
			])->selectraw('
				product.*,
				s.ID as SellerID,
                s.FullName as SellerName,
				s.PickupDistrictID as PickupDistrictID,
				b.Name as BrandName,
				b.permalink as BrandPermalink,
				(CASE b.Mode
				    WHEN 0 THEN "feature"
				    WHEN 1 THEN "artist"
				    ELSE "indie"
				END) as BrandMode,
				c.ID as CategoryID,
				c.Name as CategoryName,
				sc.ID as SubCategoryID,
                sc.Name as SubCategoryName,
                cs.Name as ColorName,
                cs.Hexa as ColorHexa,
				cs.Hexa as ColorID,
				(select GROUP_CONCAT(sc.ID SEPARATOR ",") from sub_category as sc where IDCategory = c.ID) as SubCategoryIDAll,
				(select GROUP_CONCAT(CONCAT(sv.ID,"-",sv.Name) SEPARATOR ",") from product_detail_size_variant pdsv left join size_variant sv on pdsv.SizeVariantID = sv.ID where pdsv.ProductID = product.ID and pdsv.Status = 0) as SizeVariant
			');

			$Product = $Product->first();
            $this->inv['Product'] = $Product;

            $ArrProductLink = $this->ProductLink->leftjoin([
                ['product as p', 'p.ID', '=', 'product_link.ProductID'],
                ['brand as b', 'b.ID', '=', 'p.BrandID'],
                ['seller as sr', 'sr.ID', '=', 'b.SellerID'],
                ['product_detail_style as pds', 'pds.ProductID', '=', 'p.ID'],
                ['style as s', 's.ID', '=', 'pds.StyleID'],
                ['colors as c', 'c.ID', '=', 'p.ColorID'],
                ['product_detail_size_variant as pdzv', 'pdzv.ProductID', '=', 'p.ID'],
            ])->where([
                ['p.IsActive', '=', 1],
                ['p.Status', '=', 0],
                ['b.IsActive', '=', 1],
                ['b.Status', '=', 0],
                ['sr.IsActive', '=', 1],
                ['sr.Status', '=', 0],
                ['pdzv.ProductID', '!=', ''],
                ['pdzv.Status', '=', 0],
            ])->whereraw('ProductLinkGroup = (select ProductLinkGroup from product_link as pl where pl.ProductID = '.$Product->ID.')')
            ->selectraw('
                p.permalink,
                c.name,
                c.hexa
            ')->groupBy('product_link.ProductID')->get();
            $this->inv['ArrProductLink'] = $ArrProductLink;

            $ArrSize = $this->ProductDetailSizeVariant->leftjoin([
                ['size_variant as sv', 'sv.ID', '=', 'product_detail_size_variant.SizeVariantID']
            ])->where([
                ['ProductID', '=', $Product->ID],
                ['product_detail_size_variant.Status', '=', 0]
            ])->get()->toArray();
			$this->inv['ArrSize'] = $ArrSize;
            // $this->_debugvar($ArrSize);

            $ProductLink = $this->ProductLink->where([['ProductID', '=', $Product->ID]])->first();
            if($ProductLink) {
                $ProductLink = $this->ProductLink->where([['ProductLinkGroup', '=', $ProductLink->ProductLinkGroup]])->pluck('ProductID')->toArray();
            }

            $ArrayProduct = $this->Product->leftjoin([
                ['brand as b', 'b.ID', '=', 'product.BrandID'],
                ['seller as sr', 'sr.ID', '=', 'b.SellerID'],
                ['product_detail_style as pds', 'pds.ProductID', '=', 'product.ID'],
                ['style as s', 's.ID', '=', 'pds.StyleID'],
                ['colors as c', 'c.ID', '=', 'product.ColorID'],
                ['product_detail_size_variant as pdzv', 'pdzv.ProductID', '=', 'product.ID'],
                ['product_link as pl', 'pl.ProductID', '=', 'product.ID'],
            ])->where([
                ['product.IsActive', '=', 1],
                ['product.Status', '=', 0],
                ['b.IsActive', '=', 1],
                ['b.Status', '=', 0],
                ['sr.IsActive', '=', 1],
                ['sr.Status', '=', 0],
                ['pdzv.ProductID', '!=', ''],
                ['pdzv.Status', '=', 0],
                ['product.ModelType', '=', $Product->ModelType],
                ['product.CategoryID', '=', $Product->CategoryID],
                ['product.SubCategoryID', '=', $Product->SubCategoryID],
            ]);
            if($ProductLink) {
                $ArrayProduct = $ArrayProduct->whereNotIn('product.ID', $ProductLink);
            }
            $ArrayProduct = $ArrayProduct->selectraw('product.*')->groupBy('product.ID')->orderBy('product.ID', 'DESC')->take(12)->get();
            $this->inv['ArrayProduct'] = $ArrayProduct;

            $this->_loaddbclass([ 'Province' ]);
            $arrprovince = $this->Province->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
            $this->inv['arrprovince'] = $arrprovince;

            $SelectCustomerAddress = '';
            if(\Session::get('customerdata')) {
                $this->_loaddbclass(['CustomerAddress']);

                $ArrayCustomerAddress = $this->CustomerAddress->where([
                    ['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
                    ['Status', '=', 0],
                ])->get();
                
                $this->inv['ArrayCustomerAddress'] = $ArrayCustomerAddress;

                $SelectCustomerAddress = $this->CustomerAddress->leftjoin([
                    ['province as p', 'p.ID', '=', 'customer_address.ProvinceID'],
                    ['city as c', 'c.ID', '=', 'customer_address.CityID'],
                    ['district as d', 'd.ID', '=', 'customer_address.DistrictID']
                ])->select([
                    'customer_address.*',
                    'p.ID as ProvinceID',
                    'p.Name as ProvinceName',
                    'c.ID as CityID',
                    'c.Name as CityName',
                    'd.ID as DistrictID',
                    'd.Name as DistrictName',
                ])->where([
                    ['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
                    ['customer_address.Status', '=', 0],
                    ['customer_address.IsActive', '=', 1],
                ])->first();

                if(!$SelectCustomerAddress) $SelectCustomerAddress = '';
            }

            $this->inv['SelectCustomerAddress'] = $SelectCustomerAddress;

            $arrShipping = $this->SellerShipping->leftjoin([
                ['shipping as s', 's.ID', '=', 'seller_shipping.ShippingID']
            ])->where([['s.IsActive','=',1],['s.Status','=',0],['seller_shipping.SellerID','=',$Product->SellerID]])->orderBy('s.ID', 'ASC')->get();
            $this->inv['arrShipping'] = $arrShipping;
            
            $arrayreason = [
                1 => 'Photography Is Not Real',
                2 => 'Other'
            ];
            $this->inv['arrayreason'] = $arrayreason;
            
			return $this->_showviewfront(['productbeauty']);
		} else return $this->_redirect('404');
	}
}