<?php

namespace App\Modules\dashboard\Http\Controllers\masterlocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class cityController extends Controller
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
        'ID' => 'CityID',
        'Alias' => 'Alias',
        'Name' => 'Name',
        'Code' => 'Code',
        'ProvinceID' => 'ProvinceID',
        'ProvinceName' => 'ProvinceName',
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
        'titlepage' => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'CityID' => ['City ID'],
        'Alias' => ['Alias', true],
        'Name' => ['Name', true],
        'Code' => ['Code', true],
        'ProvinceID' => ['Province'],
        'ProvinceName' => ['Province', true],
        'IsActive' => ['IsActive', true],
        'Status' => ['Status'],   
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    var $objectkey = '', $CityID = '', $errorCityID = '', $Alias = '', $errorAlias = '', $Name = '', $errorName = '', $Code = '', $errorCode = '', $ProvinceID = '', $errorProvinceID = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    $id = $request['value'];

                    $this->_loaddbclass([ 'City' ]);

                    $City = $this->City->where([['ID','=',$id]])->first();

                    if($City) {
                        $IsActive = 1;
                        if($City->IsActive == 1) $IsActive = 0;
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $City->update($array);

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
                $this->_loaddbclass([ 'City' ]);

                $City = $this->City->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($City) {
                    $this->CityID = $City[$this->inv['flip']['CityID']];
                    $this->Alias = $City[$this->inv['flip']['Alias']];
                    $this->Name = $City[$this->inv['flip']['Name']];
                    $this->Code = $City[$this->inv['flip']['Code']];
                    $this->ProvinceID = $City[$this->inv['flip']['ProvinceID']];
                    $this->IsActive = $City[$this->inv['flip']['IsActive']];
                    $this->Status = $City[$this->inv['flip']['Status']];
                    $this->CreatedDate = $City[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $City[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $City[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $City[$this->inv['flip']['UpdatedBy']];
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

            $this->Alias = $request['Alias'];
            if(empty($this->Alias)) {
                $this->errorAlias = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.City.Alias')]
                );
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.City.Name')]
                );
            }

            $CekCity = $this->City->where([
                [$this->inv['flip']['Alias'],'=',$this->Alias],
                [$this->inv['flip']['Name'],'=',$this->Name],
                [$this->inv['flip']['ProvinceID'],'=',$this->ProvinceID],
            ])->first();

            if($CekCity) {
                if(isset($request['addnew']) && strtoupper($CekCity[$this->inv['flip']['Alias']]) == strtoupper($this->Alias) && strtoupper($CekCity[$this->inv['flip']['Name']]) == strtoupper($this->Name)) {
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

            $this->Code = $request['Code'];
            if(empty($this->Code)) {
                $this->errorCode = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.City.Code')]
                );
            }

            if(!$this->inv['messageerror'] && !$this->errorCityID && !$this->errorAlias && !$this->errorName && !$this->errorCode && !$this->errorProvinceID && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy ) {
                $array  = array(
                    $this->inv['flip']['CityID'] => $this->CityID,
                    $this->inv['flip']['Alias'] => $this->Alias,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['Code'] => $this->Code,
                    $this->inv['flip']['ProvinceID'] => $this->ProvinceID,
                );
                
                $userdata   = \Session::get('userdata');
                $uuserid    = $userdata['uuserid'];

                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime('now');
                    $array[$this->inv['flip']['CreatedBy']] = $uuserid;
                    $City = $this->City->creates($array);

                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                    $array[$this->inv['flip']['UpdatedBy']] = $uuserid;
                    $City = $this->City->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $City->update($array);

                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }
        
        $this->_loaddbclass([ 'Province' ]);
        $arrprovince = $this->Province->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrprovince'] = $arrprovince;

        $this->inv['CityID'] = $this->CityID; $this->inv['errorCityID'] = $this->errorCityID;
        $this->inv['Alias'] = $this->Alias; $this->inv['errorAlias'] = $this->errorAlias;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['Code'] = $this->Code; $this->inv['errorCode'] = $this->errorCode;
        $this->inv['CountryID'] = $this->CountryID; $this->inv['errorCountryID'] = $this->errorCountryID;
        $this->inv['ProvinceID'] = $this->ProvinceID; $this->inv['errorProvinceID'] = $this->errorProvinceID;
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
            $this->_loaddbclass([ 'City' ]);

            foreach($this->inv['delete'] as $val) {
                $City = $this->City->where([[$this->objectkey,'=',$val]])->first();
                if($City) {
                    $this->Name = $City[$this->inv['flip']['Name']];

                    $array[$this->inv['flip']['Status']] = 1;
                    $City->update($array);

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
        $this->_loaddbclass([ 'City' ]);

        $result = $this->City->leftjoin([
            ['province','province.ID','=','city.'.$this->inv['flip']['ProvinceID']]
        ])->select([
            'province.Name as ProvinceName',
            'city.*'
        ])->where([['city.Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        $this->inv['flip']['Name'] = 'city.Name';
        $this->inv['flip']['ProvinceName'] = 'province.Name';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['Name'] = 'Name';
        $this->inv['flip']['ProvinceName'] = 'ProvinceName';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['CityID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}