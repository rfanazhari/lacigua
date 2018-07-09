<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class salebannerController extends Controller
{
    public $model = 'SaleBanner';

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
        'ID' => 'SaleBannerID',
        'Title' => 'Title',
        'Description' => 'Description',
        'TextColor' => 'TextColor',
        'NoteTitle' => 'NoteTitle',
        'NoteDescription' => 'NoteDescription',
        'NoteColor' => 'NoteColor',
        'Banner' => 'Banner',
        'BannerColor' => 'BannerColor',
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
        'SaleBannerID' => ['Sale Banner ID'],
        'Title' => ['Title', true],
        'Description' => ['Description'],
        'TextColor' => ['Text Color'],
        'NoteTitle' => ['Note Title', true],
        'NoteDescription' => ['Note Description'],
        'NoteColor' => ['Note Color'],
        'Banner' => ['Banner', true, '', 'image'],
        'BannerColor' => ['Banner Color'],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    public $imagepath = '/resources/assets/frontend/images/content/salebanner/';

    public $objectkey = '', $SaleBannerID = '', $errorSaleBannerID = '', $Title = '', $errorTitle = '', $Description = '', $errorDescription = '', $TextColor = '', $errorTextColor = '', $NoteTitle = '', $errorNoteTitle = '', $NoteDescription = '', $errorNoteDescription = '', $NoteColor = '', $errorNoteColor = '', $Banner = '', $errorBanner = '', $Bannerfiletype = '', $BannerColor = '', $errorBannerColor = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) exit;

        $request = \Request::instance()->request->all();
        if (isset($request['ajaxpost'])) {
            $id = $request['value'];
            $this->_loaddbclass(['SaleBanner']);
            $SaleBanner = $this->SaleBanner->where([['ID', '=', $id]])->first();
            switch ($request['ajaxpost']) {
                case 'setactive':
                    if ($SaleBanner) {
                        $IsActive = 1;
                        if ($SaleBanner->IsActive == 1) $IsActive = 0;

                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $SaleBanner->update($array);

                        die('OK');
                    } else die('Error');
                    break;
                case 'deleteBanner':
                    if ($SaleBanner[$this->inv['flip']['Banner']]) {
                        @unlink(base_path() . $this->pathimage . $SaleBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $SaleBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path() . $this->pathimage . 'small_' . $SaleBanner[$this->inv['flip']['Banner']]);
                        $SaleBanner->update([$this->inv['flip']['Banner'] => '']);
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
                $this->_loaddbclass([$this->model]);

                $SaleBanner = $this->SaleBanner->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if ($SaleBanner) {
                    $this->SaleBannerID = $SaleBanner[$this->inv['flip']['SaleBannerID']];
                    $this->Title = $SaleBanner[$this->inv['flip']['Title']];
                    $this->Description = $SaleBanner[$this->inv['flip']['Description']];
                    $this->TextColor = $SaleBanner[$this->inv['flip']['TextColor']];
                    $this->NoteTitle = $SaleBanner[$this->inv['flip']['NoteTitle']];
                    $this->NoteDescription = $SaleBanner[$this->inv['flip']['NoteDescription']];
                    $this->NoteColor = $SaleBanner[$this->inv['flip']['NoteColor']];
                    if ($SaleBanner[$this->inv['flip']['Banner']]) {
                        $this->Banner = $this->inv['basesite'] . str_replace('/resources/', '', $this->imagepath) .
                            'medium_' . $SaleBanner[$this->inv['flip']['Banner']];
                    }
                    $this->BannerColor = $SaleBanner[$this->inv['flip']['BannerColor']];
                    $this->IsActive = $SaleBanner[$this->inv['flip']['IsActive']];
                    $this->Status = $SaleBanner[$this->inv['flip']['Status']];
                    $this->CreatedDate = $SaleBanner[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $SaleBanner[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $SaleBanner[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $SaleBanner[$this->inv['flip']['UpdatedBy']];
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
            $this->_loaddbclass([$this->model]);

            if (isset($request['edit'])) {
                $SaleBanner = $this->SaleBanner->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if (!$SaleBanner) {
                    $this->_redirect('404');
                }
            }

            $this->Title = $request['Title'];
            if (empty($this->Title)) {
                $this->errorTitle = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.SaleBanner.Title')]
                );
            }

            $this->Description = $request['Description'];
            $this->TextColor = $request['TextColor'];

            $SaleBanner = $this->SaleBanner->where([[$this->inv['flip']['Title'], '=', $this->Title],['Status','=',0]])->first();

            if ($SaleBanner) {
                if (isset($request['addnew']) && strtoupper($SaleBanner->Title) == strtoupper($this->Title)) {
                    if (!$this->errorTitle) {
                        $this->errorTitle = $this->_trans('validation.already',
                            ['value' => $this->_trans('dashboard.masterdata.SaleBanner.Title')]
                        );
                    }
                } else {
                    if ($SaleBanner[$this->objectkey] != $this->inv['getid']) {
                        if (!$this->errorTitle) {
                            $this->errorTitle = $this->_trans('validation.already',
                                ['value' => $this->_trans('dashboard.masterdata.SaleBanner.Title')]
                            );
                        }
                    }
                }
            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
            $this->NoteTitle = $request['NoteTitle'];
            $this->NoteDescription = $request['NoteDescription'];
            $this->NoteColor = $request['NoteColor'];

            if(isset($requestfile['Banner'])) $this->Banner = $requestfile['Banner'];
            else $this->Banner = '';
            if($this->Banner && !$this->_checkimage($this->Banner, $this->Bannerfiletype)) {
                $this->errorBanner = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.SaleBanner.Banner')]
                );
            }
            $this->BannerColor = $request['BannerColor'];

            //handling error
            if (!$this->inv['messageerror'] && !$this->errorSaleBannerID && !$this->errorTitle && !$this->errorDescription && !$this->errorTextColor && !$this->errorNoteTitle && !$this->errorNoteDescription && !$this->errorNoteColor && !$this->errorBanner && !$this->errorBannerColor && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {

                $array = array(
                    $this->inv['flip']['SaleBannerID'] => $this->SaleBannerID,
                    $this->inv['flip']['Title'] => $this->Title,
                    $this->inv['flip']['Description'] => $this->Description,
                    $this->inv['flip']['TextColor'] => $this->TextColor,
                    $this->inv['flip']['BannerColor'] => $this->BannerColor,
                    $this->inv['flip']['NoteTitle'] => $this->NoteTitle,
                    $this->inv['flip']['NoteDescription'] => $this->NoteDescription,
                    $this->inv['flip']['NoteColor'] => $this->NoteColor,
                );

                $userdata = \Session::get('userdata');
                $userid   = $userdata['uuserid'];

                if (isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']]   = $userid;

                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']]   = 0;

                    $SaleBanner = $this->SaleBanner->creates($array);

                    $this->_dblog('addnew', $this, $this->Title);
                    \Session::put('messagesuccess', "Saving $this->Title Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                    $SaleBanner = $this->SaleBanner->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                    $SaleBanner->update($array);

                    $this->_dblog('edit', $this, $this->Title);
                    \Session::put('messagesuccess', "Update $this->Title Completed !");
                }

                if ($this->Banner) {
                    $imagename = 'salebanner' . $SaleBanner[$this->inv['flip']['SaleBannerID']] . $this->Bannerfiletype;
                    $array[$this->inv['flip']['Banner']] = $imagename;
                    $SaleBanner->update($array);
                    $width = 1200;
                    $height = 278;
                    $this->_imagetofolder($this->Banner, base_path() . $this->imagepath, $imagename, $width, $height);
                    $this->_imagetofolder($this->Banner, base_path() . $this->imagepath, 'medium_' . $imagename, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Banner, base_path() . $this->imagepath, 'small_' . $imagename, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['SaleBannerID'] = $this->SaleBannerID; $this->inv['errorSaleBannerID'] = $this->errorSaleBannerID;
        $this->inv['Title'] = $this->Title; $this->inv['errorTitle'] = $this->errorTitle;
        $this->inv['Description'] = $this->Description; $this->inv['errorDescription'] = $this->errorDescription;
        $this->inv['TextColor'] = $this->TextColor; $this->inv['errorTextColor'] = $this->errorTextColor;
        $this->inv['NoteTitle'] = $this->NoteTitle; $this->inv['errorNoteTitle'] = $this->errorNoteTitle;
        $this->inv['NoteDescription'] = $this->NoteDescription; $this->inv['errorNoteDescription'] = $this->errorNoteDescription;
        $this->inv['NoteColor'] = $this->NoteColor; $this->inv['errorNoteColor'] = $this->errorNoteColor;
        $this->inv['Banner'] = $this->Banner; $this->inv['errorBanner'] = $this->errorBanner;
        $this->inv['BannerColor'] = $this->BannerColor; $this->inv['errorBannerColor'] = $this->errorBannerColor;
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
        if ($url) {
            return $this->_redirect($url);
        }

        if (isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([$this->model]);

            foreach ($this->inv['delete'] as $val) {
                $SaleBanner = $this->SaleBanner->where([[$this->objectkey, '=', $val]])->first();
                if ($SaleBanner) {
                    $this->Title = $SaleBanner[$this->inv['flip']['Title']];

                    if ($SaleBanner->Banner) {
                        @unlink(base_path() . $this->imagepath . $SaleBanner->Banner);
                        @unlink(base_path() . $this->imagepath . 'medium_' . $SaleBanner->Banner);
                        @unlink(base_path() . $this->imagepath . 'small_' . $SaleBanner->Banner);
                    }

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']]   = 1;
                    $SaleBanner->update($array);

                    if (end($this->inv['delete']) != $val) {
                        $br = "<br/>";
                    } else {
                        $br = "";
                    }

                    $this->_dblog('delete', $this, $this->Title);
                    $this->inv['messagesuccess'] .= "Delete $this->Title Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"])
    {
        $this->_loaddbclass([$this->model]);

        $result = $this->SaleBanner->where([['Status', '=', 0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        if (isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for ($i = 0; $i < count($result['data']); $i++) {
                if ($result['data'][$i][$this->inv['flip']['Banner']]) {
                    $result['data'][$i][$this->inv['flip']['Banner']] =
                    $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->imagepath) .
                        'small_' . $result['data'][$i][$this->inv['flip']['Banner']];
                }

                $check = '';
                if ($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';

                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive ' . $result['data'][$i][$this->inv['flip']['SaleBannerID']] . '" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" ' . $check . ' rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]) . '">';

            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}
