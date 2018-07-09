<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class sellerController extends Controller
{
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
        'ID' => 'SellerID',
        'SellerUniqueID' => 'SellerUniqueID',
        'FullName' => 'FullName',
        'Phone' => 'Phone',
        'Email' => 'Email',
        'Website' => 'Website',
        'CompanyName' => 'CompanyName',
        'LegalType' => 'LegalType',
        'CountryID' => 'CountryID',
        'CountryName' => 'CountryName',
        'ProvinceID' => 'ProvinceID',
        'ProvinceName' => 'ProvinceName',
        'CityID' => 'CityID',
        'CityName' => 'CityName',
        'DistrictID' => 'DistrictID',
        'DistrictName' => 'DistrictName',
        'ZipcodeID' => 'ZipcodeID',
        'Address1' => 'Address1',
        'Address2' => 'Address2',
        'SupplyGeo' => 'SupplyGeo',
        'SellerFetured' => 'SellerFetured',
        'PIC' => 'PIC',
        'BusinessRegNumber' => 'BusinessRegNumber',
        'VATReg' => 'VATReg',
        'SellerVAT' => 'SellerVAT',
        'VATInfoFile' => 'VATInfoFile',
        'BankName' => 'BankName',
        'BankAccountNumber' => 'BankAccountNumber',
        'BankBeneficiaryName' => 'BankBeneficiaryName',
        'BankBranch' => 'BankBranch',
        'PickupCountryID' => 'PickupCountryID',
        'PickupProvinceID' => 'PickupProvinceID',
        'PickupCityID' => 'PickupCityID',
        'PickupDistrictID' => 'PickupDistrictID',
        'PickupZipcodeID' => 'PickupZipcodeID',
        'PickupAddress1' => 'PickupAddress1',
        'PickupPhone' => 'PickupPhone',
        'PickupPIC' => 'PickupPIC',
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
        'SellerID' => ['Seller ID'],
        'SellerUniqueID' => ['Seller Unique', true],
        'FullName' => ['Full Name', true],
        'Phone' => ['Phone', true],
        'Email' => ['Email', true],
        'Website' => ['Website'],
        'CompanyName' => ['Company Name'],
        'LegalType' => ['Legal Type'],
        'CountryID' => ['Country ID'],
        'CountryName' => ['Country Name'],
        'ProvinceID' => ['Province ID'],
        'ProvinceName' => ['Province Name'],
        'CityID' => ['City ID'],
        'CityName' => ['City Name'],
        'DistrictID' => ['District ID'],
        'DistrictName' => ['District Name'],
        'ZipcodeID' => ['Zip Code'],
        'Address1' => ['Address1'],
        'Address2' => ['Address2'],
        'SupplyGeo' => ['Supply Geo'],
        'SellerFetured' => ['Seller Fetured'],
        'PIC' => ['PIC', true],   
        'BusinessRegNumber' => ['Business Registration Number'],
        'VATReg' => ['VAT Registration Number'],
        'SellerVAT' => ['Seller VAT ( % )'],
        'VATInfoFile' => ['VAT Image Scan'],
        'BankName' => ['Bank Name'],
        'BankAccountNumber' => ['Bank Account Number'],
        'BankBeneficiaryName' => ['Bank Beneficiary Name'],
        'BankBranch' => ['Bank Branch'],
        'PickupCountryID' => ['Pickup Country ID'],
        'PickupProvinceID' => ['Pickup Province ID'],
        'PickupCityID' => ['Pickup City ID'],
        'PickupDistrictID' => ['Pickup District ID'],
        'PickupZipcodeID' => ['Pickup Zip Code'],
        'PickupAddress1' => ['Pickup Address'],
        'PickupPhone' => ['Pickup Phone'],
        'PickupPIC' => ['Pickup PIC'],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'permalink' => ['permalink'],
        'ShippingList' => ['Shipping'],
    ];

    var $pathimage = '/resources/assets/backend/images/seller/';
    var $objectkey = '', $SellerID = '', $errorSellerID = '', $SellerUniqueID = '', $errorSellerUniqueID = '', $FullName = '', $errorFullName = '', $Phone = '', $errorPhone = '', $Email = '', $errorEmail = '', $Website = '', $errorWebsite = '', $CompanyName = '', $errorCompanyName = '', $LegalType = '', $errorLegalType = '', $CountryID = '', $errorCountryID = '', $ProvinceID = '', $errorProvinceID = '', $CityID = '', $errorCityID = '', $DistrictID = '', $errorDistrictID = '', $ZipcodeID = '', $errorZipcodeID = '', $Address1 = '', $errorAddress1 = '', $Address2 = '', $errorAddress2 = '', $SupplyGeo = '', $errorSupplyGeo = '', $SellerFetured = '', $errorSellerFetured = '', $PIC = '', $errorPIC = '', $BusinessRegNumber = '', $errorBusinessRegNumber = '', $VATReg = '', $errorVATReg = '', $SellerVAT = '', $errorSellerVAT = '', $VATInfoFile = '', $VATInfoFilefiletype = '', $errorVATInfoFile = '', $BankName = '', $errorBankName = '', $BankAccountNumber = '', $errorBankAccountNumber = '', $BankBeneficiaryName = '', $errorBankBeneficiaryName = '', $BankBranch = '', $errorBankBranch = '', $PickupCountryID = '', $errorPickupCountryID = '', $PickupProvinceID = '', $errorPickupProvinceID = '', $PickupCityID = '', $errorPickupCityID = '', $PickupDistrictID = '', $errorPickupDistrictID = '', $PickupZipcodeID = '', $errorPickupZipcodeID = '', $PickupAddress1 = '', $errorPickupAddress1 = '', $PickupPhone = '', $errorPickupPhone = '', $PickupPIC = '', $errorPickupPIC = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '', $ShippingList = '', $errorShippingList = '';        

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    $id = $request['value'];

                    $this->_loaddbclass([ 'Seller' ]);

                    $Seller = $this->Seller->where([['ID','=',$id]])->first();

                    if($Seller) {
                        $IsActive = 1;
                        if($Seller->IsActive == 1) $IsActive = 0;
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $Seller->update($array);

                        die('OK');
                    } else die('Error');
                break;
                case 'GetProvince' :
                    $CountryID = $request['CountryID'];

                    $this->_loaddbclass([ 'Province' ]);

                    $array = $this->Province->where([['CountryID','=',$CountryID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();

                    if(count($array)) die(json_encode(['response' => 'OK', 'data' => $array], JSON_FORCE_OBJECT));
                    else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                break;
                case 'GetCity' :
                    $ProvinceID = $request['ProvinceID'];

                    $this->_loaddbclass([ 'City' ]);

                    $array = $this->City->where([['ProvinceID','=',$ProvinceID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();

                    if(count($array)) die(json_encode(['response' => 'OK', 'data' => $array], JSON_FORCE_OBJECT));
                    else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                break;
                case 'GetDistrict' :
                    $CityID = $request['CityID'];

                    $this->_loaddbclass([ 'District' ]);

                    $array = $this->District->where([['CityID','=',$CityID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();

                    if(count($array)) die(json_encode(['response' => 'OK', 'data' => $array], JSON_FORCE_OBJECT));
                    else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                break;
                case 'deleteVATInfoFile' :
                    $SellerID = $request['value'];
                    $this->_loaddbclass([ 'Seller' ]);
                    $Seller = $this->Seller->where([['ID','=',$SellerID]])->first();

                    if($Seller[$this->inv['flip']['VATInfoFile']]) {
                        @unlink(base_path().$this->pathimage.$Seller[$this->inv['flip']['VATInfoFile']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Seller[$this->inv['flip']['VATInfoFile']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Seller[$this->inv['flip']['VATInfoFile']]);
                        $Seller->update([$this->inv['flip']['VATInfoFile'] => '']);
                    }
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
                $this->_loaddbclass([ 'Seller' ]);

                $Seller = $this->Seller->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Seller) {
                    $this->SellerID = $Seller[$this->inv['flip']['SellerID']];
                    $this->SellerUniqueID = $Seller[$this->inv['flip']['SellerUniqueID']];
                    $this->FullName = $Seller[$this->inv['flip']['FullName']];
                    $this->Phone = $Seller[$this->inv['flip']['Phone']];
                    $this->Email = $Seller[$this->inv['flip']['Email']];
                    $this->Website = $Seller[$this->inv['flip']['Website']];
                    $this->CompanyName = $Seller[$this->inv['flip']['CompanyName']];
                    $this->LegalType = $Seller[$this->inv['flip']['LegalType']];
                    $this->CountryID = $Seller[$this->inv['flip']['CountryID']];
                    $this->ProvinceID = $Seller[$this->inv['flip']['ProvinceID']];
                    $this->CityID = $Seller[$this->inv['flip']['CityID']];
                    $this->DistrictID = $Seller[$this->inv['flip']['DistrictID']];
                    $this->ZipcodeID = $Seller[$this->inv['flip']['ZipcodeID']];
                    $this->Address1 = $Seller[$this->inv['flip']['Address1']];
                    $this->Address2 = $Seller[$this->inv['flip']['Address2']];
                    $this->SupplyGeo = $Seller[$this->inv['flip']['SupplyGeo']];
                    $this->SellerFetured = $Seller[$this->inv['flip']['SellerFetured']];
                    $this->PIC = $Seller[$this->inv['flip']['PIC']];
                    $this->BusinessRegNumber = $Seller[$this->inv['flip']['BusinessRegNumber']];
                    $this->VATReg = $Seller[$this->inv['flip']['VATReg']];
                    $this->SellerVAT = $Seller[$this->inv['flip']['SellerVAT']];

                    if($Seller[$this->inv['flip']['VATInfoFile']])
                        $this->VATInfoFile = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                                            $Seller[$this->inv['flip']['VATInfoFile']]; 

                    $this->BankName = $Seller[$this->inv['flip']['BankName']];
                    $this->BankAccountNumber = $Seller[$this->inv['flip']['BankAccountNumber']];
                    $this->BankBeneficiaryName = $Seller[$this->inv['flip']['BankBeneficiaryName']];
                    $this->BankBranch = $Seller[$this->inv['flip']['BankBranch']];
                    $this->PickupCountryID = $Seller[$this->inv['flip']['PickupCountryID']];
                    $this->PickupProvinceID = $Seller[$this->inv['flip']['PickupProvinceID']];
                    $this->PickupCityID = $Seller[$this->inv['flip']['PickupCityID']];
                    $this->PickupDistrictID = $Seller[$this->inv['flip']['PickupDistrictID']];
                    $this->PickupZipcodeID = $Seller[$this->inv['flip']['PickupZipcodeID']];
                    $this->PickupAddress1 = $Seller[$this->inv['flip']['PickupAddress1']];
                    $this->PickupPhone = $Seller[$this->inv['flip']['PickupPhone']];
                    $this->PickupPIC = $Seller[$this->inv['flip']['PickupPIC']];
                    $this->IsActive = $Seller[$this->inv['flip']['IsActive']];
                    $this->Status = $Seller[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Seller[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Seller[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Seller[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Seller[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $Seller[$this->inv['flip']['permalink']];

                    $this->_loaddbclass(['SellerShipping']);

                    $this->ShippingList = $this->SellerShipping->where([['SellerID','=',$Seller[$this->inv['flip']['SellerID']]]])->pluck('ShippingID')->toArray();
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
            $this->_loaddbclass([ 'Seller' ]);

            if(isset($request['edit'])) {
                $Seller = $this->Seller->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Seller) {
                    $this->_redirect('404');
                }
            }

            $this->FullName = $request['FullName'];
            if(empty($this->FullName)) {
                $this->errorFullName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.FullName')]
                );
            }

            $Seller = $this->Seller->where([[$this->inv['flip']['FullName'],'=',$this->FullName],['Status','=',0]])->first();

            if($Seller) {
                if(isset($request['addnew']) && strtoupper($Seller[$this->inv['flip']['FullName']]) == strtoupper($this->FullName) && $Seller['Status'] == 0) {
                    if(!$this->errorFullName) {
                        $this->errorFullName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.Seller.FullName')]
                        );
                    }
                } else {
                    if ($Seller[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorFullName) {
                            $this->errorFullName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.Seller.FullName')]
                            );
                        }
                    }
                }
            }

            $this->Phone = $request['Phone'];
            if(empty($this->Phone)) {
                $this->errorPhone = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.Phone')]
                );
            }

            $this->Email = $request['Email'];
            if(empty($this->Email)) {
                $this->errorEmail = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.Email')]
                );
            }

            $this->Website = $request['Website'];
            if(empty($this->Website)) {
                $this->errorWebsite = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.Website')]
                );
            }

            $this->CompanyName = $request['CompanyName'];
            if(empty($this->CompanyName)) {
                $this->errorCompanyName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.CompanyName')]
                );
            }

            $this->LegalType = $request['LegalType'];
            if(!is_numeric($this->LegalType)) {
                $this->errorLegalType = $this->_trans('validation.mandatoryselect', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.LegalType')]
                );
            }

            $this->CountryID = $request['CountryID'];
            if(empty($this->CountryID)) {
                $this->errorCountryID = $this->_trans('validation.mandatoryselect', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.CountryID')]
                );
            }

            $this->ProvinceID = $request['ProvinceID'];
            if(empty($this->ProvinceID)) {
                $this->errorProvinceID = $this->_trans('validation.mandatoryselect', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.ProvinceID')]
                );
            }

            $this->CityID = $request['CityID'];
            if(empty($this->CityID)) {
                $this->errorCityID = $this->_trans('validation.mandatoryselect', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.CityID')]
                );
            }

            $this->DistrictID = $request['DistrictID'];
            if(empty($this->DistrictID)) {
                $this->errorDistrictID = $this->_trans('validation.mandatoryselect', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.DistrictID')]
                );
            }

            $this->ZipcodeID = $request['ZipcodeID'];
            if(empty($this->ZipcodeID)) {
                $this->errorZipcodeID = $this->_trans('validation.mandatoryselect', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.ZipcodeID')]
                );
            }

            $this->Address1 = $request['Address1'];
            if(empty($this->Address1)) {
                $this->errorAddress1 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.Address1')]
                );
            }

            $this->Address2 = $request['Address2'];
            if(empty($this->Address2)) {
                $this->errorAddress2 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.Address2')]
                );
            }

            $this->SupplyGeo = $request['SupplyGeo'];
            if(empty($this->SupplyGeo)) {
                $this->errorSupplyGeo = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.SupplyGeo')]
                );
            }

            $this->SellerFetured = $request['SellerFetured'];
            if(!is_numeric($this->SellerFetured)) {
                $this->errorSellerFetured = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.SellerFetured')]
                );
            }

            $this->PIC = $request['PIC'];
            if(empty($this->PIC)) {
                $this->errorPIC = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.PIC')]
                );
            }

            if(isset($request['ShippingList'])) $this->ShippingList = $request['ShippingList'];
            else {
                $this->errorShippingList = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.ShippingList')]
                );
            }

            $this->BusinessRegNumber = $request['BusinessRegNumber'];
            if(empty($this->BusinessRegNumber) && $this->LegalType == 1) {
                $this->errorBusinessRegNumber = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.BusinessRegNumber')]
                );
            }

            $this->VATReg = $request['VATReg'];
            if(empty($this->VATReg) && $this->LegalType == 1) {
                $this->errorVATReg = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.VATReg')]
                );
            }

            $this->SellerVAT = $request['SellerVAT'];
            if(empty($this->SellerVAT) && $this->LegalType == 1) {
                $this->errorSellerVAT = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.SellerVAT')]
                );
            }

            if(isset($requestfile['VATInfoFile'])) $this->VATInfoFile = $requestfile['VATInfoFile'];
            else $this->VATInfoFile = '';
            if(empty($this->VATInfoFile) && !(isset($request['edit']) && $Seller[$this->inv['flip']['VATInfoFile']]) && $this->LegalType == 1) {
                $this->errorVATInfoFile = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.VATInfoFile')]
                );
            }
            if($this->VATInfoFile && !$this->_checkimage($this->VATInfoFile, $this->VATInfoFilefiletype) && $this->LegalType == 1) {
                $this->errorVATInfoFile = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.VATInfoFile')]
                );
            }

            $this->VATReg = $request['VATReg'];
            if(empty($this->VATReg) && $this->LegalType == 1) {
                $this->errorVATReg = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.VATReg')]
                );
            }

            $this->BankName = $request['BankName'];
            if(empty($this->BankName)) {
                $this->errorBankName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.BankName')]
                );
            }

            $this->BankAccountNumber = $request['BankAccountNumber'];
            if(empty($this->BankAccountNumber)) {
                $this->errorBankAccountNumber = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.BankAccountNumber')]
                );
            }

            $this->BankBeneficiaryName = $request['BankBeneficiaryName'];
            if(empty($this->BankBeneficiaryName)) {
                $this->errorBankBeneficiaryName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.BankBeneficiaryName')]
                );
            }

            $this->BankBranch = $request['BankBranch'];
            if(empty($this->BankBranch)) {
                $this->errorBankBranch = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.BankBranch')]
                );
            }

            $this->SupplyGeo = $request['SupplyGeo'];
            if(empty($this->SupplyGeo)) {
                $this->errorSupplyGeo = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.SupplyGeo')]
                );
            }

            $this->PickupCountryID = $request['PickupCountryID'];
            if(empty($this->PickupCountryID)) {
                $this->errorPickupCountryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.PickupCountryID')]
                );
            }

            $this->PickupProvinceID = $request['PickupProvinceID'];
            if(empty($this->PickupProvinceID)) {
                $this->errorPickupProvinceID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.PickupProvinceID')]
                );
            }

            $this->PickupCityID = $request['PickupCityID'];
            if(empty($this->PickupCityID)) {
                $this->errorPickupCityID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.PickupCityID')]
                );
            }

            $this->PickupDistrictID = $request['PickupDistrictID'];
            if(empty($this->PickupDistrictID)) {
                $this->errorPickupDistrictID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.PickupDistrictID')]
                );
            }

            $this->PickupZipcodeID = $request['PickupZipcodeID'];
            if(empty($this->PickupZipcodeID)) {
                $this->errorPickupZipcodeID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.PickupZipcodeID')]
                );
            }

            $this->PickupAddress1 = $request['PickupAddress1'];
            if(empty($this->PickupAddress1)) {
                $this->errorPickupAddress1 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.PickupAddress1')]
                );
            }

            $this->PickupPIC = $request['PickupPIC'];
            if(empty($this->PickupPIC)) {
                $this->errorPickupPIC = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.PickupPIC')]
                );
            }

            $this->PickupPhone = $request['PickupPhone'];
            if(empty($this->PickupPhone)) {
                $this->errorPickupPhone = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Seller.PickupPhone')]
                );
            }

            if(!$this->inv['messageerror'] && !$this->errorSellerID && !$this->errorSellerUniqueID && !$this->errorFullName && !$this->errorPhone && !$this->errorEmail && !$this->errorWebsite && !$this->errorCompanyName && !$this->errorLegalType && !$this->errorCountryID && !$this->errorProvinceID && !$this->errorCityID && !$this->errorDistrictID && !$this->errorZipcodeID && !$this->errorAddress1 && !$this->errorAddress2 && !$this->errorSupplyGeo && !$this->errorSellerFetured && !$this->errorPIC && !$this->errorShippingList && !$this->errorBusinessRegNumber && !$this->errorVATReg && !$this->errorSellerVAT && !$this->errorVATInfoFile && !$this->errorBankName && !$this->errorBankAccountNumber && !$this->errorBankBeneficiaryName && !$this->errorBankBranch && !$this->errorPickupCountryID && !$this->errorPickupProvinceID && !$this->errorPickupCityID && !$this->errorPickupDistrictID && !$this->errorPickupZipcodeID && !$this->errorPickupAddress1 && !$this->errorPickupPhone && !$this->errorPickupPIC && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) 
            {                
                $array = array(
                    $this->inv['flip']['SellerID'] => $this->SellerID,
                    $this->inv['flip']['FullName'] => $this->FullName,
                    $this->inv['flip']['Phone'] => $this->Phone,
                    $this->inv['flip']['Email'] => $this->Email,
                    $this->inv['flip']['Website'] => $this->Website,
                    $this->inv['flip']['CompanyName'] => $this->CompanyName,
                    $this->inv['flip']['LegalType'] => $this->LegalType,
                    $this->inv['flip']['CountryID'] => $this->CountryID,
                    $this->inv['flip']['ProvinceID'] => $this->ProvinceID,
                    $this->inv['flip']['CityID'] => $this->CityID,
                    $this->inv['flip']['DistrictID'] => $this->DistrictID,
                    $this->inv['flip']['ZipcodeID'] => $this->ZipcodeID,
                    $this->inv['flip']['Address1'] => $this->Address1,
                    $this->inv['flip']['Address2'] => $this->Address2,
                    $this->inv['flip']['SupplyGeo'] => $this->SupplyGeo,
                    $this->inv['flip']['SellerFetured'] => $this->SellerFetured,
                    $this->inv['flip']['PIC'] => $this->PIC,
                    $this->inv['flip']['BusinessRegNumber'] => $this->BusinessRegNumber,
                    $this->inv['flip']['VATReg'] => $this->VATReg,
                    $this->inv['flip']['SellerVAT'] => $this->SellerVAT,
                    $this->inv['flip']['BankName'] => $this->BankName,
                    $this->inv['flip']['BankAccountNumber'] => $this->BankAccountNumber,
                    $this->inv['flip']['BankBeneficiaryName'] => $this->BankBeneficiaryName,
                    $this->inv['flip']['BankBranch'] => $this->BankBranch,
                    $this->inv['flip']['PickupCountryID'] => $this->PickupCountryID,
                    $this->inv['flip']['PickupProvinceID'] => $this->PickupProvinceID,
                    $this->inv['flip']['PickupCityID'] => $this->PickupCityID,
                    $this->inv['flip']['PickupDistrictID'] => $this->PickupDistrictID,
                    $this->inv['flip']['PickupZipcodeID'] => $this->PickupZipcodeID,
                    $this->inv['flip']['PickupAddress1'] => $this->PickupAddress1,
                    $this->inv['flip']['PickupPhone'] => $this->PickupPhone,
                    $this->inv['flip']['PickupPIC'] => $this->PickupPIC,
                    $this->inv['flip']['permalink'] => $this->_permalink($this->FullName),
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $lastincrement = $this->_dbgetlastincrement(env('DB_DATABASE'), 'seller');
                    $lastincrement = 'LS'.date("ymd").sprintf('%03d', $lastincrement);
                    $array[$this->inv['flip']['SellerUniqueID']] = $lastincrement;

                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $Seller = $this->Seller->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->FullName);
                    \Session::put('messagesuccess', "Saving $this->FullName Completed !");

                    $datapost['ajaxpost'] = 'addnew';
                    $datapost['groupname'] = 'Seller '.$this->FullName;

                    $datapost['optmenu'] = $this->inv['config']['sellermenu'];

                    $idGroup = $this->_curlpost($this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].'dashboard/userteam/usergroup/ajaxpost', $datapost);

                    $Seller->update(['idGroup' => $idGroup]);
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Seller = $this->Seller->where([[$this->objectkey,'=',$this->inv['getid']]])->first();

                    $datapost['ajaxpost'] = 'edit';
                    $datapost['idGroup'] = $Seller->idGroup;
                    $datapost['optmenu'] = $this->inv['config']['sellermenu'];

                    $this->_curlpost($this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].'dashboard/userteam/usergroup/ajaxpost', $datapost);

                    $Seller->update($array);
                    
                    $this->_dblog('edit', $this, $this->FullName);
                    \Session::put('messagesuccess', "Update $this->FullName Completed !");
                }

                if($this->VATInfoFile) {
                    $VATInfoFileName = 'Icon_'.$Seller[$this->inv['flip']['SellerID']].$this->VATInfoFilefiletype;
                    $array[$this->inv['flip']['VATInfoFile']] = $VATInfoFileName;
                    $Seller->update($array);
                    list($width, $height) = getimagesize($this->VATInfoFile->GetPathName());
                    $this->_imagetofolderratio($this->VATInfoFile, base_path().$this->pathimage, $VATInfoFileName, $width, $height);
                    $this->_imagetofolderratio($this->VATInfoFile, base_path().$this->pathimage, 'medium_'.$VATInfoFileName, $width / 3, $height / 3);
                    $this->_imagetofolderratio($this->VATInfoFile, base_path().$this->pathimage, 'small_'.$VATInfoFileName, $width / 6, $height / 6);
                }

                $this->_loaddbclass(['SellerShipping']);

                foreach($this->SellerShipping->where([['SellerID','=',$Seller[$this->inv['flip']['SellerID']]]])->get() as $obj) {
                    $obj->delete();
                }

                $arrayStyle = [];
                foreach ($this->ShippingList as $key) {
                    $arrayStyle[] = [
                        'SellerID' => $Seller[$this->inv['flip']['SellerID']],
                        'ShippingID' => $key
                    ];
                }

                $this->SellerShipping->inserts($arrayStyle);

                return $this->_redirect(get_class());
            }
        }
       
        $this->inv['SellerID'] = $this->SellerID; $this->inv['errorSellerID'] = $this->errorSellerID;
        $this->inv['SellerUniqueID'] = $this->SellerUniqueID; $this->inv['errorSellerUniqueID'] = $this->errorSellerUniqueID;
        $this->inv['FullName'] = $this->FullName; $this->inv['errorFullName'] = $this->errorFullName;
        $this->inv['Phone'] = $this->Phone; $this->inv['errorPhone'] = $this->errorPhone;
        $this->inv['Email'] = $this->Email; $this->inv['errorEmail'] = $this->errorEmail;
        $this->inv['Website'] = $this->Website; $this->inv['errorWebsite'] = $this->errorWebsite;
        $this->inv['CompanyName'] = $this->CompanyName; $this->inv['errorCompanyName'] = $this->errorCompanyName;
        $this->inv['LegalType'] = $this->LegalType; $this->inv['errorLegalType'] = $this->errorLegalType;
        $this->inv['CountryID'] = $this->CountryID; $this->inv['errorCountryID'] = $this->errorCountryID;
        $this->inv['ProvinceID'] = $this->ProvinceID; $this->inv['errorProvinceID'] = $this->errorProvinceID;
        $this->inv['CityID'] = $this->CityID; $this->inv['errorCityID'] = $this->errorCityID;
        $this->inv['DistrictID'] = $this->DistrictID; $this->inv['errorDistrictID'] = $this->errorDistrictID;
        $this->inv['ZipcodeID'] = $this->ZipcodeID; $this->inv['errorZipcodeID'] = $this->errorZipcodeID;
        $this->inv['Address1'] = $this->Address1; $this->inv['errorAddress1'] = $this->errorAddress1;
        $this->inv['Address2'] = $this->Address2; $this->inv['errorAddress2'] = $this->errorAddress2;
        $this->inv['SupplyGeo'] = $this->SupplyGeo; $this->inv['errorSupplyGeo'] = $this->errorSupplyGeo;
        $this->inv['SellerFetured'] = $this->SellerFetured; $this->inv['errorSellerFetured'] = $this->errorSellerFetured;
        $this->inv['PIC'] = $this->PIC; $this->inv['errorPIC'] = $this->errorPIC;
        $this->inv['ShippingList'] = $this->ShippingList; $this->inv['errorShippingList'] = $this->errorShippingList;
        $this->inv['BusinessRegNumber'] = $this->BusinessRegNumber; $this->inv['errorBusinessRegNumber'] = $this->errorBusinessRegNumber;
        $this->inv['VATReg'] = $this->VATReg; $this->inv['errorVATReg'] = $this->errorVATReg;
        $this->inv['SellerVAT'] = $this->SellerVAT; $this->inv['errorSellerVAT'] = $this->errorSellerVAT;
        $this->inv['VATInfoFile'] = $this->VATInfoFile; $this->inv['errorVATInfoFile'] = $this->errorVATInfoFile;
        $this->inv['BankName'] = $this->BankName; $this->inv['errorBankName'] = $this->errorBankName;
        $this->inv['BankAccountNumber'] = $this->BankAccountNumber; $this->inv['errorBankAccountNumber'] = $this->errorBankAccountNumber;
        $this->inv['BankBeneficiaryName'] = $this->BankBeneficiaryName; $this->inv['errorBankBeneficiaryName'] = $this->errorBankBeneficiaryName;
        $this->inv['BankBranch'] = $this->BankBranch; $this->inv['errorBankBranch'] = $this->errorBankBranch;
        $this->inv['PickupCountryID'] = $this->PickupCountryID; $this->inv['errorPickupCountryID'] = $this->errorPickupCountryID;
        $this->inv['PickupProvinceID'] = $this->PickupProvinceID; $this->inv['errorPickupProvinceID'] = $this->errorPickupProvinceID;
        $this->inv['PickupCityID'] = $this->PickupCityID; $this->inv['errorPickupCityID'] = $this->errorPickupCityID;
        $this->inv['PickupDistrictID'] = $this->PickupDistrictID; $this->inv['errorPickupDistrictID'] = $this->errorPickupDistrictID;
        $this->inv['PickupZipcodeID'] = $this->PickupZipcodeID; $this->inv['errorPickupZipcodeID'] = $this->errorPickupZipcodeID;
        $this->inv['PickupAddress1'] = $this->PickupAddress1; $this->inv['errorPickupAddress1'] = $this->errorPickupAddress1;
        $this->inv['PickupPhone'] = $this->PickupPhone; $this->inv['errorPickupPhone'] = $this->errorPickupPhone;
        $this->inv['PickupPIC'] = $this->PickupPIC; $this->inv['errorPickupPIC'] = $this->errorPickupPIC;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;

        $this->_loaddbclass([ 'Country','Province','City','District','Shipping' ]);
        $this->arrCountry = $this->Country->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrCountry'] = $this->arrCountry;

        if($this->CountryID) {
            $this->arrProvince = $this->Province->where([['CountryID','=',$this->CountryID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        } else $this->arrProvince = [];
        $this->inv['arrProvince'] = $this->arrProvince;

        if($this->ProvinceID) {
            $this->arrCity = $this->City->where([['ProvinceID','=',$this->ProvinceID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        } else $this->arrCity = [];
        $this->inv['arrCity'] = $this->arrCity;

        if($this->CityID) {
            $this->arrDistrict = $this->District->where([['CityID','=',$this->CityID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        } else $this->arrDistrict = [];
        $this->inv['arrDistrict'] = $this->arrDistrict;

        $ArrShipping = $this->Shipping->get()->toArray();
        $this->inv['ArrShipping'] = $ArrShipping;

        $this->arrPickupCountry = $this->Country->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrPickupCountry'] = $this->arrPickupCountry;

        if($this->PickupCountryID) {
            $this->arrPickupProvince = $this->Province->where([['CountryID','=',$this->PickupCountryID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        } else $this->arrPickupProvince = [];
        $this->inv['arrPickupProvince'] = $this->arrPickupProvince;

        if($this->PickupProvinceID) {
            $this->arrPickupCity = $this->City->where([['ProvinceID','=',$this->PickupProvinceID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        } else $this->arrPickupCity = [];
        $this->inv['arrPickupCity'] = $this->arrPickupCity;

        if($this->PickupCityID) {
            $this->arrPickupDistrict = $this->District->where([['CityID','=',$this->PickupCityID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        } else $this->arrPickupDistrict = [];
        $this->inv['arrPickupDistrict'] = $this->arrPickupDistrict;

        $arrstatus = [
            '0' => 'Non Business Company',
            '1' => 'Business Company'
        ];
        $this->inv['arrLegalType'] = $arrstatus;

        $arrSellerFetured = [
            '0' => 'No',
            '1' => 'Yes'
        ];
        $this->inv['arrSellerFetured'] = $arrSellerFetured;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([ 'Seller', 'MasterMenuAccess' ]);

            foreach($this->inv['delete'] as $val) {
                $Seller = $this->Seller->where([[$this->objectkey,'=',$val]])->first();
                if($Seller) {
                    $this->FullName = $Seller[$this->inv['flip']['FullName']];

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['permalink']] = '';
                    
                    $this->MasterMenuAccess->where([['idGroup','=',$Seller['idGroup']]])->get()->each(function ($obj) {
                        $obj->delete();
                    });

                    if($Seller[$this->inv['flip']['VATInfoFile']]) {
                        @unlink(base_path().$this->pathimage.$Seller[$this->inv['flip']['VATInfoFile']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Seller[$this->inv['flip']['VATInfoFile']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Seller[$this->inv['flip']['VATInfoFile']]);
                    }

                    $Seller->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->FullName);
                    $this->inv['messagesuccess'] .= "Delete $this->FullName Completed !$br";

                    $datapost['ajaxpost'] = 'delete';
                    $datapost['delete'] = $Seller->idGroup;

                    $this->_curlpost($this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].'dashboard/userteam/usergroup/ajaxpost', $datapost);
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'Seller' ]);

        $result = $this->Seller->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['SellerID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';   
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}