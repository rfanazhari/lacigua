<?php

namespace App\Modules\dashboard\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class salesreportController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => false, // Active all header function. If all true and this check false then header not show.
        'search'    => false,
        'addnew'    => false,
        'refresh'   => false,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc
    public $alias = [
        'ID'                => 'ProductID',
        'ShippingID'        => 'ShippingID',
        'CategoryID'        => 'CategoryID',
        'SubCategoryID'     => 'SubCategoryID',
        'BrandID'           => 'BrandID',
        'PaymentTypeID'     => 'PaymentTypeID',
        'StatusOrder'       => 'StatusOrder',
        'StatusPaid'        => 'StatusPaid',
        'ReportDateFrom'    => 'ReportDateFrom',
        'ReportDateTo'      => 'ReportDateTo',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'         => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'ProductID'         => ['Product Name'],
        'ShippingID'        => ['Shipping Name'],
        'CategoryID'        => ['Category Name'],
        'BrandID'           => ['Brand Name'],
        'SubCategoryID'     => ['Subcategory Name'],
        'PaymentTypeID'     => ['Payment Type'],
        'StatusOrder'       => ['Status Order'],
        'StatusPaid'        => ['Status Paid'],
        'ReportDateFrom'    => ['Report Date From'],
        'ReportDateTo'      => ['Report Date To'],
    ];

    var $ProductID = '', $ShippingID = '', $CategoryID = '', $BrandID = '',  $PaymentTypeID = '', $StatusOrder = '', $StatusPaid = '', $ReportDateFrom = '', $ReportDateTo = '';

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        $request = \Request::instance()->request->all();

        if(isset($request['download'])) {
            $this->BrandID          = $request['BrandID'];
            $this->CategoryID       = $request['CategoryID'];
            $this->SubCategoryID    = $request['SubCategoryID'];
            $this->ShippingID       = $request['ShippingID'];
            $this->PaymentTypeID    = $request['PaymentTypeID'];
            $this->StatusOrder      = $request['StatusOrder'];
            $this->ReportDateFrom   = $request['ReportDateFrom'];
            $this->ReportDateTo     = $request['ReportDateTo'];
            

            if(!$this->ReportDateFrom || !$this->ReportDateTo) {
                $this->inv['messageerror'] = 'Please select date range for get report !';
            } else {
                $this->_loaddbclass([ 'OrderTransaction' ]);

                $OrderTransaction = $this->OrderTransaction->leftjoin([
                    ['customer', 'customer.ID', '=', 'order_transaction.CustomerID'],
                    ['order_transaction_detail as a', 'a.TransactionCode', '=', 'order_transaction.TransactionCode'],
                    ['order_transaction_seller as b', 'b.TransactionCode', '=', 'order_transaction.TransactionCode'],
                    ['seller as c', 'c.ID', '=', 'a.SellerID'],
                    ['shipping as d', 'd.ID', '=', 'a.ShippingID'],
                    ['product as e', 'e.ID', '=', 'a.ProductID'],
                    ['colors as f', 'f.ID', '=', 'a.ColorID'],
                    ['size_variant as g', 'g.ID', '=', 'a.SizeVariantID'],
                    ['province as h', 'h.ID', '=', 'a.ProvinceID'],
                    ['city as i', 'i.ID', '=', 'a.CityID'],
                    ['district as j', 'j.ID', '=', 'a.DistrictID'],
                    ['discount as k', 'k.ID', '=', 'order_transaction.DiscountID'],
                    ['brand as m', 'm.ID', '=', 'e.BrandID'],
                    ['category as n', 'n.ID', '=', 'e.CategoryID'],
                    ['sub_category as o', 'o.IDCategory', '=', 'n.ID'],
                ])->select([
                    'order_transaction.ID',
                    'order_transaction.TransactionCode',
                    'customer.FirstName',
                    'customer.LastName',
                    'd.Name as NameShipping',
                    'a.ShippingPackageID as ShippingPackage',
                    'a.ShippingPrice',
                    'm.name as BrandName',
                    'e.ModelType as Model',
                    'n.Name as Category',
                    'o.Name as SubCategory',
                    'e.Name as NameProduct',
                    'a.ProductPrice as ProductPrice',
                    'a.Qty',
                    'f.Name as ColorName',
                    'g.Name as SizeName',
                    'a.Notes',
                    'a.AddressInfo',
                    'a.RecepientName',
                    'a.RecepientPhone',
                    'a.Address',
                    'h.Name as ProvinceName',
                    'i.Alias as AliasCity',
                    'i.Name as CityName',
                    'j.Name as DistrictName',
                    'a.PostalCode as CodePost',
                    'a.FeedbackAccuration',
                    'a.FeedbackQuality',
                    'a.FeedbackService',
                    'a.FeedbackDate',
                    'b.TransactionSellerCode',
                    'c.FullName as NameSeller',
                    'b.QtyProductShip',
                    'b.WeightProductShip',
                    'b.PriceProductShip',
                    'b.DescProductShip',
                    'b.ShippingPrice',
                    'b.AWBNumber as NomorResi',
                    'b.PackageData',
                    'b.StatusShipment',
                    'order_transaction.StoreCreditAmount',
                    'order_transaction.VoucherCode',
                    'order_transaction.VoucherAmount',
                    'order_transaction.TransactionCode',
                    'k.Name as DiscountName',
                    'order_transaction.DiscountAmount',
                    'order_transaction.DiscountInfo',
                    'order_transaction.GrandTotal',
                    'order_transaction.PaymentTypeName',
                    'order_transaction.PaymentTypeImage',
                    'order_transaction.AccountNumber',
                    'order_transaction.BeneficiaryName',
                    'order_transaction.UniqueOrder',
                    'order_transaction.GrandTotalUnique',
                    'order_transaction.VANumber',
                    'order_transaction.Notes',
                    'order_transaction.StatusOrder',
                    'order_transaction.StatusPaid',
                    'order_transaction.CreatedDate',
                    \DB::Raw('(
                        case when (order_transaction.Type != 0) 
                        THEN
                            order_transaction.GrandTotal
                        ELSE
                            order_transaction.GrandTotalUnique
                        END
                    ) as TotalTransaksi')
                ])->where('StatusPaid', '=', '1');
                    
                if(is_numeric($this->BrandID)) {
                    $OrderTransaction = $OrderTransaction->where(function ($query) {
                        $query->where('m.ID', '=', $this->BrandID);
                    });
                }

                if(is_numeric($this->CategoryID)) {
                    $OrderTransaction = $OrderTransaction->where(function ($query) {
                        $query->where('n.ID', '=', $this->CategoryID);
                    });
                }

                if(is_numeric($this->SubCategoryID)) {
                    $OrderTransaction = $OrderTransaction->where(function ($query) {
                        $query->where('o.ID', '=', $this->SubCategoryID);
                    });
                }
                
                if(is_numeric($this->ShippingID)) {
                    $OrderTransaction = $OrderTransaction->where('a.ShippingID', $this->ShippingID);
                }
                
                if(is_numeric($this->Type)) {
                    $OrderTransaction = $OrderTransaction->where('order_transaction.PaymentTypeID', $this->PaymentTypeID);
                }

                if(is_numeric($this->StatusPaid)) {
                    $OrderTransaction = $OrderTransaction->where('StatusPaid', $this->StatusPaid);
                }

                $OrderTransaction = $OrderTransaction->where(function ($query) {
                    $query->whereBetween('order_transaction.CreatedDate', array($this->_dateformysql($this->ReportDateFrom), $this->_dateformysql($this->ReportDateTo)));
                });
                
                $OrderTransaction = $OrderTransaction;
                $tmpBookingOrder = $OrderTransaction;
                
                if($tmpBookingOrder->get()) {
                    $objPHPExcel = new \PHPExcel();

                    $sheet = $objPHPExcel->setActiveSheetIndex(0);

                    
                    $arraytitle = [
                        // 'ID'                    =>  'Number ID',
                        'TransactionCode'       =>  'Transaction Code',
                        'FirstName'             =>  'First Name',
                        'LastName'              =>  'Last Name',
                        'NameShipping'          =>  'Shipping Name',
                        'ShippingPackage'       =>  'Shipping Package',
                        'ShippingPrice'         =>  'Shipping Price',
                        'BrandName'             =>  'Brand Name',
                        'Model'                 =>  'Model',
                        'Category'              =>  'Category',
                        'SubCategory'           =>  'Sub Category',
                        'NameProduct'           =>  'Name Product',
                        'ProductPrice'          =>  'Product Price',
                        'Qty'                   =>  'Quantity',
                        'ColorName'             =>  'Color Name',
                        'SizeName'              =>  'Size Name',
                        'Notes'                 =>  'Notes',
                        'AddressInfo'           =>  'Address Info',
                        'RecepientName'         =>  'Recepient Name',
                        'RecepientPhone'        =>  'Recepient Phone',
                        'Address'               =>  'Address',
                        'ProvinceName'          =>  'Province Name',
                        'AliasCity'             =>  'City Name',
                        // 'CityName'              =>  'City Name',
                        'DistrictName'          =>  'District Name',
                        'CodePost'              =>  'Code Post',
                        'FeedbackAccuration'    =>  'Feedback Accuration',
                        'FeedbackQuality'       =>  'Feedback Quality',
                        'FeedbackService'       =>  'Feedback Service',
                        'FeedbackDate'          =>  'Feedback Date',
                        'TransactionSellerCode' =>  'Transaction Seller Code',
                        'NameSeller'            =>  'Name Seller',
                        'QtyProductShip'        =>  'Quantity Product Ship',
                        'WeightProductShip'     =>  'Weight Product Ship',
                        'PriceProductShip'      =>  'Price Product Ship',
                        // 'DescProductShip'       =>  'Desc Product Ship',
                        'ShippingPrice'         =>  'Shipping Price',
                        'NomorResi'             =>  'Nomor Resi',
                        // 'PackageData'           =>  'Package Data',
                        'StatusShipment'        =>  'Status Shipment',
                        'StoreCreditAmount'     =>  'Store Credit Amount',
                        'VoucherCode'           =>  'Voucher Code',
                        'VoucherAmount'         =>  'Voucher Amount',
                        'TransactionCode'       =>  'Transaction Code',
                        'DiscountName'          =>  'Discount Name',
                        'DiscountAmount'        =>  'Discount Amount',
                        'DiscountInfo'          =>  'Discount Info',
                        // 'GrandTotal'            =>  'Grand Total',
                        'PaymentTypeName'       =>  'Payment Type Name',
                        // 'PaymentTypeImage'      =>  'Payment Type Image',
                        // 'AccountNumber'         =>  'Account Number',
                        // 'BeneficiaryName'       =>  'Beneficiary Name',
                        'UniqueOrder'           =>  'Unique Order',
                        'TotalTransaksi'        =>  'Total Transaksi',
                        'VANumber'              =>  'VA Number',
                        'Notes'                 =>  'Notes',
                        'StatusOrder'           =>  'Status Order',
                        'StatusPaid'            =>  'Status Paid',
                        'CreatedDate'           =>  'Created Date'
                    ];

                    $loop = 0;
                    foreach ($arraytitle as $key => $value) {
                        $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'1', $value);
                        $loop++;
                    }

                    $arrstatusorder = [
                        0 => 'Ordering',
                        1 => 'Booking',
                        2 => 'Canceling',
                        3 => 'Return',
                    ];
                    $arrstatuspaid = [
                        0 => 'Unpaid',
                        1 => 'Paid',
                        2 => 'Return',
                    ];

                    $arrshippment = [
                        0 => 'Creating',
                        1 => 'Packaging',
                        2 => 'On The Way',
                        3 => 'Delivered',
                    ];
                    $arrcity = [
                        'Kabupaten' => 'Kab',
                        'Kota'      => 'Kota',
                    ];

                    $loop = 2;
                    foreach ($OrderTransaction->get() as $obj) {
                        $loop2 = 0;
                        foreach ($arraytitle as $key => $value) {
                            $column = $obj->$key;
                            if(in_array($key, ['TransactionCode', 'TransactionSellerCode'])) {
                                if($column) $column = "'".$column;
                            }
                            if(in_array($key, ['StatusOrder'])) {
                                if(is_numeric($column)) $column = $arrstatusorder[$column];
                            }
                            if(in_array($key, ['StatusShipment'])) {
                                if(is_numeric($column)) $column = $arrshippment[$column];
                            }
                            if(in_array($key, ['StatusPaid'])) {
                                if(is_numeric($column)) $column = $arrstatuspaid[$column];
                            }
                            if(in_array($key, ['AliasCity'])) {
                                if($column) $column = $arrcity[$column] . ' ' . $obj['CityName'] ;
                            }

                            $sheet->setCellValue($this->_excelnamefromnumber($loop2+1).$loop, $column);
                            $loop2++;
                        }
                        $loop++;
                    }

                    $filename = str_replace(' ', '_', 'Order Transaction '.$this->ReportDateFrom.' '.$this->ReportDateTo);
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
                    header('Cache-Control: max-age=0');

                    $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $writer->save('php://output');
                    exit;
                }
            }
        }
     
        $this->_loaddbclass(['Product', 'Shipping', 'PaymentType', 'Seller', 'Brand', 'Category']);

        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        if($Seller) {
            $arrBrand       = $this->Brand->where([['SellerID', '=', $Seller->ID]])->get()->toArray();
        }

        $arrproduct     = $this->Product->getmodel()->get()->toArray();
        $arrshipping    = $this->Shipping->getmodel()->get()->toArray();
        $arrpaymenttype = $this->PaymentType->getmodel()->get()->toArray();
        $arrseller      = $this->Seller->getmodel()->get()->toArray();
        $arrcategory    = $this->Category->getmodel()->get()->toArray();
        

        $arrstatusorder = [
            0 => 'Ordering',
            1 => 'Booking',
            2 => 'Success',
            3 => 'Auto Cancel',
            4 => 'Manual Cancel',
        ];
        $arrstatuspaid = [
            0 => 'Unpaid',
            1 => 'Paid',
        ];

        $this->inv['arrproduct']        = $arrproduct;
        $this->inv['arrshipping']       = $arrshipping;
        $this->inv['arrpaymenttype']    = $arrpaymenttype;
        $this->inv['arrbrand']          = $arrBrand;
        $this->inv['arrcategory']       = $arrcategory;
        $this->inv['arrstatusorder']    = $arrstatusorder;
        $this->inv['arrstatuspaid']     = $arrstatuspaid;
        $this->inv['ProductID']         = $this->ProductID;
        $this->inv['ShippingID']        = $this->ShippingID;
        $this->inv['BrandID']           = $this->BrandID;
        $this->inv['CategoryID']        = $this->CategoryID;
        $this->inv['PaymentTypeID'] = $this->PaymentTypeID;
        $this->inv['StatusOrder'] = $this->StatusOrder;
        $this->inv['StatusPaid'] = $this->StatusPaid;
        $this->inv['ReportDateFrom'] = $this->ReportDateFrom;
        $this->inv['ReportDateTo'] = $this->ReportDateTo;

       //$this->_debugvar($this->inv);
        return $this->_showview(['new']);
    }

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;
        
        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            $this->_loaddbclass(['SubCategory']);

            switch($request['ajaxpost']) {
                case 'getSubCat' :
                        $Category = $request['CatID'];
                        if($Category) {
                            $SubCat = $this->SubCategory->where([['IDCategory','=',$Category]])->get()->toArray();
                            die(json_encode(['response' => 'OK','data' => $SubCat], JSON_FORCE_OBJECT));
                        } else die(json_encode(['response' => 'Error'], JSON_FORCE_OBJECT));
                    break;
            }
        }
    }
}