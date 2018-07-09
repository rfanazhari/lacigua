<?php

namespace App\Modules\dashboard\Http\Controllers\managecareers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class careerController extends Controller
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
        'ID' => 'CareerID',
        'CareerDivisionID' => 'CareerDivisionID',
        'CareerDivisionName' => 'CareerDivisionName',
        'Position' => 'Position',
        'SimpleRequirement' => 'SimpleRequirement',
        'Requirement' => 'Requirement',
        'ClosedDate' => 'ClosedDate',
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
        'CareerID' => ['CareerID'],
        'CareerDivisionID' => ['Division Name'],
        'CareerDivisionName' => ['Division Name', true],
        'Position' => ['Position', true],
        'SimpleRequirement' => ['Simple Requirement', true],
        'Requirement' => ['Requirement'],
        'ClosedDate' => ['Closed Date', true],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['CreatedBy'],
        'UpdatedDate' => ['UpdatedDate'],
        'UpdatedBy' => ['UpdatedBy'],
        'permalink' => ['permalink'],
    ];

    var $objectkey = '', $CareerID = '', $errorCareerID = '', $CareerDivisionID = '', $errorCareerDivisionID = '', $Position = '', $errorPosition = '', $SimpleRequirement = '', $errorSimpleRequirement = '', $Requirement = '', $errorRequirement = '', $ClosedDate = '', $errorClosedDate = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';    

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    $id = $request['value'];

                    $this->_loaddbclass([ 'Career' ]);

                    $Career = $this->Career->where([['ID','=',$id]])->first();

                    if($Career) {
                        $this->Position = $Career[$this->inv['flip']['Position']];

                        $IsActive = 1;
                        if($Career->IsActive == 1) $IsActive = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];
                        
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $Career->update($array);

                        if($IsActive) $IsActive = 'Active';
                        else $IsActive = 'Non Active';

                        $this->_dblog('edit', $this, 'Set '.$IsActive.' '.$this->Position);

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
                $this->_loaddbclass([ 'Career' ]);

                $Career = $this->Career->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Career) {
                    $this->CareerID = $Career[$this->inv['flip']['CareerID']];
                    $this->CareerDivisionID = $Career[$this->inv['flip']['CareerDivisionID']];
                    $this->Position = $Career[$this->inv['flip']['Position']];
                    $this->SimpleRequirement = $Career[$this->inv['flip']['SimpleRequirement']];
                    $this->Requirement = $Career[$this->inv['flip']['Requirement']];
                    $this->ClosedDate = $this->_dateforhtml($Career[$this->inv['flip']['ClosedDate']]);
                    $this->IsActive = $Career[$this->inv['flip']['IsActive']];
                    $this->Status = $Career[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Career[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Career[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Career[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Career[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $Career[$this->inv['flip']['permalink']];
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
            $this->_loaddbclass([ 'Career' ]);

            if(isset($request['edit'])) {
                $Career = $this->Career->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Career) {
                    $this->_redirect('404');
                }
            }

            $this->CareerDivisionID = $request['CareerDivisionID'];
            if(empty($this->CareerDivisionID)) {
                $this->errorCareerDivisionID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managecareers.Career.CareerDivisionID')]
                );
            }

            $this->Position = $request['Position'];
            if(empty($this->Position)) {
                $this->errorPosition = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managecareers.Career.Position')]
                );
            }

            $Career = $this->Career->where([[$this->inv['flip']['CareerDivisionID'],'=',$this->CareerDivisionID],[$this->inv['flip']['Position'],'=',$this->Position],['Status','=',0]])->first();
            if($Career) {
                if(isset($request['addnew']) && ($Career[$this->inv['flip']['CareerDivisionID']] == $this->CareerDivisionID && $Career[$this->inv['flip']['Position']] == $this->Position)) {
                    if(!$this->errorPosition) {
                        $this->errorPosition = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.managecareers.Career.Position')]
                        );
                    }
                } else {
                    if ($Career[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorPosition) {
                            $this->errorPosition = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.managecareers.Career.Position')]
                            );
                        }
                    }
                }
            }

            $this->SimpleRequirement = $request['SimpleRequirement'];
            if(empty($this->SimpleRequirement)) {
                $this->errorSimpleRequirement = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managecareers.Career.SimpleRequirement')]
                );
            }

            $this->Requirement = $request['Requirement'];
            if(empty($this->Requirement)) {
                $this->errorRequirement = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managecareers.Career.Requirement')]
                );
            }

            $this->ClosedDate = $request['ClosedDate'];
            if(empty($this->ClosedDate)) {
                $this->errorClosedDate = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managecareers.Career.ClosedDate')]
                );
            }

            //handling error
            if(!$this->inv['messageerror'] && !$this->errorCareerID && !$this->errorCareerDivisionID && !$this->errorPosition && !$this->errorSimpleRequirement && !$this->errorRequirement && !$this->errorClosedDate && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {
                $array = array(
                    $this->inv['flip']['CareerID'] => $this->CareerID,
                    $this->inv['flip']['CareerDivisionID'] => $this->CareerDivisionID,
                    $this->inv['flip']['Position'] => $this->Position,
                    $this->inv['flip']['SimpleRequirement'] => $this->SimpleRequirement,
                    $this->inv['flip']['Requirement'] => $this->Requirement,
                    $this->inv['flip']['ClosedDate'] => $this->_dateformysql($this->ClosedDate),
                    $this->inv['flip']['permalink'] => $this->_permalink($this->Position),
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $Career = $this->Career->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Position);
                    \Session::put('messagesuccess', "Saving $this->Position Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Career = $this->Career->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Career->update($array);
                    
                    $this->_dblog('edit', $this, $this->Position);
                    \Session::put('messagesuccess', "Update $this->Position Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->_loaddbclass(['CareerDivision']);

        $ArrCareerDivision = $this->CareerDivision->where([['IsActive', '=', 1],['Status', '=', 0]])->get();
        $this->inv['ArrCareerDivision'] = $ArrCareerDivision;

        $this->inv['CareerID'] = $this->CareerID; $this->inv['errorCareerID'] = $this->errorCareerID;
        $this->inv['CareerDivisionID'] = $this->CareerDivisionID; $this->inv['errorCareerDivisionID'] = $this->errorCareerDivisionID;
        $this->inv['Position'] = $this->Position; $this->inv['errorPosition'] = $this->errorPosition;
        $this->inv['SimpleRequirement'] = $this->SimpleRequirement; $this->inv['errorSimpleRequirement'] = $this->errorSimpleRequirement;
        $this->inv['Requirement'] = $this->Requirement; $this->inv['errorRequirement'] = $this->errorRequirement;
        if(!$this->ClosedDate) $this->ClosedDate = date('d F Y');
        $this->inv['ClosedDate'] = $this->ClosedDate; $this->inv['errorClosedDate'] = $this->errorClosedDate;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([ 'Career' ]);

            foreach($this->inv['delete'] as $val) {
                $Career = $this->Career->where([[$this->objectkey,'=',$val]])->first();
                if($Career) {
                    $this->Position = $Career[$this->inv['flip']['Position']];
                    
                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['permalink']] = '';
                    $Career->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->Position);
                    $this->inv['messagesuccess'] .= "Delete $this->Position Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'Career' ]);

        $result = $this->Career->leftjoin([
            ['career_division as cd', 'cd.ID', '=', 'career.CareerDivisionID']
        ])->selectraw('
            cd.Name as CareerDivisionName,
            career.*
        ')->where([['career.Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $result['data'][$i][$this->inv['flip']['ClosedDate']] = $this->_dateforhtml($result['data'][$i][$this->inv['flip']['ClosedDate']]);
                $checkactive = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $checkactive = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['CareerID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$checkactive.' rel="Anda yakin ingin merubah status ?">';
            }
            $this->_setdatapaginate($result);
        }
    
        return $this->_showview($views);
    }
}