<?php

namespace App\Modules\dashboard\Http\Controllers\masterlocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class provinceController extends Controller
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
        'ID' => 'ProvinceID',
        'Name' => 'Name',
        'CountryID' => 'CountryID',
        'CountryName' => 'CountryName',
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
        'ProvinceID' => ['Province ID'],
        'Name' => ['Province Name', true],
        'CountryID' => ['Country'],
        'CountryName' => ['Country', true],
        'IsActive' => ['IsActive', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Create Date'],
        'CreatedBy' => ['Create By'],
        'UpdatedDate' => ['Update Date'],
        'UpdatedBy' => ['Update By'],
    ];

    var $objectkey = '', $ProvinceID = '', $errorProvinceID = '', $Name = '', $errorName = '', $CountryID = '', $errorCountryID = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy= '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    $id = $request['value'];

                    $this->_loaddbclass([ 'Province' ]);

                    $Province = $this->Province->where([['ID','=',$id]])->first();

                    if($Province) {
                        $this->Name = $Province[$this->inv['flip']['Name']];

                        $IsActive = 1;
                        if($Province->IsActive == 1) $IsActive = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];
                        
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $Province->update($array);

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
                $this->_loaddbclass([ 'Province' ]);

                $Province = $this->Province->where([
                    [$this->objectkey,'=',$this->inv['getid']],
                ])->first();
                if($Province) {
                    $this->ProvinceID = $Province[$this->inv['flip']['ProvinceID']];
                    $this->Name = $Province[$this->inv['flip']['Name']];
                    $this->CountryID = $Province[$this->inv['flip']['CountryID']];
                    $this->IsActive = $Province[$this->inv['flip']['IsActive']];
                    $this->Status = $Province[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Province[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Province[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Province[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Province[$this->inv['flip']['UpdatedBy']];
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
            $this->_loaddbclass([ 'Province' ]);

            if(isset($request['edit'])) {
                $Province = $this->Province->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Province) {
                    $this->_redirect('404');
                }
            }

            $this->CountryID = $request['CountryID'];
            if(empty($this->CountryID)) {
                $this->errorCountryID = $this->_trans('validation.mandatoryselect', 
                    ['value' => $this->_trans('dashboard.masterdata.Province.CountryID')]
                );
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Province.Name')]
                );
            }

            $CekProvince = $this->Province->where([
                [$this->inv['flip']['Name'],'=',$this->Name],
                [$this->inv['flip']['CountryID'],'=',$this->CountryID],
            ])->first();

            if($CekProvince) {
                if(isset($request['addnew']) && strtoupper($CekProvince[$this->inv['flip']['Name']]) == strtoupper($this->Name)) {
                    if(!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.Province.Name')]
                        );
                    }
                } else {
                    if ($CekProvince[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.Province.Name')]
                            );
                        }
                    }
                }
            }


            if(!$this->inv['messageerror'] && !$this->errorProvinceID && !$this->errorName && !$this->errorCountryID && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy ) {
                $array  = array(
                    $this->inv['flip']['ProvinceID'] => $this->ProvinceID,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['CountryID'] => $this->CountryID,
                );

                $userdata   = \Session::get('userdata');
                $uuserid    = $userdata['uuserid'];

                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime('now');
                    $array[$this->inv['flip']['CreatedBy']] = $uuserid;
                    $Province = $this->Province->creates($array);

                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                    $array[$this->inv['flip']['UpdatedBy']] = $uuserid;
                    $Province = $this->Province->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Province->update($array);

                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->_loaddbclass([ 'Country' ]);
        $this->arrcountry = $this->Country->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrcountry'] = $this->arrcountry;

        $this->inv['ProvinceID'] = $this->ProvinceID; $this->inv['errorProvinceID'] = $this->errorProvinceID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['CountryID'] = $this->CountryID; $this->inv['errorCountryID'] = $this->errorCountryID;
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
            $this->_loaddbclass([ 'Province' ]);

            foreach($this->inv['delete'] as $val) {
                $Province = $this->Province->where([[$this->objectkey,'=',$val]])->first();
                if($Province) {
                    $this->Name = $Province[$this->inv['flip']['Name']];

                    $array[$this->inv['flip']['Status']] = 1;
                    $Province->update($array);

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
        $this->_loaddbclass([ 'Province' ]);

        $result = $this->Province->leftJoin([
            ['country','province.CountryID','=','country.ID'],
        ])->select([
            'country.Name as CountryName',
            'province.*'
        ])->where([['province.Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        $this->inv['flip']['Name'] = 'province.Name';
        $this->inv['flip']['CountryName'] = 'country.Name';
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $this->inv['flip']['Name'] = 'Name';
        $this->inv['flip']['CountryName'] = 'CountryName';

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['ProvinceID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}