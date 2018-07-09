<?php
namespace App\Modules\dashboard\Http\Controllers\orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class transferconfirmationController extends Controller
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
        'ID' => 'TransferConfirmationID',
        'TransactionCode' => 'TransactionCode',
        'BankName' => 'BankName',
        'BankBeneficiaryName' => 'BankBeneficiaryName',
        'GrandTotal' => 'GrandTotal',
        'TransferDate' => 'TransferDate',
        'OurBankID' => 'OurBankID',
        'OurBankName' => 'OurBankName',
        'ImageTransfer' => 'ImageTransfer',
        'CreatedDate' => 'CreatedDate',
        'idfunction' => 'ID',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage' => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'TransferConfirmationID' => ['Transfer Confirmation ID'],
        'TransactionCode' => ['Transaction Code', true],
        'BankName' => ['Bank Name', true],
        'BankBeneficiaryName' => ['Bank Beneficiary Name', true],
        'GrandTotal' => ['Grand Total', true],
        'TransferDate' => ['Transfer Date', true],
        'OurBankID' => ['Our Bank ID'],
        'OurBankName' => ['Our Bank Name', true],
        'ImageTransfer' => ['Image Transfer', true, '', 'image'],
        'CreatedDate' => ['Created Date', true],
    ];

    var $objectkey = '', $TransferConfirmationID = '', $errorTransferConfirmationID = '', $TransactionCode = '', $errorTransactionCode = '', $BankName = '', $errorBankName = '', $BankBeneficiaryName = '', $errorBankBeneficiaryName = '', $GrandTotal = '', $errorGrandTotal = '', $TransferDate = '', $errorTransferDate = '', $OurBankID = '', $errorOurBankID = '', $ImageTransfer = '', $errorImageTransfer = '', $CreatedDate = '', $errorCreatedDate = '';

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->views();
    }
    
    private function addnewedit() {
        $request = \Request::instance()->request->all();
        $requestfile = \Request::file();

        $this->inv['TransferConfirmationID'] = $this->TransferConfirmationID; $this->inv['errorTransferConfirmationID'] = $this->errorTransferConfirmationID;
        $this->inv['TransactionCode'] = $this->TransactionCode; $this->inv['errorTransactionCode'] = $this->errorTransactionCode;
        $this->inv['BankName'] = $this->BankName; $this->inv['errorBankName'] = $this->errorBankName;
        $this->inv['BankBeneficiaryName'] = $this->BankBeneficiaryName; $this->inv['errorBankBeneficiaryName'] = $this->errorBankBeneficiaryName;
        $this->inv['GrandTotal'] = $this->GrandTotal; $this->inv['errorGrandTotal'] = $this->errorGrandTotal;
        $this->inv['TransferDate'] = $this->TransferDate; $this->inv['errorTransferDate'] = $this->errorTransferDate;
        $this->inv['OurBankID'] = $this->OurBankID; $this->inv['errorOurBankID'] = $this->errorOurBankID;
        $this->inv['ImageTransfer'] = $this->ImageTransfer; $this->inv['errorImageTransfer'] = $this->errorImageTransfer;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;

        return $this->_showview(["new"]);
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'TransferConfirmation' ]);

        $result = $this->TransferConfirmation->leftjoin([
            ['order_transaction as ot', 'ot.TransactionCode', '=', 'transfer_confirmation.TransactionCode'],
            ['customer as c', 'c.ID', '=', 'ot.CustomerID'],
            ['our_bank as b', 'b.ID', '=', 'transfer_confirmation.OurBankID'],
        ])->selectraw('
            ot.CurrencyCode,
            c.FullName,
            b.BankName as OurBankName,
            transfer_confirmation.*
        ')->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                if($result['data'][$i]['CurrencyCode'] == 'IDR')
                    $result['data'][$i][$this->inv['flip']['GrandTotal']] = $this->_formatamount($result['data'][$i][$this->inv['flip']['GrandTotal']], 'Rupiah', $result['data'][$i]['CurrencyCode'].' ');
                else
                    $result['data'][$i][$this->inv['flip']['GrandTotal']] = $this->_formatamount($result['data'][$i][$this->inv['flip']['GrandTotal']], 'Dollar', $result['data'][$i]['CurrencyCode'].' ');

                if ($result['data'][$i][$this->inv['flip']['ImageTransfer']]) {
                    $result['data'][$i][$this->inv['flip']['ImageTransfer']] = $this->inv['basesite'] . 'assets/backend/images/transfer-confirmation/small_' . $result['data'][$i][$this->inv['flip']['ImageTransfer']];
                }

                if($result['data'][$i][$this->inv['flip']['TransferDate']] != '0000-00-00')
                    $result['data'][$i][$this->inv['flip']['TransferDate']] = $this->_dateforhtml($result['data'][$i][$this->inv['flip']['TransferDate']]);
                else $result['data'][$i][$this->inv['flip']['TransferDate']] = '';

                if($result['data'][$i][$this->inv['flip']['CreatedDate']] != '0000-00-00')
                    $result['data'][$i][$this->inv['flip']['CreatedDate']] = str_replace(':00</span>','',$this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['CreatedDate']], 'red'));
                else $result['data'][$i][$this->inv['flip']['CreatedDate']] = '';
            }
            $this->_setdatapaginate($result);
        }
        
        return $this->_showview($views);
    }
}