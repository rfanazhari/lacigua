<?php

namespace App\Modules\dashboard\Http\Controllers\managefaq;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class subfaqdetailController extends Controller
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
        'ID' => 'FaqSubDetailID',
        'FaqSubID' => 'FaqSubID',
        'FaqSubName' => 'FaqSubName',
        'Title' => 'Title',
        'Description' => 'Description',
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
        'FaqSubDetailID' => ['Faq Sub Detail ID'],
        'FaqSubID' => ['Sub Faq Name'],
        'FaqSubName' => ['Sub Faq Name', true],
        'Title' => ['Title', true],
        'Description' => ['Description'],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'permalink' => ['permalink'],
    ];

    public $objectkey = '', $FaqSubDetailID = '', $errorFaqSubDetailID = '', $FaqSubID = '', $errorFaqSubID = '', $Title = '', $errorTitle = '', $Description = '', $errorDescription = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) exit;

        $request = \Request::instance()->request->all();
        if (isset($request['ajaxpost'])) {
            switch ($request['ajaxpost']) {
                case 'setactive':
                    $id = $request['value'];

                    $this->_loaddbclass(['FaqSubDetail']);

                    $FaqSubDetail = $this->FaqSubDetail->where([['ID', '=', $id]])->first();

                    if ($FaqSubDetail) {
                        $IsActive = 1;
                        if ($FaqSubDetail->IsActive == 1) {
                            $IsActive = 0;
                        }

                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $FaqSubDetail->update($array);

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
                $this->_loaddbclass(['FaqSubDetail']);
                $FaqSubDetail = $this->FaqSubDetail->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if ($FaqSubDetail) {
                    $this->FaqSubDetailID = $FaqSubDetail[$this->inv['flip']['FaqSubDetailID']];
                    $this->FaqSubID = $FaqSubDetail[$this->inv['flip']['FaqSubID']];
                    $this->Title = $FaqSubDetail[$this->inv['flip']['Title']];
                    $this->Description = $FaqSubDetail[$this->inv['flip']['Description']];
                    $this->IsActive = $FaqSubDetail[$this->inv['flip']['IsActive']];
                    $this->Status = $FaqSubDetail[$this->inv['flip']['Status']];
                    $this->CreatedDate = $FaqSubDetail[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $FaqSubDetail[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $FaqSubDetail[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $FaqSubDetail[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $FaqSubDetail[$this->inv['flip']['permalink']];
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
            $this->_loaddbclass(['FaqSubDetail']);

            if (isset($request['edit'])) {
                $FaqSubDetail = $this->FaqSubDetail->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if (!$FaqSubDetail) {
                    $this->_redirect('404');
                }
            }

            $this->FaqSubID = $request['FaqSubID'];
            if (empty($this->FaqSubID)) {
                $this->errorFaqSubID = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.managefaq.FaqSubDetail.FaqSubID')]
                );
            }

            $this->Title = $request['Title'];
            if(empty($this->Title)) {
                $this->errorTitle = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managefaq.FaqSubDetail.Title')]
                );
            }

            $FaqSubDetail = $this->FaqSubDetail->where([
                [$this->inv['flip']['Title'],'=',$this->Title],
                ['IsActive','=',1],
                ['Status','=',0],
            ])->first();

            if($FaqSubDetail) {
                if(isset($request['addnew']) && strtoupper($FaqSubDetail[$this->inv['flip']['Title']]) == strtoupper($this->Title)) {
                    if(!$this->errorTitle) {
                        $this->errorTitle = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.managefaq.FaqSubDetail.Title')]
                        );
                    }
                } else {
                    if ($FaqSubDetail[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorTitle) {
                            $this->errorTitle = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.managefaq.FaqSubDetail.Title')]
                            );
                        }
                    }
                }
            }

            $this->Description = $request['Description'];
            if(empty($this->Description)) {
                $this->errorDescription = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managefaq.FaqSubDetail.Description')]
                );
            }

            if (!$this->inv['messageerror'] && !$this->errorFaqSubDetailID && !$this->errorFaqSubID && !$this->errorTitle && !$this->errorDescription && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {

                $array = array(
                    $this->inv['flip']['FaqSubDetailID'] => $this->FaqSubDetailID,
                    $this->inv['flip']['FaqSubID'] => $this->FaqSubID,
                    $this->inv['flip']['Title'] => $this->Title,
                    $this->inv['flip']['Description'] => $this->Description,
                    $this->inv['flip']['permalink'] => $this->_permalink($this->Title),
                );

                $userdata = \Session::get('userdata');
                $userid   = $userdata['uuserid'];

                if (isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']]   = $userid;
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $FaqSubDetail = $this->FaqSubDetail->creates($array);

                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                    $FaqSubDetail = $this->FaqSubDetail->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                    $FaqSubDetail->update($array);

                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['FaqSubDetailID'] = $this->FaqSubDetailID; $this->inv['errorFaqSubDetailID'] = $this->errorFaqSubDetailID;
        $this->inv['FaqSubID'] = $this->FaqSubID; $this->inv['errorFaqSubID'] = $this->errorFaqSubID;
        $this->inv['Title'] = $this->Title; $this->inv['errorTitle'] = $this->errorTitle;
        $this->inv['Description'] = $this->Description; $this->inv['errorDescription'] = $this->errorDescription;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;

        $this->_loaddbclass(['FaqSub']);

        $this->arrfaqsub = $this->FaqSub->leftjoin([
            ['faq', 'faq.ID', '=', 'faq_sub.FaqID']
        ])->where([['faq.IsActive', '=', 1],['faq.Status', '=', 0],['faq_sub.IsActive', '=', 1],['faq_sub.Status', '=', 0]])
        ->selectraw('
            faq.Name as FaqName,
            faq_sub.*
        ')->orderBy('Name', 'ASC')->get()->toArray();
        $this->inv['arrfaqsub'] = $this->arrfaqsub;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) return $this->_redirect($url);

        if (isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass(['FaqSubDetail']);

            foreach ($this->inv['delete'] as $val) {
                $FaqSubDetail = $this->FaqSubDetail->where([[$this->objectkey, '=', $val]])->first();
                if ($FaqSubDetail) {
                    $this->Title = $FaqSubDetail[$this->inv['flip']['Title']];

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']]   = 1;
                    $FaqSubDetail->update($array);

                    $br = "";
                    if (end($this->inv['delete']) != $val) $br = "<br/>";

                    $this->_dblog('delete', $this, $this->Title);
                    $this->inv['messagesuccess'] .= "Delete $this->Title Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"])
    {
        $this->_loaddbclass(['FaqSubDetail']);

        $result = $this->FaqSubDetail->leftJoin([
            ['faq_sub', 'faq_sub.ID', '=', 'faq_sub_detail.FaqSubID'],
            ['faq', 'faq.ID', '=', 'faq_sub.FaqID'],
        ])->select([
            'faq_sub.Name as FaqSubName',
            'faq_sub_detail.*',
        ])->where([['faq_sub_detail.Status', '=', 0],['faq_sub_detail.IsActive', '=', 1],['faq_sub.Status', '=', 0],['faq_sub.IsActive', '=', 1],['faq.Status', '=', 0],['faq.IsActive', '=', 1]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        $this->inv['flip']['FaqSubName'] = 'faq_sub.Name';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['FaqSubName'] = 'FaqSubName';
        
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
