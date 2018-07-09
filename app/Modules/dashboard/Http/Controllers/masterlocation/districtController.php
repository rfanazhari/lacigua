<?php

namespace App\Modules\dashboard\Http\Controllers\masterlocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class districtController extends Controller
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
    // Set idfunction => UNIQUEID for edit, detail, delete and etc
    public $alias = [
        'ID' => 'DistrictID',
        'CityID' => 'CityID',
        'CityName' => 'CityName',
        'Name' => 'Name',
        'JNECode' => 'JNECode',
        'IsActive' => 'IsActive',
        'Status' => 'Status',
        'CreatedDate' => 'CreatedDate',
        'CreatedBy' => 'CreatedBy',
        'UpdatedDate' => 'UpdatedDate',
        'UpdatedB' => 'UpdatedBy',
        'idfunction' => 'ID',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage' => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'DistrictID' => ['District ID'],
        'Name' => ['Name', true],
        'CityID' => ['City'],
        'CityName' => ['City', true],
        'JNECode' => ['JNE Code', true],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    var $objectkey = '', $DistrictID = '', $errorDistrictID = '', $CityID = '', $errorCityID = '', $Name = '', $errorName = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    $id = $request['value'];

                    $this->_loaddbclass([ 'District' ]);

                    $District = $this->District->where([['ID','=',$id]])->first();

                    if($District) {
                        $IsActive = 1;
                        if($District->IsActive == 1) $IsActive = 0;
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $District->update($array);

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
                $this->_loaddbclass([ 'District' ]);

                $District = $this->District->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($District) {
                    $this->DistrictID = $District[$this->inv['flip']['DistrictID']];
                    $this->CityID = $District[$this->inv['flip']['CityID']];
                    $this->Name = $District[$this->inv['flip']['Name']];
                    $this->IsActive = $District[$this->inv['flip']['IsActive']];
                    $this->Status = $District[$this->inv['flip']['Status']];
                    $this->CreatedDate = $District[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $District[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $District[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $District[$this->inv['flip']['UpdatedBy']];
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

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([ 'City' ]);

            if(isset($request['edit'])) {
                $City = $this->City->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$City) {
                    $this->_redirect('404');
                }
            }

            $this->ProvinceID = $request['ProvinceID'];
            if(empty($this->ProvinceID)) {
                $this->errorProvinceID = $this->_trans('validation.mandatoryselect', 
                    ['value' => $this->_trans('dashboard.masterdata.City.ProvinceID')]
                );
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.City.Name')]
                );
            }

            $CekCity = $this->City->where([
                [$this->inv['flip']['Name'],'=',$this->Name],
                [$this->inv['flip']['ProvinceID'],'=',$this->ProvinceID],
            ])->first();

            if($CekCity) {
                if(isset($request['addnew']) && strtoupper($CekCity[$this->inv['flip']['Name']]) == strtoupper($this->Name)) {
                    if(!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.Province.Name')]
                        );
                    }
                } else {
                    if ($CekCity[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.Province.Name')]
                            );
                        }
                    }
                }
            }

            if(!$this->inv['messageerror'] && !$this->errorDistrictID && !$this->errorCityID && !$this->errorName && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {
                $array  = array(
                    $this->inv['flip']['DistrictID'] => $this->DistrictID,
                    $this->inv['flip']['CityID'] => $this->CityID,
                    $this->inv['flip']['Name'] => $this->Name,
                );
                
                $userdata   = \Session::get('userdata');
                $uuserid    = $userdata['uuserid'];

                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime('now');
                    $array[$this->inv['flip']['CreatedBy']] = $uuserid;
                    $District = $this->District->creates($array);

                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                    $array[$this->inv['flip']['UpdatedBy']] = $uuserid;
                    $District = $this->District->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $District->update($array);

                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }
        
        $this->_loaddbclass([ 'City' ]);
        $arrcity = $this->City->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrcity'] = $arrcity;

        $this->inv['DistrictID'] = $this->DistrictID; $this->inv['errorDistrictID'] = $this->errorDistrictID;
        $this->inv['CityID'] = $this->CityID; $this->inv['errorCityID'] = $this->errorCityID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
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
            $this->_loaddbclass([ 'District' ]);

            foreach($this->inv['delete'] as $val) {
                $District = $this->District->where([[$this->objectkey,'=',$val]])->first();
                if($District) {
                    $this->Name = $District[$this->inv['flip']['Name']];

                    $array[$this->inv['flip']['Status']] = 1;
                    $District->update($array);

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
        $this->_loaddbclass([ 'District' ]);

        $result = $this->District->leftjoin([
            ['city','city.ID','=','district.'.$this->inv['flip']['CityID']]
        ])->select([
            'city.Name as CityName',
            'district.*'
        ])->where([['district.Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        $this->inv['flip']['Name'] = 'district.Name';
        $this->inv['flip']['CityName'] = 'city.Name';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['Name'] = 'Name';
        $this->inv['flip']['CityName'] = 'CityName';

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['DistrictID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}