<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class shoppingbagController extends Controller
{
	public function ajaxpost()
    {
        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'ChangeDetail' :
                    $ID = str_replace('table_edit', '', $request['ID']);
                    $Cart = \Session::get('Cart');

            		if(!$ID) {
            			$data['error'][] = 'Please contact admin';
                    } else if(!$Cart) {
            			$data['error'][] = 'Please contact admin';
                    } else {
                    	list($key1,$SellerID,$ShippingID,$ShippingPackageID,$IDDistrict,$ProductID,$GroupSizeID,$SizeVariantID) = explode('-', $ID);

						$checkkeys = '';
					    foreach ($Cart as $key => $value) {
					        if(key($value) == 'SellerID-'.$SellerID) {
					            $checkkeys = $key;
					            break;
					        }
					    }
					    
                    	if(isset($Cart[$checkkeys]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID])) {

                            $this->_loaddbclass(['Product', 'ProductDetailSizeVariant', 'SizeVariant']);

                            $Product = $this->Product->where([['ID', '=', $ProductID]])->first();

                            if(!$Product->TypeProduct) {
                                if($Product->GroupSizeID == $GroupSizeID) {
                                    $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->leftjoin([
                                        ['size_variant as sv', 'sv.ID', '=', 'product_detail_size_variant.SizeVariantID']
                                    ])->where([
                                        ['ProductID', '=', $ProductID],
                                        ['product_detail_size_variant.Status', '=', 0]
                                    ])->selectraw('
                                        sv.GroupSizeID as GroupSizeID,
                                        sv.ID as SizeVariantID,
                                        sv.Name as SizeName,
                                        product_detail_size_variant.Qty as SizeQty
                                    ')->get();
                                } else {
                                    $SizeVariant = $this->SizeVariant->where([['ID', '=', $SizeVariantID]])->first();
                                    $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->leftjoin([
                                        ['size_link as sl', 'sl.SizeVariantID', '=', 'product_detail_size_variant.SizeVariantID'],
                                        ['size_variant as sv', 'sv.ID', '=', 'sl.SizeVariantIDLink']
                                    ])->where([
                                        ['sv.GroupSizeID', '=', $GroupSizeID],
                                        ['sv.ModelType', '=', $SizeVariant->ModelType],
                                        ['sv.CategoryID', '=', $SizeVariant->CategoryID],
                                        ['sv.SubCategoryID', '=', $SizeVariant->SubCategoryID],
                                        ['product_detail_size_variant.ProductID', '=', $ProductID],
                                        ['product_detail_size_variant.Status', '=', 0]
                                    ])->selectraw('
                                        sv.GroupSizeID as GroupSizeID,
                                        sv.ID as SizeVariantID,
                                        sv.Name as SizeName,
                                        product_detail_size_variant.Qty as SizeQty
                                    ')->get();
                                }
                            } else {
                                $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->leftjoin([
                                    ['size_variant as sv', 'sv.ID', '=', 'product_detail_size_variant.SizeVariantID']
                                ])->where([
                                    ['ProductID', '=', $ProductID],
                                    ['product_detail_size_variant.Status', '=', 0]
                                ])->selectraw('
                                    sv.GroupSizeID as GroupSizeID,
                                    sv.ID as SizeVariantID,
                                    sv.Name as SizeName,
                                    product_detail_size_variant.Qty as SizeQty
                                ')->get();
                            }

                            $data['ArrSize'] = $ProductDetailSizeVariant;
                            $data['selectsize'] = $SizeVariantID;
                            $data['selectqty'] = $Cart[$checkkeys]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID][0];
                            
                            $data['ProductLink'] = $ID;

                            $return = 'OK';
                        } else {
                        	$data['error'][] = 'Please contact admin';
                        }
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'GetQty' :
                    $ID = $request['ID'];

            		if(!$ID) {
            			$data['error'][] = 'Please contact admin';
                    } else {
                    	list($NewSizeID,$key1,$SellerID,$ShippingID,$ShippingPackageID,$IDDistrict,$ProductID,$GroupSizeID,$SizeVariantID) = explode('-', $ID);

                        $this->_loaddbclass(['Product', 'ProductDetailSizeVariant', 'SizeVariant']);

                        $Product = $this->Product->where([['ID', '=', $ProductID]])->first();

                        if(!$Product->TypeProduct) {
                            if($Product->GroupSizeID == $GroupSizeID) {
                                $SizeQty = $this->ProductDetailSizeVariant->leftjoin([
                                    ['size_variant as sv', 'sv.ID', '=', 'product_detail_size_variant.SizeVariantID']
                                ])->where([
                                    ['ProductID', '=', $ProductID],
                                    ['product_detail_size_variant.GroupSizeID', '=', $GroupSizeID],
                                    ['product_detail_size_variant.Status', '=', 0],
                                    ['sv.ID', '=', $NewSizeID]
                                ])->selectraw('product_detail_size_variant.Qty as SizeQty')->first();
                            } else {
                                $SizeVariant = $this->SizeVariant->where([['ID', '=', $NewSizeID]])->first();
                                $SizeQty = $this->ProductDetailSizeVariant->leftjoin([
                                    ['size_link as sl', 'sl.SizeVariantID', '=', 'product_detail_size_variant.SizeVariantID'],
                                    ['size_variant as sv', 'sv.ID', '=', 'sl.SizeVariantIDLink']
                                ])->where([
                                    ['sv.GroupSizeID', '=', $GroupSizeID],
                                    ['sv.ModelType', '=', $SizeVariant->ModelType],
                                    ['sv.CategoryID', '=', $SizeVariant->CategoryID],
                                    ['sv.SubCategoryID', '=', $SizeVariant->SubCategoryID],
                                    ['product_detail_size_variant.ProductID', '=', $ProductID],
                                    ['product_detail_size_variant.Status', '=', 0],
                                    ['sv.ID', '=', $NewSizeID]
                                ])->selectraw('product_detail_size_variant.Qty as SizeQty')->first();
                            }
                        } else {
                            $SizeQty = $this->ProductDetailSizeVariant->leftjoin([
                                ['size_variant as sv', 'sv.ID', '=', 'product_detail_size_variant.SizeVariantID']
                            ])->where([
                                ['ProductID', '=', $ProductID],
                                ['product_detail_size_variant.Status', '=', 0],
                                ['sv.ID', '=', $NewSizeID]
                            ])->selectraw('product_detail_size_variant.Qty as SizeQty')->first();
                        }
                        
                    	if($SizeQty) {
                        	$data['SizeQty'] = $SizeQty->SizeQty;
                        	$data['ProductLink'] = ltrim($ID, $NewSizeID.'-');

                            $return = 'OK';
                        } else {
                        	$data['error'][] = 'Please contact admin';
                        }
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'Remove' :
                    $ID = $request['ID'];

            		if(!$ID) {
            			$data['error'][] = 'Please contact admin';
                    } else {
                    	list($key1,$SellerID,$ShippingID,$ShippingPackageID,$IDDistrict,$ProductID,$GroupSizeID,$SizeVariantID) = explode('-', $ID);

                    	$Cart = \Session::get('Cart');

                        if(isset($Cart) && isset($Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID])) {

                        	unset($Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID]);

                        	if(count($Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]) == 0) {
                        		unset($Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]);
                        	}
                        	
                        	if(count($Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]) == 0) {
                        		unset($Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]);
                        	}

                        	if(count($Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]) == 0) {
                        		unset($Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]);
                        	}

                        	if(count($Cart[$key1]['SellerID-'.$SellerID]) == 0) {
                        		unset($Cart[$key1]['SellerID-'.$SellerID]);
                        	}

                        	if(count($Cart[$key1]) == 0) {
                        		unset($Cart[$key1]);
                        	}

                        	$Cart = array_values($Cart);
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
                case 'Update' :
                    $ID = $request['ID'];
                    $NewSizeID = $request['SizeVariantID'];
                    $Qty = $request['Qty'];
                    $Notes = $request['Notes'];

                    if(!$ID) {
                        $data['error'][] = 'Please contact admin';
                    } else {
                        list($key1,$SellerID,$ShippingID,$ShippingPackageID,$IDDistrict,$ProductID,$GroupSizeID,$SizeVariantID) = explode('-', $ID);

                        $Cart = \Session::get('Cart');

                        if(isset($Cart) && isset($Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID])) {

                            $Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID][0] = $Qty;
                            $Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID][2] = $NewSizeID;
                            $Cart[$key1]['SellerID-'.$SellerID]['ShippingID-'.$ShippingID]['ShippingPackageID-'.$ShippingPackageID]['IDDistrict-'.$IDDistrict]['ProductID-'.$ProductID][3] = $Notes;

                            $Cart = array_values($Cart);
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
            }
        }
    }

	public function index()
	{
		$Cart = \Session::get('Cart');
        if(!$Cart) $Cart = '';
        $Cart = $this->_constructCart($Cart);
        if($Cart) $this->inv['Cart'] = $Cart;

        // $this->_debugvar($Cart);
        // \Session::put('Cart', '');
		return $this->_showviewfront(['shoppingbag']);
	}
}