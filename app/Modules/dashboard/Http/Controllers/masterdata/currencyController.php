<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class currencyController extends Controller
{
    public $model = 'Currency';
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
        'ID' => 'CurrencyID',
        'Name' => 'Name',
        'Code' => 'Code',
        'Symbol' => 'Symbol',
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
        'CurrencyID' => ['Currency ID'],
        'Name' => ['Name', true],
        'Code' => ['Code', true],
        'Symbol' => ['Symbol', true],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['CreatedDate'],
        'CreatedBy' => ['CreatedBy'],
        'UpdatedDate' => ['UpdatedDate'],
        'UpdatedBy' => ['UpdatedBy'],
    ];
    
    var $objectkey = '', $CurrencyID = '', $errorCurrencyID = '', $Name = '', $errorName = '', $Code = '', $errorCode = '', $Symbol = '', $errorSymbol = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

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

                    $Currency = $this->Currency->where([['ID','=',$id]])->first();

                    if($Currency) {
                        $this->Name = $Currency[$this->inv['flip']['Name']];

                        $IsActive = 1;
                        if($Currency->IsActive == 1) $IsActive = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];
                        
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $Currency->update($array);

                        if($IsActive) $IsActive = 'Active';
                        else $IsActive = 'Non Active';

                        $this->_dblog('edit', $this, 'Set '.$IsActive.' '.$this->Name);

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

                $Currency = $this->Currency->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Currency) {
                    $this->CurrencyID = $Currency[$this->inv['flip']['CurrencyID']];
                    $this->Name = $Currency[$this->inv['flip']['Name']];
                    $this->Code = $Currency[$this->inv['flip']['Code']];
                    $this->Symbol = $Currency[$this->inv['flip']['Symbol']];
                    $this->IsActive = $Currency[$this->inv['flip']['IsActive']];
                    $this->Status = $Currency[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Currency[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Currency[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Currency[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Currency[$this->inv['flip']['UpdatedBy']];

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
                $Currency = $this->Currency->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Currency) {
                    $this->_redirect('404');
                }
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Currency.Name')]
                );
            }

            $Currency = $this->Currency->where([[$this->inv['flip']['Name'], '=', $this->Name],['Status','=',0]])->first();

            if ($Currency) {
                if (isset($request['addnew']) && strtoupper($Currency[$this->inv['flip']['Name']]) == strtoupper($this->Name)) {
                    if (!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already',
                            ['value' => $this->_trans('dashboard.masterdata.Currency.Name')]
                        );
                    }
                } else {
                    if ($Currency[$this->objectkey] != $this->inv['getid']) {
                        if (!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already',
                                ['value' => $this->_trans('dashboard.masterdata.Currency.Name')]
                            );
                        }
                    }
                }
            }

            $this->Code = $request['Code'];
            if(empty($this->Code)) {
                $this->errorCode= $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Currency.Code')]
                );
            }

            $this->Symbol = $request['Symbol'];
            if(empty($this->Symbol)) {
                $this->errorSymbol = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Currency.Symbol')]
                );
            }

            //handling error
            if(!$this->inv['messageerror'] && !$this->errorCurrencyID && !$this->errorName && !$this->errorCode && !$this->errorSymbol && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {

                $array = array(
                    $this->inv['flip']['CurrencyID'] => $this->CurrencyID,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['Code'] => $this->Code,
                    $this->inv['flip']['Symbol'] => $this->Symbol,   
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    
                    $Currency = $this->Currency->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Currency = $this->Currency->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Currency->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['CurrencyID'] = $this->CurrencyID; $this->inv['errorCurrencyID'] = $this->errorCurrencyID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['Code'] = $this->Code; $this->inv['errorCode'] = $this->errorCode;
        $this->inv['Symbol'] = $this->Symbol; $this->inv['errorSymbol'] = $this->errorSymbol;
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
            $this->_loaddbclass([$this->model]);

            foreach($this->inv['delete'] as $val) {
                $Currency = $this->Currency->where([[$this->objectkey,'=',$val]])->first();
                if($Currency) {
                    $this->Name = $Currency[$this->inv['flip']['Name']];
                    
                    $array[$this->inv['flip']['Status']] = 1;
                    $Currency->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->Name);
                    $this->inv['messagesuccess'] .= "Delete $this->Name Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ $this->model ]);

        $result = $this->Currency->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
           for($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                    $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['CurrencyID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';
            }
        $this->_setdatapaginate($result);
    }
    
    return $this->_showview($views);
}
}