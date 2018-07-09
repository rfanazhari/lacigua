<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class voucherController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => true,
        'refresh'   => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'VoucherID',
        'VoucherCode' => 'VoucherCode',
        'VoucherAmount' => 'VoucherAmount',
        'ValidDate' => 'ValidDate',
        'IsActive' => 'IsActive',
        'Status' => 'Status',
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
        'VoucherID' => ['Voucher ID'],
        'VoucherCode' => ['Voucher Code', true],
        'VoucherAmount' => ['VoucherAmount', true],
        'ValidDate' => ['Valid Date', true],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    var $objectkey = '', $VoucherID = '', $errorVoucherID = '', $VoucherCode = '', $errorVoucherCode = '', $VoucherAmount = '', $errorVoucherAmount = '', $ValidDate = '', $errorValidDate = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    $id = $request['value'];

                    $this->_loaddbclass([ 'Voucher' ]);

                    $Voucher = $this->Voucher->where([['ID','=',$id]])->first();

                    if($Voucher) {
                        $this->VoucherCode = $Voucher[$this->inv['flip']['VoucherCode']];

                        $IsActive = 1;
                        if($Voucher->IsActive == 1) $IsActive = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];
                        
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $Voucher->update($array);

                        if($IsActive) $IsActive = 'Active';
                        else $IsActive = 'Non Active';

                        $this->_dblog('edit', $this, 'Set '.$IsActive.' '.$this->VoucherCode);

                        die('OK');
                    } else die('Error');
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
    
    public function addnew()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->addnewedit();
    }
    
    public function edit()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->getdata();
    }

    private function getdata() {
        if (isset($this->inv['getid'])) {
            if(!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass([ 'Voucher' ]);

                $Voucher = $this->Voucher->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Voucher) {
                    $this->VoucherID = $Voucher[$this->inv['flip']['VoucherID']];
                    $this->VoucherCode = $Voucher[$this->inv['flip']['VoucherCode']];
                    $this->VoucherAmount = $Voucher[$this->inv['flip']['VoucherAmount']];
                    $this->ValidDate = $Voucher[$this->inv['flip']['ValidDate']];
                    $this->IsActive = $Voucher[$this->inv['flip']['IsActive']];
                    $this->Status = $Voucher[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Voucher[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Voucher[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Voucher[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Voucher[$this->inv['flip']['UpdatedBy']];
                } else {
                    $this->inv['messageerror'] = $this->_trans('validation.norecord');
                }
            } else {
                $this->inv['messageerror'] = $this->_trans('validation.norecord');
            }
        }

        return $this->addnewedit();
    }

    private function addnewedit() {
        $request = \Request::instance()->request->all();
        $requestfile = \Request::file();

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([ 'Voucher' ]);

            if(isset($request['edit'])) {
                $Voucher = $this->Voucher->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Voucher) {
                    $this->_redirect('404');
                }
            }

            $this->VoucherCode = $request['VoucherCode'];
            if(empty($this->VoucherCode)) {
                $this->errorVoucherCode = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Voucher.VoucherCode')]
                );
            }

            $Voucher = $this->Voucher->where([[$this->inv['flip']['VoucherCode'], '=', $this->VoucherCode],['Status','=',0]])->first();

            if ($Voucher) {
                if (isset($request['addnew']) && strtoupper($Voucher[$this->inv['flip']['VoucherCode']]) == strtoupper($this->VoucherCode)) {
                    if (!$this->errorVoucherCode) {
                        $this->errorVoucherCode = $this->_trans('validation.already',
                            ['value' => $this->_trans('dashboard.masterdata.Voucher.VoucherCode')]
                        );
                    }
                } else {
                    if ($Voucher[$this->objectkey] != $this->inv['getid']) {
                        if (!$this->errorVoucherCode) {
                            $this->errorVoucherCode = $this->_trans('validation.already',
                                ['value' => $this->_trans('dashboard.masterdata.Voucher.VoucherCode')]
                            );
                        }
                    }
                }
            }

            $this->VoucherAmount = $request['VoucherAmount'];
            if(empty($this->VoucherAmount)) {
                $this->errorVoucherAmount= $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Voucher.VoucherAmount')]
                );
            }

            $this->ValidDate = $request['ValidDate'];
            if(empty($this->ValidDate)) {
                $this->errorValidDate = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Voucher.ValidDate')]
                );
            }

            if(!$this->inv['messageerror'] && !$this->errorVoucherID && !$this->errorVoucherCode && !$this->errorVoucherAmount && !$this->errorValidDate && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {

                $array = array(
                    $this->inv['flip']['VoucherID'] => $this->VoucherID,
                    $this->inv['flip']['VoucherCode'] => $this->VoucherCode,
                    $this->inv['flip']['VoucherAmount'] => $this->VoucherAmount,
                    $this->inv['flip']['ValidDate'] => $this->_datetimeformysql($this->ValidDate),
                );

                $userdata = \Session::get('userdata');
                $userid = $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    
                    $Voucher = $this->Voucher->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->VoucherCode);
                    \Session::put('messagesuccess', "Saving $this->VoucherCode Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Voucher = $this->Voucher->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Voucher->update($array);
                    
                    $this->_dblog('edit', $this, $this->VoucherCode);
                    \Session::put('messagesuccess', "Update $this->VoucherCode Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['VoucherID'] = $this->VoucherID; $this->inv['errorVoucherID'] = $this->errorVoucherID;
        $this->inv['VoucherCode'] = $this->VoucherCode; $this->inv['errorVoucherCode'] = $this->errorVoucherCode;
        $this->inv['VoucherAmount'] = $this->VoucherAmount; $this->inv['errorVoucherAmount'] = $this->errorVoucherAmount;
        $this->inv['ValidDate'] = $this->ValidDate; $this->inv['errorValidDate'] = $this->errorValidDate;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass(['Voucher']);

            foreach($this->inv['delete'] as $val) {
                $Voucher = $this->Voucher->where([[$this->objectkey,'=',$val]])->first();
                if($Voucher) {
                    $this->VoucherCode = $Voucher[$this->inv['flip']['VoucherCode']];
                    
                    $array[$this->inv['flip']['Status']] = 1;
                    $Voucher->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->VoucherCode);
                    $this->inv['messagesuccess'] .= "Delete $this->VoucherCode Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'Voucher' ]);

        $result = $this->Voucher->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';

                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['VoucherID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';

                if($result['data'][$i][$this->inv['flip']['ValidDate']] != '0000-00-00')
                    $result['data'][$i][$this->inv['flip']['ValidDate']] = str_replace(':00</span>','',$this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['ValidDate']], 'red'));
                else $result['data'][$i][$this->inv['flip']['ValidDate']] = '';
            }
            $this->_setdatapaginate($result);
        }
        
        return $this->_showview($views);
    }
}