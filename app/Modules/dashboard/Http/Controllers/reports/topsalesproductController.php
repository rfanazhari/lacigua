<?php

namespace App\Modules\dashboard\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class topsalesproductController extends Controller
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
        'ModelID'           => 'ModelID',
        'SellerID'          => 'SellerID',
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
        'ModelID'           => ['Model Type'],
        'SellerID'          => ['Seller Name'],
        'SubCategoryID'     => ['Subcategory Name'],
        'PaymentTypeID'     => ['Payment Type'],
        'StatusOrder'       => ['Status Order'],
        'StatusPaid'        => ['Status Paid'],
        'ReportDateFrom'    => ['Report Date From'],
        'ReportDateTo'      => ['Report Date To'],
    ];

    var $ProductID = '', $ShippingID = '', $CategoryID = '', $BrandID = '', $ModelID='', $SellerID = '',  $PaymentTypeID = '', $StatusOrder = '', $StatusPaid = '', $ReportDateFrom = '', $ReportDateTo = '';

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        $request = \Request::instance()->request->all();

        if(isset($request['download'])) {
            $this->SellerID         = $request['SellerID'];
            $this->BrandID          = $request['BrandID'];
            $this->ModelID          = $request['ModelID'];
            $this->CategoryID       = $request['CategoryID'];
            $this->SubCategoryID    = $request['SubCategoryID'];
            $this->ReportDateFrom   = $request['ReportDateFrom'];
            $this->ReportDateTo     = $request['ReportDateTo'];
            

            if(!$this->ReportDateFrom || !$this->ReportDateTo) {
                $this->inv['messageerror'] = 'Please select date range for get report !';
            } else {
                $this->_loaddbclass([ 'Product' ]);

                $OrderTransaction = $this->Product->leftjoin([
                    ['order_transaction_detail as a', 'a.ProductID', '=', 'product.ID'],
                    ['order_transaction as b', 'b.TransactionCode', '=', 'a.TransactionCode'],
                    ['seller as c', 'c.ID', '=', 'product.SellerID'],
                    ['brand as m', 'm.ID', '=', 'product.BrandID'],
                    ['category as n', 'n.ID', '=', 'product.CategoryID'],
                    ['sub_category as o', 'o.IDCategory', '=', 'n.ID'],
                    ['colors as p', 'p.ID', '=', 'product.CategoryID'],
                    ['group_size as q', 'q.ID', '=', 'product.GroupSizeID'],
                ])->select([
                    'a.TransactionCode',
                    'a.Qty',
                    'c.FullName as SellerName',
                    'm.Name as BrandName',
                    'product.ID',
                    'product.ModelType as Model',
                    'n.Name as Category',
                    'o.Name as SubCategory',
                    'product.Name as NameProduct',
                    'product.TypeProduct as TypeProduct',
                    'p.Name as ProductColor',
                    'p.Name as GroupSize',
                    'b.CreatedDate',
                    'b.StatusPaid',
                    \DB::Raw('( count(a.Qty)) as TopProduct')
                ])->groupBy('product.ID')->orderBy('TopProduct', 'DESC');
                $OrderTransaction = $OrderTransaction->where(function ($query) {
                    $query->whereBetween('b.CreatedDate', array($this->_dateformysql($this->ReportDateFrom), $this->_dateformysql($this->ReportDateTo)))
                            ->orWhereNull('b.CreatedDate')
                          ;
                });
                
                    
                if(is_numeric($this->SellerID)) {
                    $OrderTransaction = $OrderTransaction->where(function ($query) {
                        $query->where('c.ID', '=', $this->SellerID);
                    });
                }
                    
                if(is_numeric($this->BrandID)) {
                    $OrderTransaction = $OrderTransaction->where(function ($query) {
                        $query->where('m.ID', '=', $this->BrandID);
                    });
                }
                    
                if(is_numeric($this->ModelID)) {
                    $OrderTransaction = $OrderTransaction->where(function ($query) {
                        $query->where('n.ModelType', '=', $this->ModelID);
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
                
                $OrderTransaction = $OrderTransaction;
                $tmpBookingOrder = $OrderTransaction;
               
                if($tmpBookingOrder->get()) {
                    $objPHPExcel = new \PHPExcel();

                    $sheet = $objPHPExcel->setActiveSheetIndex(0);

                    
                    $arraytitle = [
                        // 'ID'                    =>  'Number ID',
                        
                        // 'FirstName'             =>  'First Name',
                        // 'LastName'              =>  'Last Name',
                        // 'NameShipping'          =>  'Shipping Name',
                        // 'ShippingPackage'       =>  'Shipping Package',
                        'SellerName'         =>  'Seller Name',
                        'BrandName'             =>  'Brand Name',
                        'Model'                 =>  'Model',
                        'Category'              =>  'Category',
                        'SubCategory'           =>  'Sub Category',
                        'NameProduct'           =>  'Name Product',
                        'TypeProduct'           =>  'Type Product',
                        'ProductColor'           =>  'Color Product',
                        'GroupSize'           =>  'Group Size',
                        'TopProduct'           =>  'Top Sales Product',
                        // 'TransactionCode'       =>  'Transaction Code',
                        // // 'ProductPrice'          =>  'Product Price',
                        // 'Qty'                   =>  'Quantity',
                        // 'ColorName'             =>  'Color Name',
                        // 'SizeName'              =>  'Size Name',
                        // 'Notes'                 =>  'Notes',
                        // 'AddressInfo'           =>  'Address Info',
                        // 'RecepientName'         =>  'Recepient Name',
                        // 'RecepientPhone'        =>  'Recepient Phone',
                        // 'Address'               =>  'Address',
                        // 'ProvinceName'          =>  'Province Name',
                        // 'AliasCity'             =>  'City Name',
                        // // 'CityName'              =>  'City Name',
                        // 'DistrictName'          =>  'District Name',
                        // 'CodePost'              =>  'Code Post',
                        // 'FeedbackAccuration'    =>  'Feedback Accuration',
                        // 'FeedbackQuality'       =>  'Feedback Quality',
                        // 'FeedbackService'       =>  'Feedback Service',
                        // 'FeedbackDate'          =>  'Feedback Date',
                        // 'TransactionSellerCode' =>  'Transaction Seller Code',
                        // 'NameSeller'            =>  'Name Seller',
                        // 'QtyProductShip'        =>  'Quantity Product Ship',
                        // 'WeightProductShip'     =>  'Weight Product Ship',
                        // 'PriceProductShip'      =>  'Price Product Ship',
                        // // 'DescProductShip'       =>  'Desc Product Ship',
                        // 'ShippingPrice'         =>  'Shipping Price',
                        // 'NomorResi'             =>  'Nomor Resi',
                        // // 'PackageData'           =>  'Package Data',
                        // 'StatusShipment'        =>  'Status Shipment',
                        // 'StoreCreditAmount'     =>  'Store Credit Amount',
                        // 'VoucherCode'           =>  'Voucher Code',
                        // 'VoucherAmount'         =>  'Voucher Amount',
                        // 'TransactionCode'       =>  'Transaction Code',
                        // 'DiscountName'          =>  'Discount Name',
                        // 'DiscountAmount'        =>  'Discount Amount',
                        // 'DiscountInfo'          =>  'Discount Info',
                        // // 'GrandTotal'            =>  'Grand Total',
                        // 'PaymentTypeName'       =>  'Payment Type Name',
                        // // 'PaymentTypeImage'      =>  'Payment Type Image',
                        // // 'AccountNumber'         =>  'Account Number',
                        // // 'BeneficiaryName'       =>  'Beneficiary Name',
                        // 'UniqueOrder'           =>  'Unique Order',
                        // 'TotalTransaksi'        =>  'Total Transaksi',
                        // 'VANumber'              =>  'VA Number',
                        // 'Notes'                 =>  'Notes',
                        // 'StatusOrder'           =>  'Status Order',
                        // 'StatusPaid'            =>  'Status Paid',
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

                    $arryproduct = [
                        0 => 'Fashion',
                        1 => 'Beauty',
                    ];

                    $loop = 2;
                    foreach ($OrderTransaction->get() as $obj) {
                        $loop2 = 0;
                        foreach ($arraytitle as $key => $value) {
                            $column = $obj->$key;
                            if(in_array($key, ['TransactionCode', 'TransactionSellerCode'])) {
                                if($column) $column = "'".$column;
                            }
                            if(in_array($key, ['TypeProduct'])) {
                                if(is_numeric($column)) $column = $arryproduct[$column];
                            }
                            // if(in_array($key, ['StatusShipment'])) {
                            //     if(is_numeric($column)) $column = $arrshippment[$column];
                            // }
                            // if(in_array($key, ['StatusPaid'])) {
                            //     if(is_numeric($column)) $column = $arrstatuspaid[$column];
                            // }
                            // if(in_array($key, ['AliasCity'])) {
                            //     if($column) $column = $arrcity[$column] . ' ' . $obj['CityName'] ;
                            // }

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
     
        $this->_loaddbclass(['Product', 'Shipping', 'PaymentType', 'Seller', 'Brand', 'Category', 'MainCategory']);

     
        $arrproduct     = $this->Product->getmodel()->get()->toArray();
        $arrshipping    = $this->Shipping->getmodel()->get()->toArray();
        $arrpaymenttype = $this->PaymentType->getmodel()->get()->toArray();
        $arrseller      = $this->Seller->getmodel()->get()->toArray();
        $arrcategory    = $this->Category->getmodel()->get()->toArray();
        $arrBrand       = $this->Brand->getmodel()->get()->toArray();
        $arrModel       = $this->MainCategory->getmodel()->get()->toArray();
        

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
        $this->inv['arrModel']          = $arrModel;
        $this->inv['arrseller']         = $arrseller;
        $this->inv['arrcategory']       = $arrcategory;
        $this->inv['arrstatusorder']    = $arrstatusorder;
        $this->inv['arrstatuspaid']     = $arrstatuspaid;
        $this->inv['ProductID']         = $this->ProductID;
        $this->inv['ShippingID']        = $this->ShippingID;
        $this->inv['BrandID']           = $this->BrandID;
        $this->inv['ModelID']           = $this->ModelID;
        $this->inv['SellerID']          = $this->SellerID;
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
            $this->_loaddbclass(['SubCategory', 'Brand']);

            switch($request['ajaxpost']) {
                case 'getBrand' :
                        $Brand = $request['BrandID'];
                        if($Brand) {
                            $SubCat = $this->Brand->where([['SellerID','=',$Brand]])->get()->toArray();
                            die(json_encode(['response' => 'OK','data' => $SubCat], JSON_FORCE_OBJECT));
                        } else die(json_encode(['response' => 'Error'], JSON_FORCE_OBJECT));
                    break;
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