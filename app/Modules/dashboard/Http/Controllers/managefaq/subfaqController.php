<?php

namespace App\Modules\dashboard\Http\Controllers\managefaq;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class subfaqController extends Controller
{
    // Set header active
    public $header = [
        'menus'   => true, // True is show menu and false is not show.
        'check'   => true, // Active all header function. If all true and this check false then header not show.
        'search'  => true,
        'addnew'  => true,
        'refresh' => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'FaqSubID',
        'FaqID' => 'FaqID',
        'FaqName' => 'FaqName',
        'Name' => 'Name',
        'IsActive' => 'IsActive',
        'Status' => 'Status',
        'CreatedDate' => 'CreatedDate',
        'CreatedBy' => 'CreatedBy',
        'UpdatedDate' => 'UpdatedDate',
        'UpdatedBy' => 'UpdatedBy',
        'permalink' => 'permalink',
    ];

    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'FaqSubID' => ['Faq Sub ID'],
        'FaqID' => ['Faq Name'],
        'FaqName' => ['Faq Name', true],
        'Name' => ['Name', true],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'permalink' => ['permalink'],
    ];

    public $objectkey = '', $FaqSubID = '', $errorFaqSubID = '', $FaqID = '', $errorFaqID = '', $Name = '', $errorName = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) exit;

        $request = \Request::instance()->request->all();
        if (isset($request['ajaxpost'])) {
            switch ($request['ajaxpost']) {
                case 'setactive':
                    $id = $request['value'];

                    $this->_loaddbclass(['FaqSub']);

                    $FaqSub = $this->FaqSub->where([['ID', '=', $id]])->first();

                    if ($FaqSub) {
                        $IsActive = 1;
                        if ($FaqSub->IsActive == 1) {
                            $IsActive = 0;
                        }

                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $FaqSub->update($array);

                        die('OK');
                    } else {
                        die('Error');
                    }

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

    public function addnew()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) return $this->_redirect($url);

        return $this->addnewedit();
    }

    public function edit()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) return $this->_redirect($url);

        return $this->getdata();
    }

    private function getdata()
    {
        if (isset($this->inv['getid'])) {
            if (!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass(['FaqSub']);
                $FaqSub = $this->FaqSub->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if ($FaqSub) {
                    $this->FaqSubID = $FaqSub[$this->inv['flip']['FaqSubID']];
                    $this->FaqID = $FaqSub[$this->inv['flip']['FaqID']];
                    $this->Name = $FaqSub[$this->inv['flip']['Name']];
                    $this->IsActive = $FaqSub[$this->inv['flip']['IsActive']];
                    $this->Status = $FaqSub[$this->inv['flip']['Status']];
                    $this->CreatedDate = $FaqSub[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $FaqSub[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $FaqSub[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $FaqSub[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $FaqSub[$this->inv['flip']['permalink']];
                } else {
                    $this->inv['messageerror'] = $this->_trans('validation.norecord');
                }
            } else {
                $this->inv['messageerror'] = $this->_trans('validation.norecord');
            }
        }

        return $this->addnewedit();
    }

    private function addnewedit()
    {
        $request     = \Request::instance()->request->all();
        $requestfile = \Request::file();

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass(['FaqSub']);

            if (isset($request['edit'])) {
                $FaqSub = $this->FaqSub->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if (!$FaqSub) {
                    $this->_redirect('404');
                }
            }

            $this->FaqID = $request['FaqID'];
            if (empty($this->FaqID)) {
                $this->errorFaqID = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.managefaq.FaqSub.FaqID')]
                );
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managefaq.FaqSub.Name')]
                );
            }

            $FaqSub = $this->FaqSub->where([
                [$this->inv['flip']['Name'],'=',$this->Name],
                ['IsActive','=',1],
                ['Status','=',0],
            ])->first();

            if($FaqSub) {
                if(isset($request['addnew']) && strtoupper($FaqSub[$this->inv['flip']['Name']]) == strtoupper($this->Name)) {
                    if(!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.managefaq.FaqSub.Name')]
                        );
                    }
                } else {
                    if ($FaqSub[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.managefaq.FaqSub.Name')]
                            );
                        }
                    }
                }
            }

            if (!$this->inv['messageerror'] && !$this->errorFaqSubID && !$this->errorFaqID && !$this->errorName && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {

                $array = array(
                    $this->inv['flip']['FaqSubID'] => $this->FaqSubID,
                    $this->inv['flip']['FaqID'] => $this->FaqID,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['permalink'] => $this->_permalink($this->Name),
                );

                $userdata = \Session::get('userdata');
                $userid   = $userdata['uuserid'];

                if (isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']]   = $userid;
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $FaqSub = $this->FaqSub->creates($array);

                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                    $FaqSub = $this->FaqSub->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                    $FaqSub->update($array);

                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['FaqSubID'] = $this->FaqSubID; $this->inv['errorFaqSubID'] = $this->errorFaqSubID;
        $this->inv['FaqID'] = $this->FaqID; $this->inv['errorFaqID'] = $this->errorFaqID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;

        $this->_loaddbclass(['Faq']);

        $this->arrfaq = $this->Faq->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Name', 'ASC')->get()->toArray();
        $this->inv['arrfaq'] = $this->arrfaq;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) return $this->_redirect($url);

        if (isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass(['FaqSub']);

            foreach ($this->inv['delete'] as $val) {
                $FaqSub = $this->FaqSub->where([[$this->objectkey, '=', $val]])->first();
                if ($FaqSub) {
                    $this->Name = $FaqSub[$this->inv['flip']['Name']];

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']]   = 1;
                    $FaqSub->update($array);

                    $br = "";
                    if (end($this->inv['delete']) != $val) $br = "<br/>";

                    $this->_dblog('delete', $this, $this->Name);
                    $this->inv['messagesuccess'] .= "Delete $this->Name Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"])
    {
        $this->_loaddbclass(['FaqSub']);

        $result = $this->FaqSub->leftJoin([
            ['faq', 'faq.ID', '=', 'faq_sub.FaqID'],
        ])->select([
            'faq.Name as FaqName',
            'faq_sub.*',
        ])->where([['faq_sub.Status', '=', 0],['faq_sub.IsActive', '=', 1],['faq.Status', '=', 0],['faq.IsActive', '=', 1]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        $this->inv['flip']['FaqName'] = 'faq.Name';
        $this->inv['flip']['Name'] = 'faq_sub.Name';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['FaqName'] = 'FaqName';
        $this->inv['flip']['Name'] = 'Name';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        } else {
            for ($i = 0; $i < count($result['data']); $i++) {
                $checkactive = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $checkactive = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['FaqSubID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$checkactive.' rel="Anda yakin ingin merubah status ?">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}
