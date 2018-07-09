<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class exchangepointController extends Controller
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
        'ID' => 'ExchangePointID',
        'Point' => 'Point',
        'StoreCredit' => 'StoreCredit',
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
        'ExchangePointID' => ['Exchange Point ID'],
        'Point' => ['Point', true],
        'StoreCredit' => ['Store Kredit', true],
        'Status' => ['Status'],
        'IsActive' => ['Is Active', true],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    var $objectkey = '', $ExchangePointID = '', $errorExchangePointID = '', $Point = '', $errorPoint = '', $StoreCredit = '', $errorStoreCredit = '', $Status = '', $errorStatus = '', $IsActive = '', $errorIsActive = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    $id = $request['value'];

                    $this->_loaddbclass([ 'ExchangePoint' ]);

                    $ExchangePoint = $this->ExchangePoint->where([['ID','=',$id]])->first();

                    if($ExchangePoint) {
                        $this->Point = $ExchangePoint[$this->inv['flip']['Point']];
                        $this->StoreCredit = $ExchangePoint[$this->inv['flip']['StoreCredit']];

                        $IsActive = 1;
                        if($ExchangePoint->IsActive == 1) $IsActive = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];
                        
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $ExchangePoint->update($array);

                        if($IsActive) $IsActive = 'Active';
                        else $IsActive = 'Non Active';

                        $this->_dblog('edit', $this, 'Set '.$IsActive.' '.$this->Point.' to '.$this->StoreCredit);

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
                $this->_loaddbclass([ 'ExchangePoint' ]);

                $ExchangePoint = $this->ExchangePoint->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($ExchangePoint) {
                    $this->ExchangePointID = $ExchangePoint[$this->inv['flip']['ExchangePointID']];
                    $this->Point = $ExchangePoint[$this->inv['flip']['Point']];
                    $this->StoreCredit = $ExchangePoint[$this->inv['flip']['StoreCredit']];
                    $this->Status = $ExchangePoint[$this->inv['flip']['Status']];
                    $this->IsActive = $ExchangePoint[$this->inv['flip']['IsActive']];
                    $this->CreatedDate = $ExchangePoint[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $ExchangePoint[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $ExchangePoint[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $ExchangePoint[$this->inv['flip']['UpdatedBy']];
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
            $this->_loaddbclass([ 'ExchangePoint' ]);

            if(isset($request['edit'])) {
                $ExchangePoint = $this->ExchangePoint->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$ExchangePoint) {
                    $this->_redirect('404');
                }
            }

            $this->Point = $request['Point'];
            if(empty($this->Point)) {
                $this->errorPoint = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.ExchangePoint.Point')]
                );
            }

            $this->StoreCredit = $request['StoreCredit'];
            if(empty($this->StoreCredit)) {
                $this->errorStoreCredit = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.ExchangePoint.StoreCredit')]
                );
            }

            $ExchangePoint = $this->ExchangePoint->where([[$this->inv['flip']['Point'], '=', $this->Point],[$this->inv['flip']['StoreCredit'], '=', $this->StoreCredit],['Status','=',0]])->first();

            if ($ExchangePoint) {
                if (isset($request['addnew']) && $ExchangePoint[$this->inv['flip']['Point']] == $this->Point && $ExchangePoint[$this->inv['flip']['StoreCredit']] == $this->StoreCredit) {
                    if (!$this->errorStoreCredit) {
                        $this->errorStoreCredit = $this->_trans('validation.already',
                            ['value' => $this->_trans('dashboard.masterdata.ExchangePoint.StoreCredit')]
                        );
                    }
                } else {
                    if ($ExchangePoint[$this->objectkey] != $this->inv['getid']) {
                        if (!$this->errorStoreCredit) {
                            $this->errorStoreCredit = $this->_trans('validation.already',
                                ['value' => $this->_trans('dashboard.masterdata.ExchangePoint.StoreCredit')]
                            );
                        }
                    }
                }
            }

            if(!$this->inv['messageerror'] && !$this->errorExchangePointID && !$this->errorPoint && !$this->errorStoreCredit && !$this->errorStatus && !$this->errorIsActive && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {

                $array = array(
                    $this->inv['flip']['ExchangePointID'] => $this->ExchangePointID,
                    $this->inv['flip']['Point'] => $this->Point,
                    $this->inv['flip']['StoreCredit'] => $this->StoreCredit,
                );

                $userdata = \Session::get('userdata');
                $userid = $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    
                    $ExchangePoint = $this->ExchangePoint->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Point.' to '.$this->StoreCredit);
                    \Session::put('messagesuccess', "Saving $this->Point to $this->StoreCredit Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $ExchangePoint = $this->ExchangePoint->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $ExchangePoint->update($array);
                    
                    $this->_dblog('edit', $this, $this->Point.' to '.$this->StoreCredit);
                    \Session::put('messagesuccess', "Update $this->Point to $this->StoreCredit Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['ExchangePointID'] = $this->ExchangePointID; $this->inv['errorExchangePointID'] = $this->errorExchangePointID;
        $this->inv['Point'] = $this->Point; $this->inv['errorPoint'] = $this->errorPoint;
        $this->inv['StoreCredit'] = $this->StoreCredit; $this->inv['errorStoreCredit'] = $this->errorStoreCredit;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
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
            $this->_loaddbclass(['ExchangePoint']);

            foreach($this->inv['delete'] as $val) {
                $ExchangePoint = $this->ExchangePoint->where([[$this->objectkey,'=',$val]])->first();
                if($ExchangePoint) {
                    $this->Point = $ExchangePoint[$this->inv['flip']['Point']];
                    $this->StoreCredit = $ExchangePoint[$this->inv['flip']['StoreCredit']];
                    
                    $array[$this->inv['flip']['Status']] = 1;
                    $ExchangePoint->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->Point.' to '.$this->StoreCredit);
                    $this->inv['messagesuccess'] .= "Delete $this->Point to $this->StoreCredit Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'ExchangePoint' ]);

        $result = $this->ExchangePoint->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';

                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['ExchangePointID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';
            }
            $this->_setdatapaginate($result);
        }
        
        return $this->_showview($views);
    }
}