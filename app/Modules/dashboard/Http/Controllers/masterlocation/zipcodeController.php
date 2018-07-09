<?php

namespace App\Modules\dashboard\Http\Controllers\masterlocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class zipcodeController extends Controller
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
        'ID' => 'ZipcodeID',
        'CityID' => 'CityID',
        'CityName' => 'CityName',
        'PostalCode' => 'PostalCode',
        'Longitude' => 'Longitude',
        'Latitude' => 'Latitude',
        'District' => 'District',
        'Village' => 'Village',
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
        'ZipcodeID' => ['Zipcode ID'],
        'CityID' => ['City ID'],
        'CityName' => ['City Name', true],
        'PostalCode' => ['Postal Code', true],
        'Longitude' => ['Longitude', true],
        'Latitude' => ['Latitude', true],
        'District' => ['District', true],
        'Village' => ['Village', true],
        'IsActive' => ['IsActive', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    var $objectkey = '', $ZipcodeID = '', $errorZipcodeID = '', $CityID = '', $errorCityID = '', $PostalCode = '', $errorPostalCode = '', $Longitude = '', $errorLongitude = '', $Latitude = '', $errorLatitude = '', $District = '', $errorDistrict = '', $Village = '', $errorVillage = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    var $arrcity = [];

    public function popup()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['gettype']) && isset($this->inv['getid'])) {
            $this->inv['header']['menus'] = false;
            $this->inv['header']['addnew'] = false;
            $this->inv['alias']['IsActive'][1] = false;
            $this->inv['extlink'] .= '/popup/id_ZipcodeID/type_'.$this->inv['gettype'];
            $this->inv['popuptype'] = $this->inv['gettype'];

            return $this->views(["defaultpopup"]);
        } else {
            return $this->_redirect('404');
        }
    }

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    $id = $request['value'];

                    $this->_loaddbclass([ 'Zipcode' ]);

                    $Zipcode = $this->Zipcode->where([['ID','=',$id]])->first();

                    if($Zipcode) {
                        $IsActive = 1;
                        if($Zipcode->IsActive == 1) $IsActive = 0;
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $Zipcode->update($array);

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
                $this->_loaddbclass([ 'Zipcode' ]);

                $Zipcode = $this->Zipcode->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Zipcode) {
                    $this->ZipcodeID = $Zipcode[$this->inv['flip']['ZipcodeID']];
                    $this->CityID = $Zipcode[$this->inv['flip']['CityID']];
                    $this->PostalCode = $Zipcode[$this->inv['flip']['PostalCode']];
                    $this->Longitude = $Zipcode[$this->inv['flip']['Longitude']];
                    $this->Latitude = $Zipcode[$this->inv['flip']['Latitude']];
                    $this->District = $Zipcode[$this->inv['flip']['District']];
                    $this->Village = $Zipcode[$this->inv['flip']['Village']];
                    $this->IsActive = $Zipcode[$this->inv['flip']['IsActive']];
                    $this->Status = $Zipcode[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Zipcode[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Zipcode[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Zipcode[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Zipcode[$this->inv['flip']['UpdatedBy']];
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

        $this->_loaddbclass([ 'City' ]);

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([ 'Zipcode' ]);

            if(isset($request['edit'])) {
                $Zipcode = $this->Zipcode->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Zipcode) {
                    $this->_redirect('404');
                }
            }

            $this->PostalCode = $request['PostalCode'];
            if(empty($this->PostalCode)) { $this->errorPostalCode = 'Silahkan masukkan '.$this->aliasform['PostalCode'][0].' !'; }
            
            $this->CityID = $request['CityID'];
            if(empty($this->CityID)) { $this->errorCityID = 'Silahkan pilih '.$this->aliasform['CityName'][0].' !'; }

            $this->Longitude = $request['Longitude'];
            if(empty($this->Longitude)) { $this->errorLongitude = 'Silahkan masukkan '.$this->aliasform['Longitude'][0].' !'; }
            
            $this->Latitude = $request['Latitude'];
            if(empty($this->Latitude)) { $this->errorLatitude = 'Silahkan masukkan '.$this->aliasform['Latitude'][0].' !'; }
            
            $this->District = $request['District'];
            if(empty($this->District)) { $this->errorDistrict = 'Silahkan masukkan '.$this->aliasform['District'][0].' !'; }

            $this->Village = $request['Village'];
            if(empty($this->Village)) { $this->errorVillage = 'Silahkan masukkan '.$this->aliasform['Village'][0].' !'; }

            if(!$this->inv['messageerror'] && !$this->errorZipcodeID && !$this->errorCityID && !$this->errorPostalCode && !$this->errorLongitude && !$this->errorLatitude && !$this->errorDistrict && !$this->errorVillage && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {

                $City = $this->City->where([['ID','=',$this->CityID]])->first();

                $array  = array(
                    $this->inv['flip']['ZipcodeID'] => $this->ZipcodeID,
                    $this->inv['flip']['CityID'] => $this->CityID,
                    $this->inv['flip']['PostalCode'] => $this->PostalCode,
                    $this->inv['flip']['Longitude'] => $this->Longitude,
                    $this->inv['flip']['Latitude'] => $this->Latitude,
                    $this->inv['flip']['District'] => $this->District,
                    $this->inv['flip']['Village'] => $this->Village,
                    $this->inv['flip']['IsActive'] => $this->IsActive,
                    $this->inv['flip']['Status'] => $this->Status,
                    $this->inv['flip']['CreatedDate'] => $this->CreatedDate,
                    $this->inv['flip']['CreatedBy'] => $this->CreatedBy,
                    $this->inv['flip']['UpdatedDate'] => $this->UpdatedDate,
                    $this->inv['flip']['UpdatedBy'] => $this->UpdatedBy,
                );

                $userdata   = \Session::get('userdata');
                $uuserid    = $userdata['uuserid'];

                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['Status']] = 0;
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime('now');
                    $array[$this->inv['flip']['CreatedBy']] = $uuserid;
                    $Zipcode = $this->Zipcode->creates($array);

                    $this->_dblog('addnew', $this, $this->PostalCode);
                    \Session::put('messagesuccess', "Saving $this->PostalCode Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                    $array[$this->inv['flip']['UpdatedBy']] = $uuserid;
                    $PostalCode = $this->Zipcode->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $PostalCode->update($array);

                    $this->_dblog('edit', $this, $this->PostalCode);
                    \Session::put('messagesuccess', "Update $this->PostalCode Completed !");
                }

                return $this->_redirect(get_class());
            }
        }
        
        //$this->arrcity = $this->City->getmodel()->orderBy('Name','ASC')->get()->toArray();
         $arrcity = $this->City->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();

        $this->inv['arrcity'] = $arrcity;
        $this->inv['ZipcodeID'] = $this->ZipcodeID; $this->inv['errorZipcodeID'] = $this->errorZipcodeID;
        $this->inv['CityID'] = $this->CityID; $this->inv['errorCityID'] = $this->errorCityID;
        $this->inv['PostalCode'] = $this->PostalCode; $this->inv['errorPostalCode'] = $this->errorPostalCode;
        $this->inv['Longitude'] = $this->Longitude; $this->inv['errorLongitude'] = $this->errorLongitude;
        $this->inv['Latitude'] = $this->Latitude; $this->inv['errorLatitude'] = $this->errorLatitude;
        $this->inv['District'] = $this->District; $this->inv['errorDistrict'] = $this->errorDistrict;
        $this->inv['Village'] = $this->Village; $this->inv['errorVillage'] = $this->errorVillage;
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
            $this->_loaddbclass([ 'Zipcode' ]);

            foreach($this->inv['delete'] as $val) {
                $Zipcode = $this->Zipcode->where([[$this->objectkey,'=',$val]])->first();
                if($Zipcode) {
                    $this->Zipcode = $Zipcode[$this->inv['flip']['PostalCode']];

                    $array[$this->inv['flip']['Status']] = 1;
                    $Zipcode->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->PostalCode);
                    $this->inv['messagesuccess'] .= "Delete $this->Zipcode Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'Zipcode' ]);

        $result = $this->Zipcode->leftjoin([
            ['city','city.ID','=','zipcode.'.$this->inv['flip']['CityID']],
        ])->select([
            'city.Name as CityName',
            'zipcode.*'
        ]);

        if(isset($this->inv['gettype']) && isset($this->inv['getid'])) {

            $result = $result->where([['zipcode.Status','=',0], ['zipcode.IsActive','=',1]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        }
        else{

            $result = $result->where([['zipcode.Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        }

        $this->inv['flip']['CityName'] = 'city.Name';
        $this->inv['flip']['ProvinceName'] = 'province.Name';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['CityName'] = 'CityName';
        $this->inv['flip']['ProvinceName'] = 'ProvinceName';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['ZipcodeID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}
