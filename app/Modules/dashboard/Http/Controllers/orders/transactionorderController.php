<?php
namespace App\Modules\dashboard\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class transactionorderController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => false,
        'refresh'   => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'OrderTransactionID',
        'TransactionCode' => 'TransactionCode',
        'CustomerID' => 'CustomerID',
        'CustomerName' => 'CustomerName',
        'AsGuest' => 'AsGuest',
        'StoreCreditAmount' => 'StoreCreditAmount',
        'VoucherCode' => 'VoucherCode',
        'VoucherAmount' => 'VoucherAmount',
        'DiscountID' => 'DiscountID',
        'CurrencyCode' => 'CurrencyCode',
        'GrandTotal' => 'GrandTotal',
        'Type' => 'Type',
        'PaymentTypeID' => 'PaymentTypeID',
        'PaymentTypeName' => 'PaymentTypeName',
        'PaymentTypeImage' => 'PaymentTypeImage',
        'AccountNumber' => 'AccountNumber',
        'BeneficiaryName' => 'BeneficiaryName',
        'UniqueOrder' => 'UniqueOrder',
        'GrandTotalUnique' => 'GrandTotalUnique',
        'VANumber' => 'VANumber',
        'Notes' => 'Notes',
        'StatusOrder' => 'StatusOrder',
        'StatusPaid' => 'StatusPaid',
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
        'OrderTransactionID' => ['Order Transaction ID'],
        'TransactionCode' => ['Transaction Code', true],
        'CustomerID' => ['Customer ID'],
        'CustomerName' => ['Customer Name', true],
        'AsGuest' => ['As Guest'],
        'StoreCreditAmount' => ['Store Credit Amount'],
        'VoucherCode' => ['Voucher Code'],
        'VoucherAmount' => ['Voucher Amount'],
        'DiscountID' => ['Discount ID'],
        'CurrencyCode' => ['Currency Code'],
        'GrandTotal' => ['Grand Total', true],
        'Type' => ['Payment Type', true],
        'PaymentTypeID' => ['Payment Type ID'],
        'PaymentTypeName' => ['Payment Type Name'],
        'PaymentTypeImage' => ['Payment Type Image'],
        'AccountNumber' => ['Account Number'],
        'BeneficiaryName' => ['Beneficiary Name'],
        'UniqueOrder' => ['Unique Order'],
        'GrandTotalUnique' => ['Grand Total Unique'],
        'VANumber' => ['VA Number'],
        'Notes' => ['Notes'],
        'StatusOrder' => ['Status Order', true],
        'StatusPaid' => ['Status Paid', true],
        'CreatedDate' => ['Created Date', true],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'ChangeStatusPaid' :
                    $this->_loaddbclass([ 'OrderTransaction' ]);
                    $id = $request['value'];
                    $OrderTransaction = $this->OrderTransaction->where([['ID','=',$id]])->first();

                    if($OrderTransaction) {
                        $TransactionCode = $OrderTransaction->TransactionCode;

                        $StatusPaid = 1;
                        if($OrderTransaction->StatusPaid == 1) $StatusPaid = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];

                        $array[$this->inv['flip']['StatusPaid']] = $StatusPaid;
                        $array[$this->inv['flip']['StatusOrder']] = 1;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $OrderTransaction->update($array);

                        if($StatusPaid) $StatusPaid = 'Paid';
                        else $StatusPaid = 'Unpaid';

                        $this->_dblog('edit', $this, 'Set '.$StatusPaid.' '.$TransactionCode);

                        die(json_encode(['response' => 'OK', 'data' => 'Processing'], JSON_FORCE_OBJECT));
                    } else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                break;
            }
        }
    }

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->views();
    }
    
    public function detail()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->getdata();
    }

    private function getdata()
    {
        $TransactionCode = $CustomerName = $AsGuest = $CurrencyCode = $StoreCreditAmount = $VoucherCode = $VoucherAmount = $DiscountName = $DiscountAmount = $PaymentDetail = $VANumber = $Notes = $StatusOrder = $StatusPaid = $CreatedDate = '';
        $GrandTotal = $Type = $UniqueOrder = $GrandTotalUnique = 0;

        $arraypaymenttype = [
            0 => 'Bank Transfer',
            1 => 'Virtual Account',
            2 => 'Internet Banking',
            3 => 'Credit Card / Virtual Card',
            4 => 'Another / Gerai'
        ];

        $arraystatusorder = [
            0 => 'Ordering',
            1 => 'Processing',
            2 => 'Success',
            3 => 'Auto Cancel',
            4 => 'Manual Cancel'
        ];

        $arraystatuspaid = [
            0 => 'UNPAID',
            1 => 'PAID',
        ];

        $ArrOrderTransactionSeller = [];

        if (isset($this->inv['getid'])) {
            if (!$this->_checkpermalink($this->inv['getid'])) {

                $this->_loaddbclass(['OrderTransaction','OrderTransactionSeller','OrderTransactionDetail']);

                $OrderTransaction = $this->OrderTransaction->leftjoin([
                    ['customer as c', 'c.ID', '=', 'order_transaction.CustomerID'],
                    ['discount as d', 'd.ID', '=', 'order_transaction.DiscountID'],
                ])->selectraw('
                    c.FullName as CustomerName,
                    d.Name as DiscountName,
                    order_transaction.*
                ')->where([['order_transaction.ID', '=', $this->inv['getid']]])->first();
                if ($OrderTransaction) {
                    $TransactionCode = $OrderTransaction->TransactionCode;

                    if(!$OrderTransaction->CustomerName)
                        $CustomerName = $OrderTransaction->AsGuest;

                    $AsGuest = $OrderTransaction->AsGuest;
                    $CurrencyCode = $OrderTransaction->CurrencyCode;

                    if($CurrencyCode == 'IDR')
                        $StoreCreditAmount = $this->_formatamount($OrderTransaction->StoreCreditAmount, 'Rupiah', $CurrencyCode.' ');
                    else
                        $StoreCreditAmount = $this->_formatamount($OrderTransaction->StoreCreditAmount, 'Dollar', $CurrencyCode.' ');

                    $VoucherCode = $OrderTransaction[$this->inv['flip']['VoucherCode']];

                    if($CurrencyCode == 'IDR')
                        $VoucherAmount = $this->_formatamount($OrderTransaction->VoucherAmount, 'Rupiah', $CurrencyCode.' ');
                    else
                        $VoucherAmount = $this->_formatamount($OrderTransaction->VoucherAmount, 'Dollar', $CurrencyCode.' ');

                    $DiscountName = $OrderTransaction->DiscountName;

                    if($CurrencyCode == 'IDR')
                        $DiscountAmount = $this->_formatamount(0, 'Rupiah', $CurrencyCode.' ');
                    else
                        $DiscountAmount = $this->_formatamount(0, 'Dollar', $CurrencyCode.' ');

                    if($CurrencyCode == 'IDR')
                        $GrandTotal = $this->_formatamount($OrderTransaction->GrandTotal, 'Rupiah', $CurrencyCode.' ');
                    else
                        $GrandTotal = $this->_formatamount($OrderTransaction->GrandTotal, 'Dollar', $CurrencyCode.' ');

                    $Type = $OrderTransaction->Type;
                    $PaymentDetail = '<img src="'.$this->inv['basesite'].'assets/frontend/images/content/paymenttype/'.$OrderTransaction->PaymentTypeImage.'?'.uniqid().'" height="20px;"/> ( '.$OrderTransaction->PaymentTypeName.' ) '. $arraypaymenttype[$Type];

                    if($Type == 0) {
                        $PaymentDetail .= '<br/>Account Number : '.$OrderTransaction->AccountNumber;
                        $PaymentDetail .= '<br/>Beneficiary Name : '.$OrderTransaction->BeneficiaryName;
                    }
                    
                    if($CurrencyCode == 'IDR')
                        $UniqueOrder = $this->_formatamount($OrderTransaction->UniqueOrder, 'Rupiah', $CurrencyCode.' ');
                    else
                        $UniqueOrder = $this->_formatamount($OrderTransaction->UniqueOrder, 'Dollar', $CurrencyCode.' ');
                    
                    if($CurrencyCode == 'IDR')
                        $GrandTotalUnique = $this->_formatamount($OrderTransaction->GrandTotalUnique, 'Rupiah', $CurrencyCode.' ');
                    else
                        $GrandTotalUnique = $this->_formatamount($OrderTransaction->GrandTotalUnique, 'Dollar', $CurrencyCode.' ');
                    
                    $VANumber = $OrderTransaction->VANumber;
                    $Notes = $OrderTransaction->Notes;
                    $StatusOrder = $OrderTransaction->StatusOrder;
                    $StatusPaid = $OrderTransaction->StatusPaid;
                    $CreatedDate = $this->_datetimeforhtml($OrderTransaction->CreatedDate, 'red');

                    $ArrOrderTransactionSeller = $this->OrderTransactionSeller->leftjoin([
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
                    ')->where([['TransactionCode', '=', $TransactionCode]])->get()->toArray();

                    foreach ($ArrOrderTransactionSeller as $key => $value) {
                        $ArrOrderTransactionSeller[$key]['ListProduct'] = $this->OrderTransactionDetail->leftjoin([
                            ['product as p', 'p.ID', '=', 'order_transaction_detail.ProductID'],
                            ['colors as c', 'c.ID', '=', 'order_transaction_detail.ColorID'],
                            ['size_variant as sv', 'sv.ID', '=', 'order_transaction_detail.SizeVariantID'],
                        ])->selectraw('
                            c.Name as ColorName,
                            sv.Name as SizeVariantName,
                            p.*,
                            order_transaction_detail.*
                        ')->where([
                            ['order_transaction_detail.TransactionCode', '=', $value['TransactionCode']],
                            ['order_transaction_detail.SellerID', '=', $value['SellerID']],
                            ['order_transaction_detail.ShippingID', '=', $value['ShippingID']],
                            ['order_transaction_detail.ShippingPackageID', '=', $value['ShippingPackageID']],
                            ['order_transaction_detail.IDDistrict', '=', $value['IDDistrict']],
                        ])->get()->toArray();
                    }
                } else {
                    $this->inv['messageerror'] = $this->_trans('validation.norecord');
                }
            } else {
                $this->inv['messageerror'] = $this->_trans('validation.norecord');
            }
        }

        $arraystatusshipment = [
            0 => 'New Order',
            1 => 'Ready to Pickup',
            2 => 'Has Shipped',
            3 => 'Delivered'
        ];
        $this->inv['TransactionCode'] = $TransactionCode;
        $this->inv['CustomerName'] = $CustomerName;
        $this->inv['AsGuest'] = $AsGuest;
        $this->inv['CurrencyCode'] = $CurrencyCode;
        $this->inv['StoreCreditAmount'] = $StoreCreditAmount;
        $this->inv['VoucherCode'] = $VoucherCode;
        $this->inv['VoucherAmount'] = $VoucherAmount;
        $this->inv['DiscountName'] = $DiscountName;
        $this->inv['DiscountAmount'] = $DiscountAmount;
        $this->inv['GrandTotal'] = $GrandTotal;
        $this->inv['Type'] = $arraypaymenttype[$Type];
        $this->inv['PaymentDetail'] = $PaymentDetail;
        $this->inv['UniqueOrder'] = $UniqueOrder;
        $this->inv['GrandTotalUnique'] = $GrandTotalUnique;
        $this->inv['VANumber'] = $VANumber;
        $this->inv['Notes'] = $Notes;
        $this->inv['StatusOrder'] = $arraystatusorder[$StatusOrder];
        $this->inv['StatusPaid'] = $arraystatuspaid[$StatusPaid];
        $this->inv['CreatedDate'] = $CreatedDate;
        $this->inv['ArrOrderTransactionSeller'] = $ArrOrderTransactionSeller;
        $this->inv['arraystatusshipment'] = $arraystatusshipment;

        return $this->_showview(["new"]);
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'Seller', 'OrderTransaction' ]);

        $result = $this->OrderTransaction->leftjoin([
            ['order_transaction_detail as otd', 'otd.TransactionCode', '=', 'order_transaction.TransactionCode'],
            ['customer as c', 'c.ID', '=', 'order_transaction.CustomerID'],
        ])->selectraw('
            c.FullName as CustomerName,
            order_transaction.*
        ');

        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();

        if($Seller)
            $result = $result->where([['otd.SellerID', '=', $Seller->ID]])
                        ->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        else 
            $result = $result->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        $result = $result->groupBy('order_transaction.TransactionCode');

        $this->inv['flip']['TransactionCode'] = 'order_transaction.TransactionCode';
        $this->inv['flip']['CustomerName'] = 'c.FullName';
        $this->inv['flip']['CreatedDate'] = 'order_transaction.CreatedDate';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['TransactionCode'] = 'TransactionCode';
        $this->inv['flip']['CustomerName'] = 'CustomerName';
        $this->inv['flip']['CreatedDate'] = 'CreatedDate';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            $arraypaymenttype = [
                0 => 'Bank Transfer',
                1 => 'Virtual Account',
                2 => 'Internet Banking',
                3 => 'Credit Card / Virtual Card',
                4 => 'Another / Gerai'
            ];
            $arraystatusorder = [
                0 => 'Ordering',
                1 => 'Processing',
                2 => 'Success',
                3 => 'Auto Cancel',
                4 => 'Manual Cancel'
            ];
            $arraystatuspaid = [
                0 => 'UNPAID',
                1 => 'PAID',
            ];
            for($i = 0; $i < count($result['data']); $i++) {

                if(!$result['data'][$i]['CustomerName']) $result['data'][$i]['CustomerName'] = $result['data'][$i]['AsGuest'];
                if($result['data'][$i]['AsGuest']) $result['data'][$i]['CustomerName'] = '<label class="badge badge-roundless badge-success">GUEST</label><br/>'.$result['data'][$i]['CustomerName'];
                
                if($result['data'][$i]['GrandTotalUnique'] > $result['data'][$i]['GrandTotal'])
                    $result['data'][$i]['GrandTotal'] = $result['data'][$i]['GrandTotalUnique'];
                else
                    $result['data'][$i]['GrandTotal'] = $result['data'][$i]['GrandTotal'];

                if($result['data'][$i]['CurrencyCode'] == 'IDR')
                    $result['data'][$i]['GrandTotal'] = $this->_formatamount($result['data'][$i]['GrandTotal'], 'Rupiah', $result['data'][$i]['CurrencyCode'].' ');
                else
                    $result['data'][$i]['GrandTotal'] = $this->_formatamount($result['data'][$i]['GrandTotal'], 'Dollar', $result['data'][$i]['CurrencyCode'].' ');

                $result['data'][$i]['GrandTotal'] = '<table><tr><td style="border:none !important;padding:0 !important;margin:0 !important;">'.explode(' ', $result['data'][$i]['GrandTotal'])[0].' </td><td style="border:none !important;padding:0 !important;margin:0 !important; text-align:right;">'.explode(' ', $result['data'][$i]['GrandTotal'])[1].'</td></tr></table>';

                $result['data'][$i]['StatusOrder'] = $arraystatusorder[$result['data'][$i]['StatusOrder']];

                $result['data'][$i]['CreatedDate'] = $this->_datetimeforhtml($result['data'][$i]['CreatedDate'], 'red');

                if($result['data'][$i]['Type'] == 0) {
                    $check = '';
                    if ($result['data'][$i][$this->inv['flip']['StatusPaid']] == 1) $check = 'checked disabled';

                    $result['data'][$i][$this->inv['flip']['StatusPaid']] = '<input type="checkbox" data-size="small" class="make-switch ChangeStatusPaid ' . $result['data'][$i][$this->inv['flip']['OrderTransactionID']] . '" data-label-icon="fa fa-youtube" data-on-text="<i class=\'fa fa-thumbs-up\'></i>" data-off-text="<i class=\'fa fa-thumbs-down\'></i>" data-on-color="success" data-off-color="danger" ' . $check . ' rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['StatusPaid'][0]]) . '">';
                } else {
                    $check = '';
                    if ($result['data'][$i][$this->inv['flip']['StatusPaid']] == 1) $check = 'checked';

                    $result['data'][$i][$this->inv['flip']['StatusPaid']] = '<input type="checkbox" data-size="small" class="make-switch ChangeStatusPaid ' . $result['data'][$i][$this->inv['flip']['OrderTransactionID']] . '" data-label-icon="fa fa-youtube" data-on-text="<i class=\'fa fa-thumbs-up\'></i>" data-off-text="<i class=\'fa fa-thumbs-down\'></i>" data-on-color="success" data-off-color="danger" ' . $check . ' disabled rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['StatusPaid'][0]]) . '">';
                    // $result['data'][$i]['StatusPaid'] = $arraystatuspaid[$result['data'][$i]['StatusPaid']];
                }

                $result['data'][$i]['Type'] = $arraypaymenttype[$result['data'][$i]['Type']];
                if($result['data'][$i]['PaymentTypeName'])
                    $result['data'][$i]['Type'] = '<label class="badge badge-roundless badge-success">'.$result['data'][$i]['PaymentTypeName'].'</label><br/>'.$result['data'][$i]['Type'];
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}