<?php
namespace App\Modules\dashboard\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class productreturnController extends Controller
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
        'ID' => 'ProductReturnID',
        'OrderTransactionDetailID' => 'OrderTransactionDetailID',
        'TransactionCode' => 'TransactionCode',
        'FullName' => 'FullName',
        'NameShow' => 'NameShow',
        'Qty' => 'Qty',
        'Reason' => 'Reason',
        'Solution' => 'Solution',
        'CreatedDate' => 'CreatedDate',
        'idfunction' => 'ID',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'ProductReturnID' => ['Product Return ID'],
        'OrderTransactionDetailID' => ['Order Transaction Detail ID'],
        'TransactionCode' => ['Transaction Code', true],
        'FullName' => ['Full Name', true],
        'NameShow' => ['Product Name', true],
        'Qty' => ['Return', true],
        'Reason' => ['Reason', true],
        'Solution' => ['Solution', true],
        'CreatedDate' => ['Created Date', true],
    ];

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->views();
    }
    
    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'Seller', 'ProductReturn' ]);

        $result = $this->ProductReturn->leftjoin([
            ['order_transaction_detail as otd', 'otd.ID', '=', 'product_return.OrderTransactionDetailID'],
            ['product as p', 'p.ID', '=', 'otd.ProductID'],
            ['order_transaction as ot', 'ot.TransactionCode', '=', 'otd.TransactionCode'],
            ['customer as c', 'c.ID', '=', 'ot.CustomerID'],
        ])->selectraw('
            otd.TransactionCode,
            p.NameShow,
            ot.AsGuest,
            c.FullName,
            product_return.*
        ');

        $this->inv['flip']['TransactionCode'] = 'otd.TransactionCode';
        $this->inv['flip']['Qty'] = 'product_return.Qty';
        $this->inv['flip']['CreatedDate'] = 'product_return.CreatedDate';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['TransactionCode'] = 'TransactionCode';
        $this->inv['flip']['Qty'] = 'Qty';
        $this->inv['flip']['CreatedDate'] = 'CreatedDate';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            $arrayreason = [
                1 => 'Kebesaran / Kekecilan',
                2 => 'Cacat',
                3 => 'Rusak Saat Pengiriman'
            ];
            $arraysolution = [
                1 => 'Tukar Produk Baru',
                2 => 'Tukar Produk Lain',
                3 => 'Pengembalian Dana'
            ];
            for($i = 0; $i < count($result['data']); $i++) {
                if(!$result['data'][$i]['FullName']) $result['data'][$i]['FullName'] = $result['data'][$i]['AsGuest'];
                $result['data'][$i]['Reason'] = $arrayreason[$result['data'][$i]['Reason']];
                $result['data'][$i]['Solution'] = $arraysolution[$result['data'][$i]['Solution']];
                $result['data'][$i]['CreatedDate'] = $this->_datetimeforhtml($result['data'][$i]['CreatedDate'], 'red');
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}