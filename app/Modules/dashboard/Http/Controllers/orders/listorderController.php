<?php
namespace App\Modules\dashboard\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class listorderController extends Controller
{
    // Set header active
    public $header = [
        'menus'   => true, // True is show menu and false is not show.
        'check'   => true, // Active all header function. If all true and this check false then header not show.
        'search'  => true,
        'addnew'  => false,
        'refresh' => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'OrderTransactionSellerID',
        'TransactionCode' => 'TransactionCode',
        'TransactionSellerCode' => 'TransactionSellerCode',
        'SellerID' => 'SellerID',
        'ShippingID' => 'ShippingID',
        'ShippingName' => 'ShippingName',
        'ShippingPackageID' => 'ShippingPackageID',
        'IDDistrict' => 'IDDistrict',
        'DistrictName' => 'DistrictName',
        'QtyProductShip' => 'QtyProductShip',
        'WeightProductShip' => 'WeightProductShip',
        'PriceProductShip' => 'PriceProductShip',
        'DescProductShip' => 'DescProductShip',
        'ShippingPrice' => 'ShippingPrice',
        'AWBNumber' => 'AWBNumber',
        'PackageData' => 'PackageData',
        'StatusShipment' => 'StatusShipment',
        'CreatedDate' => 'CreatedDate',
        'CreatedBy' => 'CreatedBy',
        'UpdatedDate' => 'UpdatedDate',
        'UpdatedBy' => 'UpdatedBy',
        'idfunction' => 'ID',
    ];

    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'OrderTransactionSellerID' => ['Order Transaction Seller ID'],
        'TransactionCode' => ['Transaction Code'],
        'TransactionSellerCode' => ['Transaction Seller Code', true],
        'SellerID' => ['Seller ID'],
        'ShippingID' => ['Shipping ID'],
        'ShippingName' => ['Shipping', true],
        'ShippingPackageID' => ['Shipping Package', true],
        'IDDistrict' => ['ID District'],
        'DistrictName' => ['Shipping Location', true],
        'QtyProductShip' => ['Qty'],
        'WeightProductShip' => ['Weight'],
        'PriceProductShip' => ['Price'],
        'DescProductShip' => ['Desc'],
        'ShippingPrice' => ['Shipping Price'],
        'AWBNumber' => ['AWB Number', true],
        'PackageData' => ['Package Data'],
        'StatusShipment' => ['Status Shipment', true],
        'CreatedDate' => ['Created Date', true],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    public $objectkey = '', $OrderTransactionSellerID = '', $errorOrderTransactionSellerID = '', $TransactionCode = '', $errorTransactionCode = '', $TransactionSellerCode = '', $errorTransactionSellerCode = '', $SellerID = '', $errorSellerID = '', $ShippingID = '', $errorShippingID = '', $ShippingPackageID = '', $errorShippingPackageID = '', $IDDistrict = '', $errorIDDistrict = '', $QtyProductShip = '', $errorQtyProductShip = '', $WeightProductShip = '', $errorWeightProductShip = '', $PriceProductShip = '', $errorPriceProductShip = '', $DescProductShip = '', $errorDescProductShip = '', $ShippingPrice = '', $errorShippingPrice = '', $AWBNumber = '', $errorAWBNumber = '', $PackageData = '', $errorPackageData = '', $StatusShipment = '', $errorStatusShipment = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'ChangeStatusShipment' :
                    $this->_loaddbclass([ 'OrderTransactionSeller','OrderTransaction' ]);

                    $ID = $request['ID'];
                    $StatusShipment = $request['StatusShipment'];

                    $OrderTransactionSeller = $this->OrderTransactionSeller->where([['ID','=',$ID]]);

                    $OrderTransactionSeller = $OrderTransactionSeller->first();

                    if($OrderTransactionSeller) {
                        if($StatusShipment >= $OrderTransactionSeller->StatusShipment) {
                            $arraystatusshipment = [
                                0 => 'New Order',
                                1 => 'Ready to Pickup',
                                2 => 'Has Shipped',
                                3 => 'Delivered'
                            ];

                            $TransactionSellerCode = $OrderTransactionSeller->TransactionSellerCode;

                            $userdata =  \Session::get('userdata');
                            $userid =  $userdata['uuserid'];

                            $AWBNumber = '';
                            if($StatusShipment == 2 && !$this->inv['config']['JNETest']) {
                                $this->_loadfcclass([ 'JNE' ]);
                                $PackageData = json_decode($OrderTransactionSeller->PackageData, True);
                                $AWBNumber = json_decode($this->JNE->_createAirwaybill($PackageData), True);
                                if(isset($AWBNumber['detail'][0]['cnote_no'])) {
                                    $AWBNumber = $AWBNumber['detail'][0]['cnote_no'];
                                } else $AWBNumber = '';
                            }

                            $array[$this->inv['flip']['AWBNumber']] = $AWBNumber;
                            $array[$this->inv['flip']['StatusShipment']] = $StatusShipment;
                            $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                            $array[$this->inv['flip']['UpdatedBy']] = $userid;

                            $OrderTransactionSeller->update($array);
                            $this->_dblog('edit', $this, 'Set '.$arraystatusshipment[$StatusShipment].' '.$TransactionSellerCode);

                            if($StatusShipment >= 1) {
                                $OrderTransaction = $this->OrderTransaction->where([['TransactionCode', '=', $OrderTransactionSeller->TransactionCode],['StatusOrder', '=', 0]])->first();
                                if($OrderTransaction) {
                                    $array = [];
                                    $array['StatusOrder'] = 1;
                                    $array['UpdatedDate'] = new \DateTime('now');
                                    $array['UpdatedBy'] = $userid;

                                    $OrderTransaction->update($array);
                                }
                            }
                            die(json_encode(['response' => 'OK', 'data' => ['StatusShipment' => $arraystatusshipment[$StatusShipment], 'AWBNumber' => $AWBNumber]], JSON_FORCE_OBJECT));
                        } else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                    } else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                break;
            }
        }
    }

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) return $this->_redirect($url);

        return $this->views();
    }

    public function detail()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) return $this->_redirect($url);

        return $this->getdata();
    }

    private function getdata()
    {
        $arraystatusshipment = [
            0 => 'New Order',
            1 => 'Ready to Pickup',
            2 => 'Has Shipped',
            3 => 'Delivered'
        ];
        if (isset($this->inv['getid'])) {
            if (!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass(['OrderTransactionSeller','OrderTransactionDetail']);
                $OrderTransactionSeller = $this->OrderTransactionSeller->leftjoin([
                        ['seller as s', 's.ID', '=', 'order_transaction_seller.SellerID'],
                        ['shipping as sg', 'sg.ID', '=', 'order_transaction_seller.ShippingID'],
                        ['district as d', 'd.ID', '=', 'order_transaction_seller.IDDistrict'],
                        ['city as c', 'c.ID', '=', 'd.CityID'],
                        ['province as p', 'p.ID', '=', 'd.ProvinceID'],
                        ['order_transaction as ot', 'ot.TransactionCode', '=', 'order_transaction_seller.TransactionCode'],
                    ])->selectraw('
                        s.FullName as SellerName,
                        sg.Name as ShippingName,
                        CONCAT(p.Name,"<br/>",c.Name," - ",d.Name) as DistrictName,
                        ot.CurrencyCode,
                        order_transaction_seller.*
                    ')->where([['order_transaction_seller.ID', '=', $this->inv['getid']]])->first()->toArray();
                if ($OrderTransactionSeller) {
                    $OrderTransactionSeller['ListProduct'] = $this->OrderTransactionDetail->leftjoin([
                        ['product as p', 'p.ID', '=', 'order_transaction_detail.ProductID'],
                        ['colors as c', 'c.ID', '=', 'order_transaction_detail.ColorID'],
                    ])->selectraw('
                        c.Name as ColorName,
                        p.*,
                        order_transaction_detail.*
                    ')->where([
                        ['order_transaction_detail.TransactionCode', '=', $OrderTransactionSeller['TransactionCode']],
                        ['order_transaction_detail.SellerID', '=', $OrderTransactionSeller['SellerID']],
                        ['order_transaction_detail.ShippingID', '=', $OrderTransactionSeller['ShippingID']],
                        ['order_transaction_detail.ShippingPackageID', '=', $OrderTransactionSeller['ShippingPackageID']],
                        ['order_transaction_detail.IDDistrict', '=', $OrderTransactionSeller['IDDistrict']],
                    ])->get()->toArray();
                }
            } else {
                $this->inv['messageerror'] = $this->_trans('validation.norecord');
            }
        }

        $this->inv['OrderTransactionSeller'] = $OrderTransactionSeller;
        $this->inv['arraystatusshipment'] = $arraystatusshipment;

        return $this->_showview(["new"]);
    }

    private function views($views = ["defaultview"])
    {
        $this->_loaddbclass(['Seller','OrderTransactionSeller']);

        $result = $this->OrderTransactionSeller->leftjoin([
            ['order_transaction as ot', 'ot.TransactionCode', '=', 'order_transaction_seller.TransactionCode'],
            ['shipping as s', 's.ID', '=', 'order_transaction_seller.ShippingID'],
            ['district as d', 'd.ID', '=', 'order_transaction_seller.IDDistrict'],
            ['city as c', 'c.ID', '=', 'd.CityID'],
            ['province as p', 'p.ID', '=', 'd.ProvinceID'],
        ])->selectraw('
            ot.StatusPaid as StatusPaid,
            s.Name as ShippingName,
            CONCAT(p.Name,"<br/>",c.Name," - ",d.Name) as DistrictName,
            order_transaction_seller.*
        ');

        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        if($Seller) {
            $result = $result->where([['order_transaction_seller.SellerID', '=', $Seller->ID]]);
        }

        $result = $result->where([['ot.StatusPaid', '=', 1]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        $this->inv['flip']['ShippingName'] = 's.Name';
        $this->inv['flip']['DistrictName'] = \DB::raw('CONCAT(p.Name,"<br/>",c.Name," - ",d.Name)');
        $this->inv['flip']['CreatedDate'] = 'order_transaction_seller.CreatedDate';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['ShippingName'] = 'ShippingName';
        $this->inv['flip']['DistrictName'] = 'DistrictName';
        $this->inv['flip']['CreatedDate'] = 'CreatedDate';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        } else {
            $arraystatusshipment = [
                0 => 'New Order',
                1 => 'Ready to Pickup',
                2 => 'Has Shipped',
                3 => 'Delivered',
                4 => 'Auto Cancel',
                5 => 'Manual Cancel'
            ];

            for ($i = 0; $i < count($result['data']); $i++) {
                
                $result['data'][$i]['CreatedDate'] = $this->_datetimeforhtml($result['data'][$i]['CreatedDate'], 'red');

                if(in_array($result['data'][$i]['StatusShipment'], [0,1])) {
                    $StatusShipment = '<select id="'.$result['data'][$i][$this->inv['flip']['OrderTransactionSellerID']].'" class="form-control input-sm ChangeStatusShipment '.$result['data'][$i][$this->inv['flip']['OrderTransactionSellerID']].'" rel="'.$this->_trans('backend.defaultview.changestatus', ['value' => $this->_trans('dashboard.orders.listorder.StatusShipment')]).'">';
                    foreach ($arraystatusshipment as $key => $value) {
                        if(in_array($key, [0,1,2]))
                            $StatusShipment .= '<option value="'.$key.'" '.($key==$result['data'][$i][$this->inv['flip']['StatusShipment']]?'selected':'').' >'.$value.'</option>';
                    }
                    $StatusShipment .= '</select>';

                    $result['data'][$i][$this->inv['flip']['StatusShipment']] = $StatusShipment;
                } else {
                    $result['data'][$i]['StatusShipment'] = $arraystatusshipment[$result['data'][$i]['StatusShipment']];
                }
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}