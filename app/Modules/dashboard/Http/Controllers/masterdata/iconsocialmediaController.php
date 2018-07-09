<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class iconsocialmediaController extends Controller
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
        'ID' => 'IconSocialMediaID',
        'Name' => 'Name',
        'Image' => 'Image',
        'ImageHover' => 'ImageHover',
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
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'IconSocialMediaID' => ['Icon Social Media ID'],
        'Name' => ['Name', true],
        'Image' => ['Image', true, '', 'image'],
        'ImageHover' => ['Image Hover', true, '', 'image'],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/iconsocialmedia/';
    var $objectkey = '', $IconSocialMediaID = '', $errorIconSocialMediaID = '', $Name = '', $errorName = '', $Image = '', $errorImage = '', $ImageHover = '', $errorImageHover = '', $Imagefiletype = '', $ImageHoverfiletype = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    $id = $request['value'];

                    $this->_loaddbclass([ 'IconSocialMedia' ]);
                    $IconSocialMedia = $this->IconSocialMedia->where([['ID','=',$id]])->first();

                    if($IconSocialMedia) {
                        $this->Name = $IconSocialMedia[$this->inv['flip']['Name']];

                        $IsActive = 1;
                        if($IconSocialMedia->IsActive == 1) $IsActive = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];
                        
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $IconSocialMedia->update($array);

                        if($IsActive) $IsActive = 'Active';
                        else $IsActive = 'Non Active';

                        $this->_dblog('edit', $this, 'Set '.$IsActive.' '.$this->Name);

                        die('OK');
                    } else die('Error');
                break;
                case 'deleteImage':
                    $id = $request['value'];

                    $this->_loaddbclass([ 'IconSocialMedia' ]);
                    $IconSocialMedia = $this->IconSocialMedia->where([['ID','=',$id]])->first();

                    if ($IconSocialMedia[$this->inv['flip']['Image']]) {
                        @unlink(base_path() . $this->pathimage . $IconSocialMedia[$this->inv['flip']['Image']]);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $IconSocialMedia[$this->inv['flip']['Image']]);
                        @unlink(base_path() . $this->pathimage . 'small_' . $IconSocialMedia[$this->inv['flip']['Image']]);
                        $IconSocialMedia->update([$this->inv['flip']['Image'] => '']);
                    }
                break;
                case 'deleteImageHover':
                    $id = $request['value'];

                    $this->_loaddbclass([ 'IconSocialMedia' ]);
                    $IconSocialMedia = $this->IconSocialMedia->where([['ID','=',$id]])->first();

                    if ($IconSocialMedia[$this->inv['flip']['ImageHover']]) {
                        @unlink(base_path() . $this->pathimage . $IconSocialMedia[$this->inv['flip']['ImageHover']]);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $IconSocialMedia[$this->inv['flip']['ImageHover']]);
                        @unlink(base_path() . $this->pathimage . 'small_' . $IconSocialMedia[$this->inv['flip']['ImageHover']]);
                        $IconSocialMedia->update([$this->inv['flip']['ImageHover'] => '']);
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
                $this->_loaddbclass([ 'IconSocialMedia' ]);

                $IconSocialMedia = $this->IconSocialMedia->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($IconSocialMedia) {
                    $this->IconSocialMediaID = $IconSocialMedia[$this->inv['flip']['IconSocialMediaID']];
                    $this->Name = $IconSocialMedia[$this->inv['flip']['Name']];

                    if ($IconSocialMedia[$this->inv['flip']['Image']]) {
                        $this->Image = $this->inv['basesite'] . str_replace('/resources/', '', $this->pathimage) .
                                        $IconSocialMedia[$this->inv['flip']['Image']];
                    }

                    if ($IconSocialMedia[$this->inv['flip']['ImageHover']]) {
                        $this->ImageHover = $this->inv['basesite'] . str_replace('/resources/', '', $this->pathimage) .
                                        $IconSocialMedia[$this->inv['flip']['ImageHover']];
                    }

                    $this->IsActive = $IconSocialMedia[$this->inv['flip']['IsActive']];
                    $this->Status = $IconSocialMedia[$this->inv['flip']['Status']];
                    $this->CreatedDate = $IconSocialMedia[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $IconSocialMedia[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $IconSocialMedia[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $IconSocialMedia[$this->inv['flip']['UpdatedBy']];
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
            $this->_loaddbclass([ 'IconSocialMedia' ]);

            if(isset($request['edit'])) {
                $IconSocialMedia = $this->IconSocialMedia->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$IconSocialMedia) {
                    $this->_redirect('404');
                }
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.IconSocialMedia.Name')]
                );
            }

            $IconSocialMedia = $this->IconSocialMedia->where([[$this->inv['flip']['Name'], '=', $this->Name],['Status','=',0]])->first();

            if ($IconSocialMedia) {
                if (isset($request['addnew']) && strtoupper($IconSocialMedia[$this->inv['flip']['Name']]) == strtoupper($this->Name)) {
                    if (!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already',
                            ['value' => $this->_trans('dashboard.masterdata.IconSocialMedia.Name')]
                        );
                    }
                } else {
                    if ($IconSocialMedia[$this->objectkey] != $this->inv['getid']) {
                        if (!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already',
                                ['value' => $this->_trans('dashboard.masterdata.IconSocialMedia.Name')]
                            );
                        }
                    }
                }
            }

            if(isset($requestfile['Image'])) $this->Image = $requestfile['Image'];
            else $this->Image = '';
            if(empty($this->Image) && !(isset($request['edit']) && $IconSocialMedia[$this->inv['flip']['Image']])) {
                $this->errorImage = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.IconSocialMedia.Image')]
                );
            }
            if($this->Image && !$this->_checkimage($this->Image, $this->Imagefiletype)) {
                $this->errorImage = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.IconSocialMedia.Image')]
                );
            }

            if(isset($requestfile['ImageHover'])) $this->ImageHover = $requestfile['ImageHover'];
            else $this->ImageHover = '';
            if(empty($this->ImageHover) && !(isset($request['edit']) && $IconSocialMedia[$this->inv['flip']['ImageHover']])) {
                $this->errorImageHover = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.IconSocialMedia.ImageHover')]
                );
            }
            if($this->ImageHover && !$this->_checkimage($this->ImageHover, $this->ImageHoverfiletype)) {
                $this->errorImageHover = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.IconSocialMedia.ImageHover')]
                );
            }

            if(!$this->inv['messageerror'] && !$this->errorIconSocialMediaID && !$this->errorName && !$this->errorImage && !$this->errorImageHover && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {

                $array = array(
                    $this->inv['flip']['IconSocialMediaID'] => $this->IconSocialMediaID,
                    $this->inv['flip']['Name'] => $this->Name,
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    
                    $IconSocialMedia = $this->IconSocialMedia->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $IconSocialMedia = $this->IconSocialMedia->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $IconSocialMedia->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                if ($this->Image) {
                    $ImageName = 'image_' . $IconSocialMedia[$this->inv['flip']['IconSocialMediaID']] . $this->Imagefiletype;
                    $array[$this->inv['flip']['Image']] = $ImageName;
                    $IconSocialMedia->update($array);
                    list($width, $height) = getimagesize($this->Image->GetPathName());

                    $this->_imagetofolder($this->Image, base_path() . $this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->Image, base_path() . $this->pathimage, 'medium_' . $ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Image, base_path() . $this->pathimage, 'small_' . $ImageName, $width / 6, $height / 6);
                }

                if ($this->ImageHover) {
                    $ImageName = 'image_hover_' . $IconSocialMedia[$this->inv['flip']['IconSocialMediaID']] . $this->ImageHoverfiletype;
                    $array[$this->inv['flip']['ImageHover']] = $ImageName;
                    $IconSocialMedia->update($array);
                    list($width, $height) = getimagesize($this->ImageHover->GetPathName());

                    $this->_imagetofolder($this->ImageHover, base_path() . $this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->ImageHover, base_path() . $this->pathimage, 'medium_' . $ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->ImageHover, base_path() . $this->pathimage, 'small_' . $ImageName, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['IconSocialMediaID'] = $this->IconSocialMediaID; $this->inv['errorIconSocialMediaID'] = $this->errorIconSocialMediaID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['Image'] = $this->Image; $this->inv['errorImage'] = $this->errorImage;
        $this->inv['ImageHover'] = $this->ImageHover; $this->inv['errorImageHover'] = $this->errorImageHover;
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
            $this->_loaddbclass(['IconSocialMedia']);

            foreach($this->inv['delete'] as $val) {
                $IconSocialMedia = $this->IconSocialMedia->where([[$this->objectkey,'=',$val]])->first();
                if($IconSocialMedia) {
                    $this->Name = $IconSocialMedia[$this->inv['flip']['Name']];
                    
                    if ($IconSocialMedia->Image) {
                        @unlink(base_path() . $this->pathimage . $IconSocialMedia->Image);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $IconSocialMedia->Image);
                        @unlink(base_path() . $this->pathimage . 'small_' . $IconSocialMedia->Image);
                    }

                    if ($IconSocialMedia->ImageHover) {
                        @unlink(base_path() . $this->pathimage . $IconSocialMedia->ImageHover);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $IconSocialMedia->ImageHover);
                        @unlink(base_path() . $this->pathimage . 'small_' . $IconSocialMedia->ImageHover);
                    }

                    $array[$this->inv['flip']['Status']] = 1;
                    $IconSocialMedia->update($array);

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
        $this->_loaddbclass([ 'IconSocialMedia' ]);

        $result = $this->IconSocialMedia->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                if ($result['data'][$i][$this->inv['flip']['Image']]) {
                    $result['data'][$i][$this->inv['flip']['Image']] =
                    $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) . $result['data'][$i][$this->inv['flip']['Image']];
                }
                
                if ($result['data'][$i][$this->inv['flip']['ImageHover']]) {
                    $result['data'][$i][$this->inv['flip']['ImageHover']] =
                    $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) . $result['data'][$i][$this->inv['flip']['ImageHover']];
                }

                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                    $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['IconSocialMediaID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';
            }
            $this->_setdatapaginate($result);
        }
    
        return $this->_showview($views);
    }
}