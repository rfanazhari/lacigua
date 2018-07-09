<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class bookingbannerController extends Controller
{

    public $model = 'MainCategoryBanner';
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
        'ID' => 'MainCategoryBannerID',
        'ModelType' => 'ModelType',
        'BannerType' => 'BannerType',
        'BrandID' => 'BrandID',
        'NameBrand' => 'NameBrand',
        'Banner' => 'Banner',
        'BannerURL' => 'BannerURL',
        'Title' => 'Title',
        'Note' => 'Note',
        'BgColorNote' => 'BgColorNote',
        'BannerStart' => 'BannerStart',
        'BannerEnd' => 'BannerEnd',
        'ShowTime' => 'ShowTime',
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
        'MainCategoryBannerID' => ['Main Category Banner ID'],
        'ModelType' => ['Model Type'],
        'BannerType' => ['Banner Type', true],
        'BrandID' => ['Brand'],
        'NameBrand' => ['Brand'],
        'Banner' => ['Banner', true],
        'BannerURL' => ['Banner URL'],
        'Title' => ['Title'],
        'Note' => ['Note'],
        'BgColorNote' => ['Bg Color Note'],
        'BannerStart' => ['Banner Start', true],
        'BannerEnd' => ['Banner End', true],
        'ShowTime' => ['Show Time', true],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    public $pathimage = '/resources/assets/frontend/images/content/maincategorybanner/';

    public $objectkey = '', $MainCategoryBannerID = '', $errorMainCategoryBannerID = '', $ModelType = '', $errorModelType = '', $BannerType = '', $errorBannerType = '', $BrandID = '', $errorBrandID = '', $Banner = '', $errorBanner = '', $Bannerfiletype = '', $BannerURL = '', $errorBannerURL = '', $Title = '', $errorTitle = '', $Note = '', $errorNote = '', $BgColorNote = '', $errorBgColorNote = '', $BannerStart = '', $errorBannerStart = '', $BannerEnd = '', $errorBannerEnd = '', $ShowTime = '', $errorShowTime = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) { exit; }

        $request = \Request::instance()->request->all();
        $id      = $request['value'];
        $this->_loaddbclass(['MainCategoryBanner']);
        $MainCategoryBanner = $this->MainCategoryBanner->where([['ID', '=', $id]])->first();

        if (isset($request['ajaxpost'])) {
            switch ($request['ajaxpost']) {
                case 'setactive':
                    if ($MainCategoryBanner) {
                        $this->BannerStart = $MainCategoryBanner[$this->inv['flip']['BannerStart']];
                        $this->BannerEnd   = $MainCategoryBanner[$this->inv['flip']['BannerEnd']];

                        $IsActive = 1;
                        if ($MainCategoryBanner->IsActive == 1) {
                            $IsActive = 0;
                        }

                        $userdata = \Session::get('userdata');
                        $userid   = $userdata['uuserid'];

                        $array[$this->inv['flip']['IsActive']]    = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                        $MainCategoryBanner->update($array);

                        if ($IsActive) {
                            $IsActive = 'Active';
                        } else {
                            $IsActive = 'Non Active';
                        }

                        $this->_dblog('edit', $this, 'Set ' . $IsActive . ' ' . $this->BannerStart . ' s/d ' . $this->BannerEnd);

                        die('OK');
                    } else {
                        die('Error');
                    }

                    break;
                case 'showtime':
                    if ($MainCategoryBanner) {
                        $this->BannerStart = $MainCategoryBanner[$this->inv['flip']['BannerStart']];
                        $this->BannerEnd   = $MainCategoryBanner[$this->inv['flip']['BannerEnd']];

                        $ShowTime = 1;
                        if ($MainCategoryBanner->ShowTime == 1) {
                            $ShowTime = 0;
                        }

                        $userdata = \Session::get('userdata');
                        $userid   = $userdata['uuserid'];

                        $array[$this->inv['flip']['ShowTime']]    = $ShowTime;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                        $MainCategoryBanner->update($array);

                        if ($ShowTime) {
                            $ShowTime = 'Active';
                        } else {
                            $ShowTime = 'Non Active';
                        }

                        $this->_dblog('edit', $this, 'Set ' . $ShowTime . ' ' . $this->BannerStart . ' s/d ' . $this->BannerEnd);

                        die('OK');
                    } else {
                        die('Error');
                    }

                    break;
                case 'deleteBanner':
                    if ($MainCategoryBanner[$this->inv['flip']['Banner']]) {
                        @unlink(base_path() . $this->pathimage . $MainCategoryBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $MainCategoryBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path() . $this->pathimage . 'small_' . $MainCategoryBanner[$this->inv['flip']['Banner']]);
                        $MainCategoryBanner->update([$this->inv['flip']['Banner'] => '']);
                    }
                    break;
            }
        }
    }

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) {
            return $this->_redirect($url);
        }

        return $this->views();
    }

    public function addnew()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) {
            return $this->_redirect($url);
        }

        return $this->addnewedit();
    }

    public function edit()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) {
            return $this->_redirect($url);
        }

        return $this->addnewedit();
    }

    private function getdata()
    {
        if (isset($this->inv['getid'])) {
            if (!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass([$this->model]);

                $MainCategoryBanner = $this->MainCategoryBanner->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if ($MainCategoryBanner) {

                    $this->MainCategoryBannerID = $MainCategoryBanner[$this->inv['flip']['MainCategoryBannerID']];
                    $this->ModelType            = $MainCategoryBanner[$this->inv['flip']['ModelType']];
                    $this->BannerType           = $MainCategoryBanner[$this->inv['flip']['BannerType']];
                    $this->BrandID              = $MainCategoryBanner[$this->inv['flip']['BrandID']];
                    $this->Banner               = $MainCategoryBanner[$this->inv['flip']['Banner']];
                    $this->BannerURL            = $MainCategoryBanner[$this->inv['flip']['BannerURL']];
                    $this->Title                = $MainCategoryBanner[$this->inv['flip']['Title']];
                    $this->Note                 = $MainCategoryBanner[$this->inv['flip']['Note']];
                    $this->BgColorNote          = $MainCategoryBanner[$this->inv['flip']['BgColorNote']];
                    if(!in_array($MainCategoryBanner[$this->inv['flip']['BannerStart']], ['1970-01-01 00:00:01','0000-00-00 00:00:00','']))
                        $this->BannerStart = substr($this->_datetimeforhtml($MainCategoryBanner[$this->inv['flip']['BannerStart']]), 0, -3);
                    if(!in_array($MainCategoryBanner[$this->inv['flip']['BannerEnd']], ['1970-01-01 00:00:01','0000-00-00 00:00:00','']))
                        $this->BannerEnd = substr($this->_datetimeforhtml($MainCategoryBanner[$this->inv['flip']['BannerEnd']]), 0, -3);
                    $this->ShowTime             = $MainCategoryBanner[$this->inv['flip']['ShowTime']];
                    $this->IsActive             = $MainCategoryBanner[$this->inv['flip']['IsActive']];
                    $this->Status               = $MainCategoryBanner[$this->inv['flip']['Status']];
                    $this->CreatedDate          = $MainCategoryBanner[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy            = $MainCategoryBanner[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate          = $MainCategoryBanner[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy            = $MainCategoryBanner[$this->inv['flip']['UpdatedBy']];

                    if ($MainCategoryBanner[$this->inv['flip']['Banner']]) {
                        $this->Banner = $this->inv['basesite'] . str_replace('/resources/', '', $this->pathimage) . 'medium_' . $MainCategoryBanner[$this->inv['flip']['Banner']];
                    }
                } else {
                    $this->inv['messageerror'] = $this->_trans('validation.norecord');
                }
            } else {
                $this->inv['messageerror'] = $this->_trans('validation.norecord');
            }
        }
    }

    private function addnewedit()
    {
        $request     = \Request::instance()->request->all();
        $requestfile = \Request::file();

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([$this->model]);
            $MainCategoryBanner = '';

            if (isset($request['edit'])) {
                $MainCategoryBanner = $this->MainCategoryBanner->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if (!$MainCategoryBanner) {
                    $this->_redirect('404');
                }
            }

            $this->ModelType = $request['ModelType'];
            if (empty($this->ModelType)) {
                $this->errorModelType = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.bookingbanner.ModelType')]
                );
            }
            $this->BannerType = $request['BannerType'];
            if (empty($this->BannerType)) {
                $this->errorBannerType = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.bookingbanner.BannerType')]
                );
            }

            $this->BannerStart = $request['BannerStart'];
            $this->BannerEnd   = $request['BannerEnd'];

            if ($this->BannerType != 'TOP') {
                if (empty($this->BannerStart)) {
                    $this->errorBannerStart = $this->_trans('validation.mandatory',
                        ['value' => $this->_trans('dashboard.masterdata.bookingbanner.BannerStart')]
                    );
                }

                if (empty($this->BannerEnd)) {
                    $this->errorBannerEnd = $this->_trans('validation.mandatory',
                        ['value' => $this->_trans('dashboard.masterdata.bookingbanner.BannerEnd')]
                    );
                }

                if(!$this->errorBannerStart && !$this->errorBannerEnd) {
                    $Tanggal = $this->MainCategoryBanner->where([
                        ['IsActive', '=', 1],
                        ['Status', '=', 0],
                        ['ModelType', '=', $this->ModelType],
                        ['BannerType', '=', $this->BannerType],
                    ])->where(function ($query) {
                        $query->where(function ($query) {
                            $query->whereraw('BannerStart >= "'.$this->_datetimeformysql($this->BannerStart)->format('Y-m-d H:i:s').'"')
                                ->whereraw('BannerStart <= "'.$this->_datetimeformysql($this->BannerEnd)->format('Y-m-d H:i:s').'"');
                        })->orwhere(function ($query) {
                            $query->whereraw('BannerEnd >= "'.$this->_datetimeformysql($this->BannerStart)->format('Y-m-d H:i:s').'"')
                                ->whereraw('BannerEnd <= "'.$this->_datetimeformysql($this->BannerEnd)->format('Y-m-d H:i:s').'"');
                        });
                    });

                    $Tanggal = $Tanggal->first();

                    if($Tanggal) {
                        if(isset($request['addnew'])) {
                            $this->inv['messageerror'] = $this->_trans('validation.already', 
                                    ['value' => 'Banner Position ' . $this->BannerType . ' ' . $this->BannerStart . ' to ' . $this->BannerEnd]
                                );
                        } else {
                            if ($Tanggal->ID != $this->inv['getid']) {
                                $this->inv['messageerror'] = $this->_trans('validation.already', 
                                    ['value' => 'Banner Position ' . $this->BannerType . ' ' . $this->BannerStart . ' to ' . $this->BannerEnd]
                                );
                            }
                        }
                    }
                }
            }

            $this->BrandID = $request['BrandID'];
            if (empty($this->BrandID)) {
                $this->errorBrandID = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.bookingbanner.BrandID')]
                );
            }

            $this->BannerURL   = $request['BannerURL'];
            if(isset($request['Title']))
                $this->Title = $request['Title'];
            if(isset($request['ShowTime']))
                $this->ShowTime = $request['ShowTime'];
            if(isset($request['Note']))
                $this->Note = $request['Note'];
            if($this->Title && empty($this->Note)) {
                $this->errorNote = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.bookingbanner.Note')]
                );
            }
            if(isset($request['BgColorNote']))
                $this->BgColorNote = $request['BgColorNote'];

            if (isset($requestfile['Banner'])) {
                $this->Banner = $requestfile['Banner'];
            } else {
                $this->Banner = '';
            }

            if (empty($this->Banner) && !(isset($request['edit']) && $MainCategoryBanner[$this->inv['flip']['Banner']])) {
                $this->errorBanner = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.bookingbanner.Banner')]
                );
            }

            if ($this->Banner && !$this->_checkimage($this->Banner, $this->Bannerfiletype)) {
                $this->errorBanner = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.bookingbanner.Banner')]
                );
            }

            if (!$this->inv['messageerror'] && !$this->errorMainCategoryBannerID && !$this->errorModelType && !$this->errorBannerType && !$this->errorBrandID && !$this->errorBanner && !$this->errorBannerURL && !$this->errorTitle && !$this->errorNote && !$this->errorBgColorNote && !$this->errorBannerStart && !$this->errorBannerEnd && !$this->errorShowTime && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {
                $array = array(
                    $this->inv['flip']['MainCategoryBannerID'] => $this->MainCategoryBannerID,
                    $this->inv['flip']['ModelType']            => $this->ModelType,
                    $this->inv['flip']['BannerType']           => $this->BannerType,
                    $this->inv['flip']['BrandID']              => $this->BrandID,
                    $this->inv['flip']['BannerURL']            => $this->BannerURL,
                    $this->inv['flip']['Title']                => $this->Title,
                    $this->inv['flip']['Note']                 => $this->Note,
                    $this->inv['flip']['BgColorNote']          => $this->BgColorNote,
                    $this->inv['flip']['ShowTime']             => $this->ShowTime,
                );

                $userdata = \Session::get('userdata');
                $userid   = $userdata['uuserid'];

                if (empty($this->BannerStart)) {
                    $array[$this->inv['flip']['BannerStart']] = '0000-00-00 00:00:00';
                } else {
                    $array[$this->inv['flip']['BannerStart']] = $this->_datetimeformysql($this->BannerStart . ":00");
                }
                if (empty($this->BannerEnd)) {
                    $array[$this->inv['flip']['BannerEnd']] = '0000-00-00 00:00:00';
                } else {
                    $array[$this->inv['flip']['BannerEnd']] = $this->_datetimeformysql($this->BannerEnd . ":00");
                }

                if (isset($request['addnew'])) {
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']]   = 0;

                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']]   = $userid;

                    $MainCategoryBanner = $this->MainCategoryBanner->creates($array);

                    $this->_dblog('addnew', $this, $this->Title);
                    \Session::put('messagesuccess', "Saving $this->Title Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                    $MainCategoryBanner = $this->MainCategoryBanner->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                    $MainCategoryBanner->update($array);

                    $this->_dblog('edit', $this, $this->Title);
                    \Session::put('messagesuccess', "Update $this->Title Completed !");
                }

                if ($this->Banner) {
                    $ImageName = 'Banner_' . $MainCategoryBanner[$this->inv['flip']['MainCategoryBannerID']] . $this->Bannerfiletype;
                    $array[$this->inv['flip']['Banner']] = $ImageName;
                    $MainCategoryBanner->update($array);

                    switch ($this->BannerType) {
                        case 'TOP':
                            $width = 1280;
                            $height = 600;
                            break;
                        case 'LEFT':
                        case 'RIGHT':
                            $width = 931;
                            $height = 910;
                            break;
                        case 'BOTTOM':
                            $width = 1120;
                            $height = 413;
                            break;
                    }
                    
                    $this->_imagetofolder($this->Banner, base_path() . $this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->Banner, base_path() . $this->pathimage, 'medium_' . $ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Banner, base_path() . $this->pathimage, 'small_' . $ImageName, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }

        $this->getdata();

        $this->inv['MainCategoryBannerID']      = $this->MainCategoryBannerID;
        $this->inv['errorMainCategoryBannerID'] = $this->errorMainCategoryBannerID;
        $this->inv['ModelType']                 = $this->ModelType;
        $this->inv['errorModelType']            = $this->errorModelType;
        $this->inv['BannerType']                = $this->BannerType;
        $this->inv['errorBannerType']           = $this->errorBannerType;
        $this->inv['BrandID']                   = $this->BrandID;
        $this->inv['errorBrandID']              = $this->errorBrandID;
        $this->inv['Banner']                    = $this->Banner;
        $this->inv['errorBanner']               = $this->errorBanner;
        $this->inv['BannerURL']                 = $this->BannerURL;
        $this->inv['errorBannerURL']            = $this->errorBannerURL;
        $this->inv['Title']                     = $this->Title;
        $this->inv['errorTitle']                = $this->errorTitle;
        $this->inv['Note']                      = $this->Note;
        $this->inv['errorNote']                 = $this->errorNote;
        $this->inv['BgColorNote']               = $this->BgColorNote;
        $this->inv['errorBgColorNote']          = $this->errorBgColorNote;
        $this->inv['BannerStart']               = $this->BannerStart;
        $this->inv['errorBannerStart']          = $this->errorBannerStart;
        $this->inv['BannerEnd']                 = $this->BannerEnd;
        $this->inv['errorBannerEnd']            = $this->errorBannerEnd;
        $this->inv['ShowTime']                  = $this->ShowTime;
        $this->inv['errorShowTime']             = $this->errorShowTime;
        $this->inv['IsActive']                  = $this->IsActive;
        $this->inv['errorIsActive']             = $this->errorIsActive;
        $this->inv['Status']                    = $this->Status;
        $this->inv['errorStatus']               = $this->errorStatus;
        $this->inv['CreatedDate']               = $this->CreatedDate;
        $this->inv['errorCreatedDate']          = $this->errorCreatedDate;
        $this->inv['CreatedBy']                 = $this->CreatedBy;
        $this->inv['errorCreatedBy']            = $this->errorCreatedBy;
        $this->inv['UpdatedDate']               = $this->UpdatedDate;
        $this->inv['errorUpdatedDate']          = $this->errorUpdatedDate;
        $this->inv['UpdatedBy']                 = $this->UpdatedBy;
        $this->inv['errorUpdatedBy']            = $this->errorUpdatedBy;

        $arrModelType = [
            'WOMEN' => 'WOMEN',
            'MEN'   => 'MEN',
            'KIDS'  => 'KIDS',
        ];
        $this->inv['arrModelType'] = $arrModelType;

        $arrBannerType = [
            'TOP'    => 'TOP',
            'LEFT'   => 'LEFT',
            'RIGHT'  => 'RIGHT',
            'BOTTOM' => 'BOTTOM',
        ];
        $this->inv['arrBannerType'] = $arrBannerType;

        $arrShowTime = [
            '1' => 'Yes',
            '0' => 'No',
        ];
        $this->inv['arrShowTime'] = $arrShowTime;

        $this->_loaddbclass(['Brand']);
        $this->arrBrand        = $this->Brand->leftjoin([
            ['seller', 'seller.ID', '=', 'brand.SellerID']
        ])->where([
            ['seller.IsActive', '=', 1],
            ['seller.Status', '=', 0],
            ['brand.IsActive', '=', 1],
            ['brand.Status', '=', 0],
        ])->select(['brand.*'])->orderBy('Name', 'ASC')->get()->toArray();
        $this->inv['arrBrand'] = $this->arrBrand;
        
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
                $MainCategoryBanner = $this->MainCategoryBanner->where([[$this->objectkey, '=', $val]])->first();
                if ($MainCategoryBanner) {
                    $this->BannerStart = $this->_datetimeforhtml($MainCategoryBanner[$this->inv['flip']['BannerStart']], 'red');
                    $this->BannerEnd   = $this->_datetimeforhtml($MainCategoryBanner[$this->inv['flip']['BannerEnd']], 'red');

                    if ($MainCategoryBanner[$this->inv['flip']['Banner']]) {
                        @unlink(base_path() . $this->pathimage . $MainCategoryBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $MainCategoryBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path() . $this->pathimage . 'small_' . $MainCategoryBanner[$this->inv['flip']['Banner']]);
                    }

                    $MainCategoryBanner->delete();

                    if (end($this->inv['delete']) != $val) {
                        $br = "<br/>";
                    } else {
                        $br = "";
                    }

                    $this->_dblog('delete', $this, $this->BannerStart . ' s/d ' . $this->BannerEnd);
                    $this->inv['messagesuccess'] .= "Delete $this->BannerStart s/d $this->BannerEnd Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"])
    {
        $this->_loaddbclass([$this->model]);

        $result = $this->MainCategoryBanner
            ->join([
                ['brand', 'brand.ID', '=', 'main_category_banner.' . $this->inv['flip']['BrandID']],
            ])->select([
            'brand.Name as NameBrand',
            'main_category_banner.*',
        ])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        $this->inv['flip']['StyleName'] = 'brand.Name';

        if (isset($this->inv['getsearchby'])) {
            $this->_dbquerysearch($result, $this->inv['flip']);
        }

        $this->inv['flip']['BrandName'] = 'BrandName';

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        } else {
            for ($i = 0; $i < count($result['data']); $i++) {
                if ($result['data'][$i][$this->inv['flip']['Banner']]) {
                    $result['data'][$i][$this->inv['flip']['Banner']] = '<img src="' . $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) .
                        'small_' . $result['data'][$i][$this->inv['flip']['Banner']] . '">';
                }

                $check = '';
                if ($result['data'][$i][$this->inv['flip']['ShowTime']] == 1) {
                    $check = 'checked';
                }

                $result['data'][$i][$this->inv['flip']['ShowTime']] = '<input type="checkbox" data-size="small" class="make-switch ShowTime ' . $result['data'][$i][$this->inv['flip']['MainCategoryBannerID']] . '" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" ' . $check . ' rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['ShowTime'][0]]) . '">';

                $check = '';
                if ($result['data'][$i][$this->inv['flip']['IsActive']] == 1) {
                    $check = 'checked';
                }

                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive ' . $result['data'][$i][$this->inv['flip']['MainCategoryBannerID']] . '" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" ' . $check . ' rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]) . '">';

                if(!in_array($result['data'][$i][$this->inv['flip']['BannerStart']], ['1970-01-01 00:00:01','0000-00-00 00:00:00',''])) {
                    $result['data'][$i][$this->inv['flip']['BannerStart']] = $this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['BannerStart']], 'red');
                } else {
                    $result['data'][$i][$this->inv['flip']['BannerStart']] = '';
                }

                if(!in_array($result['data'][$i][$this->inv['flip']['BannerEnd']], ['1970-01-01 00:00:01','0000-00-00 00:00:00',''])) {
                    $result['data'][$i][$this->inv['flip']['BannerEnd']] = $this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['BannerEnd']], 'red');
                } else {
                    $result['data'][$i][$this->inv['flip']['BannerEnd']] = '';
                }

            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}
