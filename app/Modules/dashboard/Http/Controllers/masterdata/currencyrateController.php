<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class currencyrateController extends Controller
{

    public $model = 'CurrencyRate';
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
        'ID' => 'CurrencyRateID',
        'CurrencyCodeFrom' => 'CurrencyCodeFrom',
        'CurrencyCodeTo' => 'CurrencyCodeTo',
        'Value' => 'Value',
        'Status' => 'Status',
        'IsActive' => 'IsActive',
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
        'CurrencyRateID' => ['Currency Rate ID'],
        'CurrencyCodeFrom' => ['From ', true],
        'CurrencyCodeTo' => ['To', true],
        'Value' => ['Value', true],
        'Status' => ['Status'],
        'IsActive' => ['Is Active', true],
        'CreatedDate' => ['CreatedDate'],
        'CreatedBy' => ['CreatedBy'],
        'UpdatedDate' => ['UpdatedDate'],
        'UpdatedBy' => ['UpdatedBy'],

    ];

    //var $pathimage = '/resources/assets/backend/images/userdetail/'; //kalau  gak ada image remark aja (buat path images)
    
    var $objectkey = '', $CurrencyRateID = '', $errorCurrencyRateID = '', $CurrencyCodeFrom = '', $errorCurrencyCodeFrom = '', $CurrencyCodeTo = '', $errorCurrencyCodeTo = '', $Value = '', $errorValue = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';    
    //var $optmenu = []; // buat transaksi, klo gak ada transaksi remark aja

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                $id = $request['value'];

                $this->_loaddbclass([ $this->model ]);

                $CurrencyRate = $this->CurrencyRate->where([['ID','=',$id]])->first();

                if($CurrencyRate) {
                    $nama = $CurrencyRate[$this->inv['flip']['CurrencyCodeFrom']].' to '.$CurrencyRate[$this->inv['flip']['CurrencyCodeTo']];

                    $IsActive = 1;
                    if($CurrencyRate->IsActive == 1) $IsActive = 0;

                    $userdata =  \Session::get('userdata');
                    $userid =  $userdata['uuserid'];

                    $array[$this->inv['flip']['IsActive']] = $IsActive;
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $CurrencyRate->update($array);

                    if($IsActive) $IsActive = 'Active';
                    else $IsActive = 'Non Active';

                    $this->_dblog('edit', $this, 'Set '.$IsActive.' '.$nama);

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
                $this->_loaddbclass([ $this->model ]);

                $CurrencyRate = $this->CurrencyRate->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($CurrencyRate) {
                    $this->CurrencyRateID = $CurrencyRate[$this->inv['flip']['CurrencyRateID']];
                    $this->CurrencyCodeFrom = $CurrencyRate[$this->inv['flip']['CurrencyCodeFrom']];
                    $this->CurrencyCodeTo = $CurrencyRate[$this->inv['flip']['CurrencyCodeTo']];
                    $this->Value = $CurrencyRate[$this->inv['flip']['Value']];
                    $this->IsActive = $CurrencyRate[$this->inv['flip']['IsActive']];
                    $this->Status = $CurrencyRate[$this->inv['flip']['Status']];
                    $this->CreatedDate = $CurrencyRate[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $CurrencyRate[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $CurrencyRate[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $CurrencyRate[$this->inv['flip']['UpdatedBy']];

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
            $this->_loaddbclass([ $this->model ]);

            if(isset($request['edit'])) {
                $CurrencyRate = $this->CurrencyRate->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$CurrencyRate) {
                    $this->_redirect('404');
                }
            }

            $this->CurrencyCodeFrom = $request['CurrencyCodeFrom'];
            if(empty($this->CurrencyCodeFrom)) {
                $this->errorCurrencyCodeFrom = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.CurrencyRate.CurrencyCodeFrom')]
                );
            }

            $this->CurrencyCodeTo = $request['CurrencyCodeTo'];
            if(empty($this->CurrencyCodeTo)) {
                $this->errorCurrencyCodeTo= $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.CurrencyRate.CurrencyCodeTo')]
                );
            }

            $CurrencyRate = $this->CurrencyRate->where([[$this->inv['flip']['CurrencyCodeFrom'], '=', $this->CurrencyCodeFrom],[$this->inv['flip']['CurrencyCodeTo'], '=', $this->CurrencyCodeTo],['Status','=',0]])->first();

            if ($CurrencyRate) {
                if (isset($request['addnew']) && $CurrencyRate[$this->inv['flip']['CurrencyCodeFrom']] == $this->CurrencyCodeFrom && $CurrencyRate[$this->inv['flip']['CurrencyCodeTo']] == $this->CurrencyCodeTo) {
                    if (!$this->inv['messageerror']) {
                        $this->inv['messageerror'] = $this->_trans('validation.already',
                            ['value' => 'Currency Rate']
                        );
                    }
                } else {
                    if ($CurrencyRate[$this->objectkey] != $this->inv['getid']) {
                        if (!$this->inv['messageerror']) {
                            $this->inv['messageerror'] = $this->_trans('validation.already',
                                ['value' => 'Currency Rate']
                            );
                        }
                    }
                }
            }

            $this->Value = $request['Value'];
            if(empty($this->Value)) {
                $this->errorValue = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.CurrencyRate.Value')]
                );
            }

            //handling error
            if(!$this->inv['messageerror'] && !$this->errorCurrencyRateID && !$this->errorCurrencyCodeFrom && !$this->errorCurrencyCodeTo && !$this->errorValue && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {

                $array = array(
                    $this->inv['flip']['CurrencyRateID'] => $this->CurrencyRateID,
                    $this->inv['flip']['CurrencyCodeFrom'] => $this->CurrencyCodeFrom,
                    $this->inv['flip']['CurrencyCodeTo'] => $this->CurrencyCodeTo,
                    $this->inv['flip']['Value'] => $this->Value,   
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];

                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $CurrencyRate = $this->CurrencyRate->creates($array);

                      $nama = $CurrencyRate[$this->inv['flip']['CurrencyCodeFrom']].' to '.$CurrencyRate[$this->inv['flip']['CurrencyCodeTo']];
                
                    $this->_dblog('addnew', $this, $nama);
                    \Session::put('messagesuccess', "Saving $nama Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $CurrencyRate = $this->CurrencyRate->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $CurrencyRate->update($array);
                    
                    $this->_dblog('edit', $this, $nama);
                    \Session::put('messagesuccess', "Update $nama Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['CurrencyRateID'] = $this->CurrencyRateID; $this->inv['errorCurrencyRateID'] = $this->errorCurrencyRateID;
        $this->inv['CurrencyCodeFrom'] = $this->CurrencyCodeFrom; $this->inv['errorCurrencyCodeFrom'] = $this->errorCurrencyCodeFrom;
        $this->inv['CurrencyCodeTo'] = $this->CurrencyCodeTo; $this->inv['errorCurrencyCodeTo'] = $this->errorCurrencyCodeTo;
        $this->inv['Value'] = $this->Value; $this->inv['errorValue'] = $this->errorValue;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        
        $this->_loaddbclass(['Currency']);
        $this->arrCurrency = $this->Currency->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrCurrency'] = $this->arrCurrency;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([$this->model]);

            foreach($this->inv['delete'] as $val) {
                $CurrencyRate = $this->CurrencyRate->where([[$this->objectkey,'=',$val]])->first();
                if($CurrencyRate) {
                    $nama = $CurrencyRate[$this->inv['flip']['CurrencyCodeFrom']].' to '.$CurrencyRate[$this->inv['flip']['CurrencyCodeTo']];
                    
                    $array[$this->inv['flip']['Status']] = 1;
                    $CurrencyRate->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $nama);
                    $this->inv['messagesuccess'] .= "Delete $nama Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ $this->model ]);

        $result = $this->CurrencyRate->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
         for($i = 0; $i < count($result['data']); $i++) {
            $checkactive = '';
            if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                $checkactive = 'checked';
            $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['CurrencyRateID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$checkactive.' rel="Anda yakin ingin merubah status ?">';
        }
        $this->_setdatapaginate($result);
    }
    
    return $this->_showview($views);
}
}