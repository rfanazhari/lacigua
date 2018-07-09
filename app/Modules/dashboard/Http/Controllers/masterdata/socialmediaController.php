<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class socialmediaController extends Controller
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
        'ID'          => 'SocialMediaID',
        'Name'        => 'Name',
        'IconSocialMediaID' => 'IconSocialMediaID',
        'IconSocialMediaImage' => 'IconSocialMediaImage',
        'Link'        => 'Link',
        'IsActive'    => 'IsActive',
        'Status'      => 'Status',
        'CreatedDate' => 'CreatedDate',
        'CreatedBy'   => 'CreatedBy',
        'UpdatedDate' => 'UpdatedDate',
        'UpdatedBy'   => 'UpdatedBy',
        'permalink'   => 'permalink',
    ];

    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'SocialMediaID' => ['Social Media ID'],
        'Name'          => ['Social Media Name', true],
        'Link'          => ['Link', true],
        'IsActive'      => ['Is Active', true],
        'Status'        => ['Status'],
        'CreatedDate'   => ['Created Date'],
        'CreatedBy'     => ['Created By'],
        'UpdatedDate'   => ['Update Date'],
        'UpdatedBy'     => ['Update By'],
        'permalink'     => ['Permalink'],
        'IconSocialMediaID' => ['Icon Social Media'],
        'IconSocialMediaImage' => ['Icon Social Media', true, '', 'image'],
    ];

    public $objectkey = '', $SocialMediaID = '', $errorSocialMediaID = '', $Name = '', $errorName = '', $IconSocialMediaID = '', $errorIconSocialMediaID = '', $Link = '', $errorLink = '', $Status = '', $errorStatus = '', $IsActive = '', $errorIsActive = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) exit;

        $request = \Request::instance()->request->all();
        if (isset($request['ajaxpost'])) {
            switch ($request['ajaxpost']) {
                case 'setactive':
                    $id = $request['value'];

                    $this->_loaddbclass(['SocialMedia']);

                    $SocialMedia = $this->SocialMedia->where([['ID', '=', $id]])->first();

                    if ($SocialMedia) {
                        $IsActive = 1;
                        if ($SocialMedia->IsActive == 1) {
                            $IsActive = 0;
                        }

                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $SocialMedia->update($array);

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
                $this->_loaddbclass(['SocialMedia']);
                $SocialMedia = $this->SocialMedia->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if ($SocialMedia) {
                    $this->SocialMediaID = $SocialMedia[$this->inv['flip']['SocialMediaID']];
                    $this->Name          = $SocialMedia[$this->inv['flip']['Name']];
                    $this->IconSocialMediaID    = $SocialMedia[$this->inv['flip']['IconSocialMediaID']];
                    $this->Link          = $SocialMedia[$this->inv['flip']['Link']];
                    $this->IsActive      = $SocialMedia[$this->inv['flip']['IsActive']];
                    $this->Status        = $SocialMedia[$this->inv['flip']['Status']];
                    $this->CreatedDate   = $SocialMedia[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy     = $SocialMedia[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate   = $SocialMedia[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy     = $SocialMedia[$this->inv['flip']['UpdatedBy']];
                    $this->permalink     = $SocialMedia[$this->inv['flip']['permalink']];
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
            $this->_loaddbclass(['SocialMedia']);

            if (isset($request['edit'])) {
                $SocialMedia = $this->SocialMedia->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if (!$SocialMedia) {
                    $this->_redirect('404');
                }
            }

            $this->Name = $request['Name'];
            if (empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.SocialMedia.Name')]
                );
            }

            $SocialMedia = $this->SocialMedia->where([[$this->inv['flip']['Name'], '=', $this->Name],['Status','=',0]])->first();

            if ($SocialMedia) {
                if (isset($request['addnew']) && strtoupper($SocialMedia[$this->inv['flip']['Name']]) == strtoupper($this->Name)) {
                    if (!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already',
                            ['value' => $this->_trans('dashboard.masterdata.SocialMedia.Name')]
                        );
                    }
                } else {
                    if ($SocialMedia[$this->objectkey] != $this->inv['getid']) {
                        if (!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already',
                                ['value' => $this->_trans('dashboard.masterdata.SocialMedia.Name')]
                            );
                        }
                    }
                }
            }

            $this->IconSocialMediaID = $request['IconSocialMediaID'];
            if (empty($this->IconSocialMediaID)) {
                $this->errorIconSocialMediaID = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.SocialMedia.IconSocialMediaID')]
                );
            }

            $this->Link = $request['Link'];
            if (empty($this->Link)) {
                $this->errorLink = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.SocialMedia.Link')]
                );
            }

            if (!$this->inv['messageerror'] && !$this->errorSocialMediaID && !$this->errorName && !$this->errorIconSocialMediaID && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {
                $array = array(
                    $this->inv['flip']['SocialMediaID'] => $this->SocialMediaID,
                    $this->inv['flip']['Name']          => $this->Name,
                    $this->inv['flip']['IconSocialMediaID'] => $this->IconSocialMediaID,
                    $this->inv['flip']['Link']          => $this->Link,
                    $this->inv['flip']['permalink']     => $this->_permalink($this->Name),
                );

                $userdata = \Session::get('userdata');
                $userid   = $userdata['uuserid'];

                if (isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']]   = $userid;
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $SocialMedia = $this->SocialMedia->creates($array);

                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                    $SocialMedia = $this->SocialMedia->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                    $SocialMedia->update($array);

                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['SocialMediaID']      = $this->SocialMediaID;
        $this->inv['errorSocialMediaID'] = $this->errorSocialMediaID;
        $this->inv['Name']               = $this->Name;
        $this->inv['errorName']          = $this->errorName;
        $this->inv['IconSocialMediaID']         = $this->IconSocialMediaID;
        $this->inv['errorIconSocialMediaID']    = $this->errorIconSocialMediaID;
        $this->inv['Link']               = $this->Link;
        $this->inv['errorLink']          = $this->errorLink;
        $this->inv['IsActive']           = $this->IsActive;
        $this->inv['errorIsActive']      = $this->errorIsActive;
        $this->inv['Status']             = $this->Status;
        $this->inv['errorStatus']        = $this->errorStatus;
        $this->inv['CreatedDate']        = $this->CreatedDate;
        $this->inv['errorCreatedDate']   = $this->errorCreatedDate;
        $this->inv['CreatedBy']          = $this->CreatedBy;
        $this->inv['errorCreatedBy']     = $this->errorCreatedBy;
        $this->inv['UpdatedDate']        = $this->UpdatedDate;
        $this->inv['errorUpdatedDate']   = $this->errorUpdatedDate;
        $this->inv['UpdatedBy']          = $this->UpdatedBy;
        $this->inv['errorUpdatedBy']     = $this->errorUpdatedBy;
        $this->inv['permalink']          = $this->permalink;
        $this->inv['errorpermalink']     = $this->errorpermalink;

        $this->_loaddbclass(['IconSocialMedia']);

        $ArrIconSocialMedia = $this->IconSocialMedia->where([['IsActive','=',1],['Status','=',0]])->orderBy('Name')->get();
        $this->inv['ArrIconSocialMedia'] = $ArrIconSocialMedia;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) return $this->_redirect($url);

        if (isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass(['SocialMedia']);

            foreach ($this->inv['delete'] as $val) {
                $SocialMedia = $this->SocialMedia->where([[$this->objectkey, '=', $val]])->first();
                if ($SocialMedia) {

                    $this->Name = $SocialMedia[$this->inv['flip']['Name']];

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['permalink']] = '';
                    
                    $SocialMedia->update($array);

                    if (end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->Name);
                    $this->inv['messagesuccess'] .= "Delete $this->Name Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"])
    {
        $this->_loaddbclass(['SocialMedia']);

        $result = $this->SocialMedia->leftjoin([
            ['icon_social_media as icm', 'icm.ID', '=', 'social_media.IconSocialMediaID']
        ])->selectraw('
            icm.ID as IconSocialMediaID,
            icm.Image as IconSocialMediaImage,
            social_media.*
        ')->where([['social_media.Status', '=', 0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        $this->inv['flip']['Name'] = 'social_media.Name';
        
        if (isset($this->inv['getsearchby'])) { $this->_dbquerysearch($result, $this->inv['flip']); }

        $this->inv['flip']['Name'] = 'Name';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        } else {
            for ($i = 0; $i < count($result['data']); $i++) {
                if ($result['data'][$i][$this->inv['flip']['IconSocialMediaImage']]) {
                    $result['data'][$i][$this->inv['flip']['IconSocialMediaImage']] =
                    $this->inv['basesite'] . 
                    'assets/frontend/images/content/iconsocialmedia/' . $result['data'][$i][$this->inv['flip']['IconSocialMediaImage']];
                }

                $check                                          = '';
                if ($result['data'][$i][$this->inv['flip']['IsActive']] == 1) {
                    $check = 'checked';
                }

                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive ' . $result['data'][$i][$this->inv['flip']['SocialMediaID']] . '" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" ' . $check . ' rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]) . '">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}
