<?php

namespace App\Modules\dashboard\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class configurationsettingsController extends Controller
{
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
        'ID' => 'SettingID',
        'BannerWomen' => 'BannerWomen',
        'TextWomen' => 'TextWomen',
        'BannerMen' => 'BannerMen',
        'TextMen' => 'TextMen',
        'BannerKids' => 'BannerKids',
        'TextKids' => 'TextKids',
        'BannerLabels' => 'BannerLabels',
        'TextLabels' => 'TextLabels',
        'SubscribeAmount' => 'SubscribeAmount',
        'UpdatedDate' => 'UpdatedDate',
        'UpdatedBy' => 'UpdatedBy',
        'idfunction' => 'ID',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'SettingID' => ['Setting ID'],
        'BannerWomen' => ['Banner Women', true, 'image'],
        'TextWomen' => ['Text Women'],
        'BannerMen' => ['Banner Men', true, 'image'],
        'TextMen' => ['Text Men'],
        'BannerKids' => ['Banner Kids', true, 'image'],
        'TextKids' => ['Text Kids'],
        'BannerLabels' => ['Banner Labels', true, 'image'],
        'TextLabels' => ['Text Labels'],
        'SubscribeAmount' => ['Subscribe Amount', true],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/settings/';
    var $objectkey = '', $SettingID = '', $errorSettingID = '', $BannerWomen = '', $errorBannerWomen = '', $BannerWomenfiletype = '', $TextWomen = '', $errorTextWomen = '', $BannerMen = '', $errorBannerMen = '', $BannerMenfiletype = '', $TextMen = '', $errorTextMen = '', $BannerKids = '', $errorBannerKids = '', $BannerKidsfiletype = '', $TextKids = '', $errorTextKids = '', $BannerLabels = '', $errorBannerLabels = '', $BannerLabelsfiletype = '', $TextLabels = '', $errorTextLabels = '', $SubscribeAmount = '', $errorSubscribeAmount = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';    
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        $id = $request['value'];
        $this->_loaddbclass([ 'Setting' ]);
        $Setting = $this->Setting->where([['ID', '=', $id]])->first();

        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'deleteBannerWomen' :
                    if($Setting[$this->inv['flip']['BannerWomen']]) {
                        @unlink(base_path().$this->pathimage.$Setting[$this->inv['flip']['BannerWomen']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Setting[$this->inv['flip']['BannerWomen']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Setting[$this->inv['flip']['BannerWomen']]);
                        $Setting->update([$this->inv['flip']['BannerWomen'] => '']);
                    }
                break;
                case 'deleteBannerMen' :
                    if($Setting[$this->inv['flip']['BannerMen']]) {
                        @unlink(base_path().$this->pathimage.$Setting[$this->inv['flip']['BannerMen']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Setting[$this->inv['flip']['BannerMen']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Setting[$this->inv['flip']['BannerMen']]);
                        $Setting->update([$this->inv['flip']['BannerMen'] => '']);
                    }
                break;
                case 'deleteBannerKids' :
                    if($Setting[$this->inv['flip']['BannerKids']]) {
                        @unlink(base_path().$this->pathimage.$Setting[$this->inv['flip']['BannerKids']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Setting[$this->inv['flip']['BannerKids']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Setting[$this->inv['flip']['BannerKids']]);
                        $Setting->update([$this->inv['flip']['BannerKids'] => '']);
                    }
                break;
                case 'deleteBannerLabels' :
                    if($Setting[$this->inv['flip']['BannerLabels']]) {
                        @unlink(base_path().$this->pathimage.$Setting[$this->inv['flip']['BannerLabels']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Setting[$this->inv['flip']['BannerLabels']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Setting[$this->inv['flip']['BannerLabels']]);
                        $Setting->update([$this->inv['flip']['BannerLabels'] => '']);
                    }
                break;
            }
        }
    }

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->addnewedit();
    }
    
    public function addnew()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->addnewedit();
    }

    private function getdata() {
        $this->_loaddbclass([ 'Setting' ]);

        $Setting = $this->Setting->where([[$this->objectkey,'=',1]])->first();
        if($Setting) {
            $this->SettingID = $Setting[$this->inv['flip']['SettingID']];
            if($Setting[$this->inv['flip']['BannerWomen']])
                $this->BannerWomen = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).'medium_'.$Setting[$this->inv['flip']['BannerWomen']];
            $this->TextWomen = $Setting[$this->inv['flip']['TextWomen']];
            if($Setting[$this->inv['flip']['BannerMen']])
                $this->BannerMen = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).'medium_'.$Setting[$this->inv['flip']['BannerMen']];
            $this->TextMen = $Setting[$this->inv['flip']['TextMen']];
            if($Setting[$this->inv['flip']['BannerKids']])
                $this->BannerKids = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).'medium_'.$Setting[$this->inv['flip']['BannerKids']];
            $this->TextKids = $Setting[$this->inv['flip']['TextKids']];
            if($Setting[$this->inv['flip']['BannerLabels']])
                $this->BannerLabels = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).'medium_'.$Setting[$this->inv['flip']['BannerLabels']];
            $this->TextLabels = $Setting[$this->inv['flip']['TextLabels']];
            $this->SubscribeAmount = $Setting[$this->inv['flip']['SubscribeAmount']];
            $this->UpdatedDate = $Setting[$this->inv['flip']['UpdatedDate']];
            $this->UpdatedBy = $Setting[$this->inv['flip']['UpdatedBy']];
        } else {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        }
    }

    private function addnewedit() {
        $request = \Request::instance()->request->all();
        $requestfile = \Request::file();

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([ 'Setting' ]);

            $Setting = $this->Setting->where([[$this->objectkey,'=',1]])->first();
            if(!$Setting) {
                $this->_redirect('404');
            }

            if(isset($requestfile['BannerWomen'])) $this->BannerWomen = $requestfile['BannerWomen'];
            else $this->BannerWomen = '';
            if($this->BannerWomen && !$this->_checkimage($this->BannerWomen, $this->BannerWomenfiletype)) {
                $this->errorBannerWomen = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.settings.configurationsettings.BannerWomen')]
                );
            }

            $this->TextWomen = $request['TextWomen'];
            if(empty($this->TextWomen)) {
                $this->errorTextWomen = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.settings.configurationsettings.TextWomen')]
                );
            }

            if(isset($requestfile['BannerMen'])) $this->BannerMen = $requestfile['BannerMen'];
            else $this->BannerMen = '';
            if($this->BannerMen && !$this->_checkimage($this->BannerMen, $this->BannerMenfiletype)) {
                $this->errorBannerMen = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.settings.configurationsettings.BannerMen')]
                );
            }

            $this->TextMen = $request['TextMen'];
            if(empty($this->TextMen)) {
                $this->errorTextMen = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.settings.configurationsettings.TextMen')]
                );
            }

            if(isset($requestfile['BannerKids'])) $this->BannerKids = $requestfile['BannerKids'];
            else $this->BannerKids = '';
            if($this->BannerKids && !$this->_checkimage($this->BannerKids, $this->BannerKidsfiletype)) {
                $this->errorBannerKids = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.settings.configurationsettings.BannerKids')]
                );
            }

            $this->TextKids = $request['TextKids'];
            if(empty($this->TextKids)) {
                $this->errorTextKids = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.settings.configurationsettings.TextKids')]
                );
            }

            if(isset($requestfile['BannerLabels'])) $this->BannerLabels = $requestfile['BannerLabels'];
            else $this->BannerLabels = '';
            if($this->BannerLabels && !$this->_checkimage($this->BannerLabels, $this->BannerLabelsfiletype)) {
                $this->errorBannerLabels = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.settings.configurationsettings.BannerLabels')]
                );
            }

            $this->TextLabels = $request['TextLabels'];
            if(empty($this->TextLabels)) {
                $this->errorTextLabels = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.settings.configurationsettings.TextLabels')]
                );
            }

            $this->SubscribeAmount = $request['SubscribeAmount'];
            if(empty($this->SubscribeAmount)) {
                $this->errorSubscribeAmount = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.settings.configurationsettings.SubscribeAmount')]
                );
            }

            if(!$this->inv['messageerror'] && !$this->errorSettingID && !$this->errorBannerWomen && !$this->errorTextWomen && !$this->errorBannerMen && !$this->errorTextMen && !$this->errorBannerKids && !$this->errorTextKids && !$this->errorBannerLabels && !$this->errorTextLabels && !$this->errorSubscribeAmount && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];

                $array = array(
                    $this->inv['flip']['SettingID'] => $this->SettingID,
                    $this->inv['flip']['TextWomen'] => $this->TextWomen,
                    $this->inv['flip']['TextMen'] => $this->TextMen,
                    $this->inv['flip']['TextKids'] => $this->TextKids,
                    $this->inv['flip']['TextLabels'] => $this->TextLabels,
                    $this->inv['flip']['SubscribeAmount'] => $this->SubscribeAmount,
                    $this->inv['flip']['UpdatedDate'] => new \DateTime("now"),
                    $this->inv['flip']['UpdatedBy'] => $userid,
                );

                $Setting = $this->Setting->where([[$this->objectkey,'=',1]])->first();
                $Setting->update($array);

                if($this->BannerWomen) {
                    $ImageName = 'BannerWomen_'.$Setting[$this->inv['flip']['SettingID']].$this->BannerWomenfiletype;
                    $array[$this->inv['flip']['BannerWomen']] = $ImageName;
                    $Setting->update($array);
                    $width = 1200;
                    $height = 340;
                    $this->_imagetofolder($this->BannerWomen, base_path().$this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->BannerWomen, base_path().$this->pathimage, 'medium_'.$ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->BannerWomen, base_path().$this->pathimage, 'small_'.$ImageName, $width / 6, $height / 6);
                }

                if($this->BannerMen) {
                    $ImageName = 'BannerMen_'.$Setting[$this->inv['flip']['SettingID']].$this->BannerMenfiletype;
                    $array[$this->inv['flip']['BannerMen']] = $ImageName;
                    $Setting->update($array);
                    $width = 1200;
                    $height = 340;
                    $this->_imagetofolder($this->BannerMen, base_path().$this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->BannerMen, base_path().$this->pathimage, 'medium_'.$ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->BannerMen, base_path().$this->pathimage, 'small_'.$ImageName, $width / 6, $height / 6);
                }

                if($this->BannerKids) {
                    $ImageName = 'BannerKids_'.$Setting[$this->inv['flip']['SettingID']].$this->BannerKidsfiletype;
                    $array[$this->inv['flip']['BannerKids']] = $ImageName;
                    $Setting->update($array);
                    $width = 1200;
                    $height = 340;
                    $this->_imagetofolder($this->BannerKids, base_path().$this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->BannerKids, base_path().$this->pathimage, 'medium_'.$ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->BannerKids, base_path().$this->pathimage, 'small_'.$ImageName, $width / 6, $height / 6);
                }

                if($this->BannerLabels) {
                    $ImageName = 'BannerLabels_'.$Setting[$this->inv['flip']['SettingID']].$this->BannerLabelsfiletype;
                    $array[$this->inv['flip']['BannerLabels']] = $ImageName;
                    $Setting->update($array);
                    $width = 1200;
                    $height = 340;
                    $this->_imagetofolder($this->BannerLabels, base_path().$this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->BannerLabels, base_path().$this->pathimage, 'medium_'.$ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->BannerLabels, base_path().$this->pathimage, 'small_'.$ImageName, $width / 6, $height / 6);
                }

                $this->_dblog('edit', $this, "Configuration Settings");
                $this->inv['messagesuccess'] = "Update Configuration Settings Completed !";
            }
        }

        $this->getdata();

        $this->inv['SettingID'] = $this->SettingID; $this->inv['errorSettingID'] = $this->errorSettingID;
        $this->inv['BannerWomen'] = $this->BannerWomen; $this->inv['errorBannerWomen'] = $this->errorBannerWomen;
        $this->inv['TextWomen'] = $this->TextWomen; $this->inv['errorTextWomen'] = $this->errorTextWomen;
        $this->inv['BannerMen'] = $this->BannerMen; $this->inv['errorBannerMen'] = $this->errorBannerMen;
        $this->inv['TextMen'] = $this->TextMen; $this->inv['errorTextMen'] = $this->errorTextMen;
        $this->inv['BannerKids'] = $this->BannerKids; $this->inv['errorBannerKids'] = $this->errorBannerKids;
        $this->inv['TextKids'] = $this->TextKids; $this->inv['errorTextKids'] = $this->errorTextKids;
        $this->inv['BannerLabels'] = $this->BannerLabels; $this->inv['errorBannerLabels'] = $this->errorBannerLabels;
        $this->inv['TextLabels'] = $this->TextLabels; $this->inv['errorTextLabels'] = $this->errorTextLabels;
        $this->inv['SubscribeAmount'] = $this->SubscribeAmount; $this->inv['errorSubscribeAmount'] = $this->errorSubscribeAmount;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;

        return $this->_showview(["new"]);
    }
}