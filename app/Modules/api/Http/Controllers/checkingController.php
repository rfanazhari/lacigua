<?php

namespace App\Modules\api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class checkingController extends Controller
{
    // $this->_debugvar();
    public function index()
    {
        $request = \Request::instance()->request->all();

        $response = ['response' => 'error'];

        if (isset($request['ajaxpost'])) {
            switch ($request['ajaxpost']) {
                case 'FaqSearch':
                    if(isset($request['search'])) {
                        $search = trim($request['search']);

                        if($search) {
                            $this->_loaddbclass(['Faq']);

                            $response['response'] = $this->Faq->leftjoin([
                                ['faq_sub as fs', 'fs.FaqID', '=', 'faq.ID'],
                                ['faq_sub_detail as fsd', 'fsd.FaqSubID', '=', 'fs.ID'],
                            ])->select([
                                'faq.Name as FaqName',
                                'faq.permalink as FaqPermalink',
                                'fs.Name as FaqSubName',
                                'fs.permalink as FaqSubPermalink',
                                'fsd.Title as FaqSubDetailTitle',
                            ])->where([
                                ['faq.IsActive','=',1],
                                ['faq.Status','=',0],
                                ['fs.IsActive','=',1],
                                ['fs.Status','=',0],
                                ['fsd.IsActive','=',1],
                                ['fsd.Status','=',0],
                            ]);

                            $response['response'] = $response['response']->where(function($query) use($search) {
                                $query->where('faq.Name', 'like', '%'.$search.'%')
                                ->orwhere('fs.Name', 'like', '%'.$search.'%')
                                ->orwhere('fsd.Title', 'like', '%'.$search.'%');
                            });
                            
                            $response['response'] = $response['response']->take(10)->get();

                            if(count($response['response'])) {
                                $response['response'] = $response['response']->toArray();

                                foreach ($response['response'] as $key => $value) {
                                    $response['response'][$key]['FaqName'] = strtoupper($value['FaqName']);
                                    $response['response'][$key]['FaqSubName'] = $value['FaqSubName'];
                                    $response['response'][$key]['FaqSubDetailTitle'] = $value['FaqSubDetailTitle'];

                                    $AppendLink = '';
                                    if($value['FaqPermalink']) $AppendLink .= '/faq_'.$value['FaqPermalink'];
                                    if($value['FaqSubPermalink']) $AppendLink .= '/faqsub_'.$value['FaqSubPermalink'];

                                    $response['response'][$key]['FaqLink'] = $this->inv['basesite'].'faq-detail'.$AppendLink;
                                }
                            } else $response['response'] = 'error';
                        } else $response['response'] = 'error';
                    }
                break;
                case 'SearchLacigue':
                    if(isset($request['search'])) {
                        $search = trim($request['search']);

                        if($search) {
                            $response['response'] = [];

                            $this->_loaddbclass(['Category','SubCategory','Product']);

                            $Category = $this->Category->where([
                                ['IsActive','=',1],
                                ['Status','=',0],
                            ]);

                            $Category = $Category->where(function($query) use($search) {
                                $query->where('Name', 'like', '%'.$search.'%')
                                ->orwhere('ModelType', 'like', '%'.$search.'%');
                            });
                            
                            $Category = $Category->take(5)->get();

                            if(count($Category)) {
                                $Category = $Category->toArray();
                                foreach ($Category as $key => $value) {
                                    $SubCategoryID = $this->SubCategory->where([['IDCategory', '=', $value['ID']]])->pluck('ID')->toArray();
                                    
                                    if(count($SubCategoryID)) $SubCategoryID = "[".implode(',', $SubCategoryID)."]";
                                    else $SubCategoryID = "";

                                    $Category[$key]['LabelName'] = $value['ModelType']." - ".$value['Name'];
                                    $Category[$key]['LabelLink'] = $this->inv['basesite'].strtolower($value['ModelType'])."/detail/category_[".$value['ID'].$SubCategoryID."]";
                                    $Category[$key]['CategoryList'] = 'CATEGORY';
                                }

                                $response['response'] = array_merge($response['response'], $Category);
                            }

                            $SubCategory = $this->SubCategory->leftjoin([
                                ['category', 'category.ID', '=', 'sub_category.IDCategory']
                            ])->where([
                                ['category.IsActive','=',1],
                                ['category.Status','=',0],
                                ['sub_category.IsActive','=',1],
                                ['sub_category.Status','=',0],
                            ])->selectraw('category.ModelType, sub_category.*');

                            $SubCategory = $SubCategory->where(function($query) use($search) {
                                $query->where('sub_category.Name', 'like', '%'.$search.'%');
                            });
                            
                            $SubCategory = $SubCategory->take(5)->get();

                            if(count($SubCategory)) {
                                $SubCategory = $SubCategory->toArray();
                                foreach ($SubCategory as $key => $value) {
                                    $Category = $this->Category->where([['ID', '=', $value['IDCategory']]])->first();
                                    
                                    $SubCategory[$key]['LabelName'] = $value['Name'];
                                    $SubCategory[$key]['LabelLink'] = $this->inv['basesite'].strtolower($value['ModelType'])."/detail/category_[".$Category->ID."[".$value['ID']."]]";
                                    $SubCategory[$key]['CategoryList'] = 'SUB CATEGORY';
                                }

                                $response['response'] = array_merge($response['response'], $SubCategory);
                            }

                            $Product = $this->Product->where([
                                ['IsActive','=',1],
                                ['Status','=',0],
                            ]);

                            $Product = $Product->where(function($query) use($search) {
                                $query->where('NameShow', 'like', '%'.$search.'%');
                            });
                            
                            $Product = $Product->take(5)->get();

                            if(count($Product)) {
                                $Product = $Product->toArray();
                                foreach ($Product as $key => $value) {
                                    if($value['StatusSale'] == 1) {
                                        $OldPrice = $value['SellingPrice'];
                                        $Price = $value['SalePrice'];
                                    } else {
                                        $OldPrice = 0;
                                        $Price = $value['SellingPrice'];
                                    }

                                    $Product[$key]['LabelName'] = strtoupper($value['NameShow']);
                                    $Product[$key]['LabelPrice'] = $Price;
                                    $Product[$key]['LabelOldPrice'] = $OldPrice;
                                    $Product[$key]['ImageSrc'] = $this->inv['basesite']."assets/frontend/images/content/product/medium_".$value['Image1']."?".uniqid();
                                    $Product[$key]['LabelLink'] = $this->inv['basesite']."product-detail/id_".$value['permalink'];
                                    $Product[$key]['CategoryList'] = 'PRODUCT';
                                }

                                $response['response'] = array_merge($response['response'], $Product);
                            }
                        } else $response['response'] = 'error';
                    }
                break;
                case 'SearchLocationFrom':
                    if(isset($request['search'])) {
                        $search = trim($request['search']);

                        if($search) {
                            $this->_loaddbclass(['Village']);

                            $response['response'] = $this->Village->leftjoin([
                                ['province','province.ID','=','village.ProvinceID'],
                                ['city','city.ID','=','village.CityID'],
                                ['district','district.ID','=','village.DistrictID'],
                            ])->select([
                                'province.Name as ProvinceName',
                                'city.Name as CityName',
                                'district.Name as DistrictName',
                                'village.Name as VillageName',
                                'village.ID as ID'
                            ])->where([
                                ['village.IsActive','=',1],
                                ['village.Status','=',0],
                                ['district.IsActive','=',1],
                                ['district.Status','=',0],
                                ['city.IsActive','=',1],
                                ['city.Status','=',0],
                                ['province.IsActive','=',1],
                                ['province.Status','=',0]
                            ]);

                            $response['response'] = $response['response']->where(function($query) use($search) {
                                $query->where('province.Name', 'like', '%'.$search.'%')
                                ->orwhere('city.Name', 'like', '%'.$search.'%')
                                ->orwhere('district.Name', 'like', '%'.$search.'%')
                                ->orwhere('village.Name', 'like', '%'.$search.'%');
                            });
                            
                            $response['response'] = $response['response']->take(25)->get();

                            if(count($response['response'])) {
                                $response['response'] = $response['response']->toArray();
                                foreach ($response['response'] as $key => $value) {
                                    $response['response'][$key]['LabelName'] = strtoupper($value['ProvinceName']) . " - " . $value['CityName'] . "<br/>" . $value['DistrictName'] . ", " . $value['VillageName'];
                                }
                            } else $response['response'] = 'error';
                        } else $response['response'] = 'error';
                    }
                break;
                case 'SearchLocationTo':
                    if(isset($request['notsearch']) && isset($request['search'])) {
                        $search = trim($request['search']);
                        $notsearch = trim($request['notsearch']);

                        if($search) {
                            if($notsearch) {
                                $this->_loaddbclass(['Village']);

                                $response['response'] = $this->Village->leftjoin([
                                    ['province','province.ID','=','village.ProvinceID'],
                                    ['city','city.ID','=','village.CityID'],
                                    ['district','district.ID','=','village.DistrictID'],
                                ])->select([
                                    'province.Name as ProvinceName',
                                    'city.Name as CityName',
                                    'district.Name as DistrictName',
                                    'village.Name as VillageName',
                                    'village.ID as ID'
                                ])->where([
                                    ['village.IsActive','=',1],
                                    ['village.Status','=',0],
                                    ['district.IsActive','=',1],
                                    ['district.Status','=',0],
                                    ['city.IsActive','=',1],
                                    ['city.Status','=',0],
                                    ['province.IsActive','=',1],
                                    ['province.Status','=',0]
                                ]);

                                $TmpVillage = $this->Village->where([
                                    ['ID','=',$notsearch]
                                ])->first();

                                if($TmpVillage) {
                                    $response['response'] = $response['response']->where([['village.CityID','!=',$TmpVillage->CityID]]);

                                    $response['response'] = $response['response']->where(function($query) use($search) {
                                        $query->where('province.Name', 'like', '%'.$search.'%')
                                        ->orwhere('city.Name', 'like', '%'.$search.'%')
                                        ->orwhere('district.Name', 'like', '%'.$search.'%')
                                        ->orwhere('village.Name', 'like', '%'.$search.'%');
                                    });
                                    
                                    $response['response'] = $response['response']->take(25)->get();

                                    if(count($response['response'])) {
                                        $response['response'] = $response['response']->toArray();
                                        foreach ($response['response'] as $key => $value) {
                                            $response['response'][$key]['LabelName'] = strtoupper($value['ProvinceName']) . " - " . $value['CityName'] . "<br/>" . $value['DistrictName'] . ", " . $value['VillageName'];
                                        }
                                    } else $response['response'] = 'error';
                                } else $response['response'] = 'errornot';
                            } else $response['response'] = 'error';
                        } else $response['response'] = 'errornot';
                    } else {
                        if(isset($request['notsearch']) && !isset($request['search'])) $response['response'] = 'error';
                        elseif(!isset($request['notsearch']) && isset($request['search'])) $response['response'] = 'errornot';
                    }
                break;
                case 'CheckLogin':
                    if(!\Session::get('customerdata'))
                        $response['response'] = 'Silahkan Daftar atau Login terlebih dahulu !';
                    else
                        $response['response'] = 'OK';
                break;
                case 'TrackMyOrder':
                    if(isset($request['OrderID'])) {
                        $OrderID = $request['OrderID'];

                        $this->_loaddbclass(['OrderTransaction']);

                        $OrderTransaction = $this->OrderTransaction->leftjoin([
                            ['customer as c', 'c.ID', '=', 'order_transaction.CustomerID'],
                        ])->selectraw('
                            c.FullName as CustomerName,
                            order_transaction.*
                        ')->where([
                            ['order_transaction.TransactionCode', '=', $OrderID],
                            ['StatusPaid', '=', 1]
                        ])->get();

                        if($OrderTransaction) {
                            $this->_loaddbclass(['OrderTransactionSeller','OrderTransactionDetail']);

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
                                            ['size as s', 's.ID', '=', 'order_transaction_detail.SizeID'],
                                            ['district as d', 'd.ID', '=', 'order_transaction_detail.DistrictID'],
                                            ['city as c', 'c.ID', '=', 'order_transaction_detail.CityID'],
                                            ['shipping as sg', 'sg.ID', '=', 'order_transaction_detail.ShippingID'],
                                        ])->selectraw('
                                            cs.Name as ColorName,
                                            b.Name as BrandName,
                                            s.Name as SizeName,
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

                                            $response['response'] = 'OK';
                                            $response['OrderTransaction'] = $OrderTransaction;
                                            $response['ArrShippingStatus'] = [
                                                0 => 'New Order',
                                                1 => 'Ready to Pickup',
                                                2 => 'Has Shipped',
                                                3 => 'Delivered'
                                            ];
                                        } else $response['error'][] = 'Please contact admin';
                                    }
                                } else $response['error'][] = 'Please contact admin';
                            }
                        } $response['error'][] = 'No. Order tidak terdaftar !';
                    } else $response['error'][] = 'Silahkan isi No. Order terlebih dahulu !';
                break;
            }
        }

        die(json_encode($response, JSON_FORCE_OBJECT));
    }
}
