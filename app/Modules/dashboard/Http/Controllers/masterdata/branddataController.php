<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class branddataController extends Controller
{
    public $model = 'Brand';
    
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => false,
        'refresh'   => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'BrandID',
        'SellerID' => 'SellerID',
        'NameSeller' => 'NameSeller',
        'Name' => 'Name',
        'TitleUnFeature' => 'TitleUnFeature',
        'Note' => 'Note',
        'MainCategory' => 'MainCategory',
        'Mode' => 'Mode',
        'Logo' => 'Logo',
        'Banner' => 'Banner',
        'Icon' => 'Icon',
        'ShowOnHeader' => 'ShowOnHeader',
        'About' => 'About',
        'LicenseSell' => 'LicenseSell',
        'LicenseFile' => 'LicenseFile',
        'HolidayMode' => 'HolidayMode',
        'Favorite' => 'Favorite',
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
        'BrandID' => ['ID'],
        'SellerID' => ['Seller ID'],
        'NameSeller' => ['Seller Name', true],
        'Name' => ['Name', true],
        'TitleUnFeature' => ['Title UnFeature'],
        'Note' => ['Note'],
        'MainCategory' => ['Main Category'],
        'Mode' => ['Mode', true],
        'Logo' => ['Logo'],
        'Banner' => ['Banner'],
        'Icon' => ['Icon Brand', true],
        'ShowOnHeader' => ['Show On Header', true],
        'About' => ['About'],
        'LicenseSell' => ['License Sell'],
        'MainCategory' => ['Main Category'],
        'LicenseFile' => ['License File'],
        'HolidayMode' => ['Holiday Mode', true],
        'Favorite' => ['Favorite'],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'permalink' => ['permalink'],
        'StyleList' => ['Style'],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/brand/';
    var $pathfile = '/resources/assets/backend/file/brand/';
    var $objectkey = '', $BrandID = '', $errorBrandID = '', $SellerID = '', $errorSellerID = '', $Name = '', $errorName = '', $TitleUnFeature = '', $errorTitleUnFeature = '', $Mode = '', $errorMode = '', $ShowOnHeader = '', $errorShowOnHeader = '', $About = '', $errorAbout = '', $Note = '', $errorNote = '', $MainCategory = '', $errorMainCategory = '', $Logo = '', $errorLogo = '', $Logofiletype = '', $Banner = '', $errorBanner = '', $Bannerfiletype = '', $Icon = '', $errorIcon = '', $Iconfiletype = '', $LicenseSell = '', $errorLicenseSell = '', $LicenseFile = '',$LicenseFilefiletype = '', $errorLicenseFile = '', $HolidayMode = '', $errorHolidayMode = '', $Favorite = '', $errorFavorite = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '', $StyleList = '', $errorStyleList = '', $lastid = '';
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            if($request['ajaxpost'] != 'GetMode') {
                $this->_loaddbclass([ 'Brand' ]);
                $id = $request['value'];
                $Brand = $this->Brand->where([['ID','=',$id]])->first();
            }
            
            switch($request['ajaxpost']) {
                case 'setactive' :
                    if($Brand) {
                        $this->Name = $Brand[$this->inv['flip']['Name']];

                        $IsActive = 1;
                        if($Brand->IsActive == 1) $IsActive = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];

                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $Brand->update($array);

                        if($IsActive) $IsActive = 'Active';
                        else $IsActive = 'Non Active';

                        $this->_dblog('edit', $this, 'Set '.$IsActive.' '.$this->Name);

                        die('OK');
                    } else die('Error');
                    break;
                case 'setonheader' :
                    if($Brand) {
                        $ShowOnHeader = 1;
                        if($Brand->ShowOnHeader == 1) $ShowOnHeader = 0;
                        $array[$this->inv['flip']['ShowOnHeader']] = $ShowOnHeader;
                        $Brand->update($array);
                        die('OK');
                    } else die('Error');
                    break;
                case 'setholidaymode' :
                    if($Brand) {
                        $HolidayMode = 1;
                        if($Brand->HolidayMode == 1) $HolidayMode = 0;
                        $array[$this->inv['flip']['HolidayMode']] = $HolidayMode;
                        $Brand->update($array);
                        die('OK');
                    } else die('Error');
                    break;
                case 'deleteLogo' :
                    if($Brand[$this->inv['flip']['Logo']]) {
                        @unlink(base_path().$this->pathimage.$Brand[$this->inv['flip']['Logo']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Brand[$this->inv['flip']['Logo']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Brand[$this->inv['flip']['Logo']]);
                        $Brand->update([$this->inv['flip']['Logo'] => '']);
                    }
                    break;
                case 'deleteBanner' :
                    if($Brand[$this->inv['flip']['Banner']]) {
                        @unlink(base_path().$this->pathimage.$Brand[$this->inv['flip']['Banner']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Brand[$this->inv['flip']['Banner']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Brand[$this->inv['flip']['Banner']]);
                        $Brand->update([$this->inv['flip']['Banner'] => '']);
                    }
                    break;
                case 'deleteIcon' :
                    if($Brand[$this->inv['flip']['Icon']]) {
                        @unlink(base_path().$this->pathimage.$Brand[$this->inv['flip']['Icon']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Brand[$this->inv['flip']['Icon']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Brand[$this->inv['flip']['Icon']]);
                        $Brand->update([$this->inv['flip']['Icon'] => '']);
                    }
                    break;
                case 'deleteLicenseFile' :
                    if($Brand[$this->inv['flip']['LicenseFile']]) {
                        @unlink(base_path().$this->pathfile.$Brand[$this->inv['flip']['LicenseFile']]);
                        $Brand->update([$this->inv['flip']['LicenseFile'] => '']);
                    }
                    break;
                case 'GetMode' :
                    $SellerID = $request['value'];

                    $this->_loaddbclass(['Seller']);
                    $Seller = $this->Seller->where([['ID','=',$SellerID]])->first();
                    if($Seller) {
                        if($Seller->SellerFetured == 0)
                            die(json_encode(['response' => 'OK', 'data' => [
                                0 => 'Feature',
                                1 => 'Artist',
                                2 => 'Indie'
                            ]], JSON_FORCE_OBJECT));
                        else
                            die(json_encode(['response' => 'OK', 'data' => [
                                1 => 'Artist',
                                2 => 'Indie'
                            ]], JSON_FORCE_OBJECT));
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
    
    public function edit()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->getdata();
    }

    private function getdata() {
        if (isset($this->inv['getid'])) {
            if(!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass([ 'Brand' ]);

                $Brand = $this->Brand->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Brand) {
                    $this->BrandID = $Brand[$this->inv['flip']['BrandID']];
                    $this->SellerID = $Brand[$this->inv['flip']['SellerID']];
                    $this->Name = $Brand[$this->inv['flip']['Name']];
                    $this->TitleUnFeature = $Brand[$this->inv['flip']['TitleUnFeature']];
                    $this->Note = $Brand[$this->inv['flip']['Note']];
                    $this->About = $Brand[$this->inv['flip']['About']];
                    $this->Mode = $Brand[$this->inv['flip']['Mode']];
                    $this->ShowOnHeader = $Brand[$this->inv['flip']['ShowOnHeader']];

                    if($Brand[$this->inv['flip']['Logo']])
                        $this->Logo = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'medium_'.$Brand[$this->inv['flip']['Logo']]; 
                    
                    if($Brand[$this->inv['flip']['Banner']])
                        $this->Banner = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'small_'.$Brand[$this->inv['flip']['Banner']]; 
                    
                    if($Brand[$this->inv['flip']['Icon']])
                        $this->Icon = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'small_'.$Brand[$this->inv['flip']['Icon']]; 

                    if($Brand[$this->inv['flip']['LicenseFile']])
                        $this->LicenseFile = $this->inv['basesite'].str_replace('/resources/', '', $this->pathfile).
                    $Brand[$this->inv['flip']['LicenseFile']]; 

                    $this->LicenseSell = $Brand[$this->inv['flip']['LicenseSell']];
                    $this->MainCategory = json_decode($Brand[$this->inv['flip']['MainCategory']]);
                    $this->HolidayMode = $Brand[$this->inv['flip']['HolidayMode']];
                    $this->Favorite = $Brand[$this->inv['flip']['Favorite']];
                    $this->IsActive = $Brand[$this->inv['flip']['IsActive']];
                    $this->Status = $Brand[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Brand[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Brand[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Brand[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Brand[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $Brand[$this->inv['flip']['permalink']];

                    $this->_loaddbclass([ 'BrandDetailStyle' ]);

                    $this->StyleList = $this->BrandDetailStyle->where([['BrandID','=',$Brand[$this->inv['flip']['BrandID']]]])->pluck('StyleID')->toArray();
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
        $this->_loaddbclass([ 'Seller', 'Category', 'Brand', 'Style', 'BrandDetailStyle' ]);

        if (isset($request['addnew']) || isset($request['edit'])) {
            if(isset($request['edit'])) {
                $Brand = $this->Brand->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Brand) {
                    $this->_redirect('404');
                }
            }

            $this->SellerID = $request['SellerID'];
            if(empty($this->SellerID)) {
                $this->errorSellerID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.SellerID')]
                );
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.Name')]
                );
            }

            $Brand = $this->Brand->where([[$this->inv['flip']['Name'],'=',$this->Name],['Status','=',0]])->first();

            if($Brand) {
                if(isset($request['addnew']) && strtoupper($Brand[$this->inv['flip']['Name']]) == strtoupper($this->Name)) {
                    if(!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.Brand.Name')]
                        );
                    }
                } else {
                    if ($Brand[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.Brand.Name')]
                            );
                        }
                    }
                }
            }

            $this->About = $request['About'];
            $this->ShowOnHeader = $request['ShowOnHeader'];

            if(isset($requestfile['Logo'])) $this->Logo = $requestfile['Logo'];
            else $this->Logo = '';
            if(empty($this->Logo) && !(isset($request['edit']) && $Brand[$this->inv['flip']['Logo']])) {
                $this->errorLogo = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.Logo')]
                );
            }
            if($this->Logo && !$this->_checkimage($this->Logo, $this->Logofiletype)) {
                $this->errorLogo = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.Logo')]
                );
            }

            if(isset($requestfile['Banner'])) $this->Banner = $requestfile['Banner'];
            else $this->Banner = '';
            if(empty($this->Banner) && !(isset($request['edit']) && $Brand[$this->inv['flip']['Banner']])) {
                $this->errorBanner = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.Banner')]
                );
            }
            if($this->Banner && !$this->_checkimage($this->Banner, $this->Bannerfiletype)) {
                $this->errorBanner = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.Banner')]
                );
            }

            $this->Mode = $request['Mode'];
            $this->TitleUnFeature = $request['TitleUnFeature'];
            $this->Note = $request['Note'];
            $this->HolidayMode = $request['HolidayMode'];

            if(isset($requestfile['Icon'])) $this->Icon = $requestfile['Icon'];
            else $this->Icon = '';
            if(empty($this->Icon) && !(isset($request['edit']) && $Brand[$this->inv['flip']['Icon']])) {
                $this->errorIcon = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.Icon')]
                );
            }
            if($this->Icon && !$this->_checkimage($this->Icon, $this->Iconfiletype)) {
                $this->errorIcon = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.Icon')]
                );
            }

            if(isset($request['MainCategory'])) $this->MainCategory = $request['MainCategory'];
            else {
                $this->errorMainCategory = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.MainCategory')]
                );
            }

            if(isset($request['LicenseSell'])) $this->LicenseSell = $request['LicenseSell'];
            
            if(isset($request['LicenseSell'])) {
                if(isset($requestfile['LicenseFile'])) $this->LicenseFile = $requestfile['LicenseFile'];
                else $this->LicenseFile = '';
                if(empty($this->LicenseFile) && !(isset($request['edit']) && $Brand[$this->inv['flip']['LicenseFile']])) {
                    $this->errorLicenseFile = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.masterdata.Brand.LicenseFile')]
                    );
                }
                if($this->LicenseFile && !$this->_checkfile($this->LicenseFile, $this->LicenseFilefiletype)) {
                    $this->errorLicenseFile = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.masterdata.Brand.LicenseFile')]
                    );
                }
            }

            if(isset($request['StyleList'])) $this->StyleList = $request['StyleList'];
            else {
                $this->errorStyleList = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.StyleList')]
                );
            }

            //handling error
            if(!$this->inv['messageerror'] && !$this->errorBrandID && !$this->errorSellerID && !$this->errorName && !$this->errorLogo && !$this->errorBanner && !$this->errorIcon && !$this->errorMainCategory && !$this->errorLicenseSell && !$this->errorStyleList && !$this->errorLicenseFile && !$this->errorHolidayMode && !$this->errorFavorite && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {

                $array = array(
                    $this->inv['flip']['SellerID'] => $this->SellerID,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['TitleUnFeature'] => $this->TitleUnFeature,
                    $this->inv['flip']['Note'] => $this->Note,
                    $this->inv['flip']['MainCategory'] => json_encode($this->MainCategory),
                    $this->inv['flip']['Mode'] => $this->Mode,
                    $this->inv['flip']['About'] => $this->About,
                    $this->inv['flip']['ShowOnHeader'] => $this->ShowOnHeader,
                    $this->inv['flip']['LicenseSell'] => $this->LicenseSell,
                    $this->inv['flip']['HolidayMode'] => $this->HolidayMode,
                    $this->inv['flip']['permalink'] => $this->_permalink($this->Name),
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $Brand = $this->Brand->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Brand = $this->Brand->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Brand->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                if($this->Logo) {
                    $LogoName = 'Logo_'.$Brand[$this->inv['flip']['BrandID']].$this->Logofiletype;
                    $array[$this->inv['flip']['Logo']] = $LogoName;
                    $Brand->update($array);
                    list($width, $height) = getimagesize($this->Logo->GetPathName());
                    $this->_imagetofolderratio($this->Logo, base_path().$this->pathimage, $LogoName, $width, $height);
                    $this->_imagetofolderratio($this->Logo, base_path().$this->pathimage, 'medium_'.$LogoName, $width / 3, $height / 3);
                    $this->_imagetofolderratio($this->Logo, base_path().$this->pathimage, 'small_'.$LogoName, $width / 6, $height / 6);
                }

                if($this->Banner) {
                    $BannerName = 'Banner_'.$Brand[$this->inv['flip']['BrandID']].$this->Bannerfiletype;
                    $array[$this->inv['flip']['Banner']] = $BannerName;
                    $Brand->update($array);
                    list($width, $height) = getimagesize($this->Banner->GetPathName());
                    $this->_imagetofolderratio($this->Banner, base_path().$this->pathimage, $BannerName, $width, $height);
                    $this->_imagetofolderratio($this->Banner, base_path().$this->pathimage, 'medium_'.$BannerName, $width / 3, $height / 3);
                    $this->_imagetofolderratio($this->Banner, base_path().$this->pathimage, 'small_'.$BannerName, $width / 6, $height / 6);
                }

                if($this->Icon) {
                    $IconName = 'Icon_'.$Brand[$this->inv['flip']['BrandID']].$this->Iconfiletype;
                    $array[$this->inv['flip']['Icon']] = $IconName;
                    $Brand->update($array);
                    list($width, $height) = getimagesize($this->Icon->GetPathName());
                    $this->_imagetofolderratio($this->Icon, base_path().$this->pathimage, $IconName, $width, $height);
                    $this->_imagetofolderratio($this->Icon, base_path().$this->pathimage, 'medium_'.$IconName, $width / 3, $height / 3);
                    $this->_imagetofolderratio($this->Icon, base_path().$this->pathimage, 'small_'.$IconName, $width / 6, $height / 6);
                }

                if($this->LicenseFile) {
                    $LicenseFileName = 'LicenseFile_'.$Brand[$this->inv['flip']['BrandID']].$this->LicenseFilefiletype;
                    $array[$this->inv['flip']['LicenseFile']] = $LicenseFileName;
                    $Brand->update($array);
                    $this->_filetofolder($this->LicenseFile, base_path().$this->pathfile, $LicenseFileName);
                }

                foreach($this->BrandDetailStyle->where([[$this->inv['flip']['BrandID'],'=',$Brand[$this->inv['flip']['BrandID']]]])->get() as $obj) {
                    $obj->delete();
                }
                
                $array = [];
                foreach ($this->StyleList as $key) {
                    $array[] = [
                        'BrandID' => $Brand[$this->inv['flip']['BrandID']],
                        'StyleID' => $key
                    ];
                }

                $this->BrandDetailStyle->inserts($array);

                return $this->_redirect(get_class());
            }
        }
        
        $arrSeller = $this->Seller->where([['Status','=',0],['IsActive','=',1]])->get()->toArray();
        $this->inv['arrSeller'] = $arrSeller;

        $arrCategory = $this->Category->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrCategory'] = $arrCategory;

        $arrStyle = $this->Style->get()->toArray();
        $this->inv['arrStyle'] = $arrStyle;

        $arrHolidayMode = [
            0 => 'Non Active',
            1 => 'Active'
        ];
        $this->inv['arrHolidayMode'] = $arrHolidayMode;
        
        $arrShowOnHeader = [
            0 => 'Non Active',
            1 => 'Active'
        ];
        $this->inv['arrShowOnHeader'] = $arrShowOnHeader;

        $arrMainCategory = ['WOMEN', 'MEN','KIDS'];
        $this->inv['arrMainCategory'] = $arrMainCategory;
        
        $arrMode = [];
        if($this->SellerID) {
            $this->_loaddbclass(['Seller']);
            $Seller = $this->Seller->where([['ID','=',$this->SellerID]])->first();
            if($Seller) {
                if($Seller->SellerFetured == 0)
                    $arrMode = [
                        0 => 'Feature',
                        1 => 'Artist',
                        2 => 'Indie',
                    ];
                else
                    $arrMode = [
                        1 => 'Artist',
                        2 => 'Indie',
                    ];
            }
        }
        
        
        $this->inv['arrMode'] = $arrMode;

        $this->inv['BrandID'] = $this->BrandID; $this->inv['errorBrandID'] = $this->errorBrandID;
        $this->inv['SellerID'] = $this->SellerID; $this->inv['errorSellerID'] = $this->errorSellerID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['TitleUnFeature'] = $this->TitleUnFeature; $this->inv['errorTitleUnFeature'] = $this->errorTitleUnFeature;
        $this->inv['Note'] = $this->Note; $this->inv['errorNote'] = $this->errorNote;
        $this->inv['MainCategory'] = $this->MainCategory; $this->inv['errorMainCategory'] = $this->errorMainCategory;
        if(!$this->Mode) $this->Mode = 0;
        $this->inv['Mode'] = $this->Mode; $this->inv['errorMode'] = $this->errorMode;
        $this->inv['About'] = $this->About; $this->inv['errorAbout'] = $this->errorAbout;
        if(!$this->ShowOnHeader) $this->ShowOnHeader = 1;
        $this->inv['ShowOnHeader'] = $this->ShowOnHeader; $this->inv['errorShowOnHeader'] = $this->errorShowOnHeader;
        $this->inv['Logo'] = $this->Logo; $this->inv['errorLogo'] = $this->errorLogo;
        $this->inv['Banner'] = $this->Banner; $this->inv['errorBanner'] = $this->errorBanner;
        $this->inv['Icon'] = $this->Icon; $this->inv['errorIcon'] = $this->errorIcon;
        $this->inv['LicenseSell'] = $this->LicenseSell; $this->inv['errorLicenseSell'] = $this->errorLicenseSell;
        $this->inv['MainCategory'] = $this->MainCategory; $this->inv['errorMainCategory'] = $this->errorMainCategory;
        $this->inv['LicenseFile'] = $this->LicenseFile; $this->inv['errorLicenseFile'] = $this->errorLicenseFile;
        if(!$this->HolidayMode) $this->HolidayMode = 1;
        $this->inv['HolidayMode'] = $this->HolidayMode; $this->inv['errorHolidayMode'] = $this->errorHolidayMode;
        $this->inv['Favorite'] = $this->Favorite; $this->inv['errorFavorite'] = $this->errorFavorite;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;
        $this->inv['StyleList'] = $this->StyleList; $this->inv['errorStyleList'] = $this->errorStyleList;

        return $this->_showview(["new"]);
    }

    private function views($views = ["defaultview"]) {
        $arrMode = [
            0 => 'Feature',
            1 => 'Artist',
            2 => 'Indie',
        ];

        $this->_loaddbclass([ 'Seller','Brand' ]);

        $result = $this->Brand->leftJoin([
            ['seller','seller.ID','=','brand.SellerID'],
        ])->select([
            'seller.FullName as NameSeller',
            'brand.*'
        ]);

        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        if($Seller) {
            $result = $result->where([['brand.SellerID', '=', $Seller->ID]]);
        }

        $result = $result->where([['brand.Status','=',0],['seller.IsActive','=',1],['seller.Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        $this->inv['flip']['NameSeller'] = 'seller.FullName';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['NameSeller'] = 'NameSeller';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                if ($result['data'][$i][$this->inv['flip']['Icon']]) {
                    $result['data'][$i][$this->inv['flip']['Icon']] = '<img src="' . $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) .
                        'small_' . $result['data'][$i][$this->inv['flip']['Icon']] . '">';
                }

                $result['data'][$i][$this->inv['flip']['Mode']] = $arrMode[$result['data'][$i][$this->inv['flip']['Mode']]];

                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['BrandID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';

                $check = '';
                if($result['data'][$i][$this->inv['flip']['ShowOnHeader']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['ShowOnHeader']] = '<input type="checkbox" data-size="small" class="make-switch SetOnHeader '.$result['data'][$i][$this->inv['flip']['BrandID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['ShowOnHeader'][0]]).'">';

                $check = '';
                if($result['data'][$i][$this->inv['flip']['HolidayMode']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['HolidayMode']] = '<input type="checkbox" data-size="small" class="make-switch HolidayMode '.$result['data'][$i][$this->inv['flip']['BrandID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['HolidayMode'][0]]).'">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}