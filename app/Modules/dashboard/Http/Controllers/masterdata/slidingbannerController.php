<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class slidingbannerController extends Controller
{

    public $model = 'SlidingBanner';
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
        'ID' => 'SlidingBannerID',
        'Banner' => 'Banner',
        'BannerURL' => 'BannerURL',
        'Title' => 'Title',
        'Text1' => 'Text1',
        'SubTitle1' => 'SubTitle1',
        'Text2' => 'Text2',
        'SubTitle2' => 'SubTitle2',
        'BgColorNote' => 'BgColorNote',
        'BrandName' => 'BrandName',
        'BrandBy' => 'BrandBy',
        'BgColorNote2' => 'BgColorNote2',
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
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'SlidingBannerID' => ['Sliding Banner ID'],
        'Banner' => ['Banner', true],
        'BannerURL' => ['Banner URL', true],
        'Title' => ['Title'],
        'Text1' => ['Text 1'],
        'SubTitle1' => ['Sub Title 1'],
        'Text2' => ['Text 2'],
        'SubTitle2' => ['Sub Title 2'],
        'BgColorNote' => ['Backgound Color 1'],
        'BrandName' => ['Brand Name'],
        'BrandBy' => ['Brand By'],
        'BgColorNote2' => ['Backgound Color 2'],
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

    var $pathimage = '/resources/assets/frontend/images/content/slidingbanner/';
    var $objectkey = '', $SlidingBannerID = '', $errorSlidingBannerID = '', $Banner = '', $errorBanner = '', $BannerURL = '', $errorBannerURL = '', $Title = '', $errorTitle = '', $Text1 = '', $errorText1 = '', $SubTitle1 = '', $errorSubTitle1 = '', $Text2 = '', $errorText2 = '', $SubTitle2 = '', $errorSubTitle2 = '', $BgColorNote = '', $errorBgColorNote = '', $BrandName = '', $errorBrandName = '', $BrandBy = '', $errorBrandBy = '', $BgColorNote2 = '', $errorBgColorNote2 = '', $BannerStart = '', $errorBannerStart = '', $BannerEnd = '', $errorBannerEnd = '', $ShowTime = '', $errorShowTime = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        $id = $request['value'];
        $this->_loaddbclass([ 'SlidingBanner' ]);
        $SlidingBanner = $this->SlidingBanner->where([['ID', '=', $id]])->first();

        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                    if($SlidingBanner) {
                        $this->BannerStart = $SlidingBanner[$this->inv['flip']['BannerStart']];
                        $this->BannerEnd = $SlidingBanner[$this->inv['flip']['BannerEnd']];

                        $IsActive = 1;
                        if($SlidingBanner->IsActive == 1) $IsActive = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];

                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $SlidingBanner->update($array);

                        if($IsActive) $IsActive = 'Active';
                        else $IsActive = 'Non Active';

                        $this->_dblog('edit', $this, 'Set '.$IsActive.' '.$this->BannerStart.' s/d '.$this->BannerEnd);

                        die('OK');
                    } else die('Error');
                break;
                case 'showtime' :
                    if($SlidingBanner) {
                        $this->BannerStart = $SlidingBanner[$this->inv['flip']['BannerStart']];
                        $this->BannerEnd = $SlidingBanner[$this->inv['flip']['BannerEnd']];

                        $ShowTime = 1;
                        if($SlidingBanner->ShowTime == 1) $ShowTime = 0;

                        $userdata =  \Session::get('userdata');
                        $userid =  $userdata['uuserid'];

                        $array[$this->inv['flip']['ShowTime']] = $ShowTime;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']] = $userid;

                        $SlidingBanner->update($array);

                        if($ShowTime) $ShowTime = 'Active';
                        else $ShowTime = 'Non Active';

                        $this->_dblog('edit', $this, 'Set '.$ShowTime.' '.$this->BannerStart.' s/d '.$this->BannerEnd);

                        die('OK');
                    } else die('Error');
                break;
                case 'deleteBanner' :
                    if($SlidingBanner[$this->inv['flip']['Banner']]) {
                        @unlink(base_path().$this->pathimage.$SlidingBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$SlidingBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path().$this->pathimage.'small_'.$SlidingBanner[$this->inv['flip']['Banner']]);
                        $SlidingBanner->update([$this->inv['flip']['Banner'] => '']);
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
                $this->_loaddbclass([ $this->model ]);

                $SlidingBanner = $this->SlidingBanner->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($SlidingBanner) {
                    $this->SlidingBannerID = $SlidingBanner[$this->inv['flip']['SlidingBannerID']];
                    $this->Banner = $SlidingBanner[$this->inv['flip']['Banner']];
                    $this->BannerURL = $SlidingBanner[$this->inv['flip']['BannerURL']];
                    $this->Title = $SlidingBanner[$this->inv['flip']['Title']];
                    $this->Text1 = $SlidingBanner[$this->inv['flip']['Text1']];
                    $this->SubTitle1 = $SlidingBanner[$this->inv['flip']['SubTitle1']];
                    $this->Text2 = $SlidingBanner[$this->inv['flip']['Text2']];
                    $this->SubTitle2 = $SlidingBanner[$this->inv['flip']['SubTitle2']];
                    $this->BgColorNote = $SlidingBanner[$this->inv['flip']['BgColorNote']];
                    $this->BrandName = $SlidingBanner[$this->inv['flip']['BrandName']];
                    $this->BrandBy = $SlidingBanner[$this->inv['flip']['BrandBy']];
                    $this->BgColorNote2 = $SlidingBanner[$this->inv['flip']['BgColorNote2']];
                    if($SlidingBanner[$this->inv['flip']['BannerStart']] != '0000-00-00 00:00:00')
                        $this->BannerStart = substr($this->_datetimeforhtml($SlidingBanner[$this->inv['flip']['BannerStart']]), 0, -3);
                    if($SlidingBanner[$this->inv['flip']['BannerEnd']] != '0000-00-00 00:00:00')
                        $this->BannerEnd = substr($this->_datetimeforhtml($SlidingBanner[$this->inv['flip']['BannerEnd']]), 0, -3);
                    $this->ShowTime = $SlidingBanner[$this->inv['flip']['ShowTime']];
                    $this->IsActive = $SlidingBanner[$this->inv['flip']['IsActive']];
                    $this->Status = $SlidingBanner[$this->inv['flip']['Status']];
                    $this->CreatedDate = $SlidingBanner[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $SlidingBanner[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $SlidingBanner[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $SlidingBanner[$this->inv['flip']['UpdatedBy']];

                    if($SlidingBanner[$this->inv['flip']['Banner']])
                        $this->Banner = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).'medium_'.$SlidingBanner[$this->inv['flip']['Banner']];

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
            $this->_loaddbclass([ $this->model ]);
            $SlidingBanner = '';

            if(isset($request['edit'])) {
                $SlidingBanner = $this->SlidingBanner->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$SlidingBanner) {
                    $this->_redirect('404');
                }
            }

            $this->BannerURL = $request['BannerURL'];
            $this->Title = $request['Title'];
            $this->Text1 = $request['Text1'];
            $this->SubTitle1 = $request['SubTitle1'];
            $this->Text2 = $request['Text2'];
            $this->SubTitle2 = $request['SubTitle2'];
            $this->BgColorNote = $request['BgColorNote'];
            $this->BrandName = $request['BrandName'];
            $this->BrandBy = $request['BrandBy'];
            $this->BgColorNote2 = $request['BgColorNote2'];

            if(isset($requestfile['Banner'])) $this->Banner = $requestfile['Banner'];
            else $this->Banner = '';
            if(empty($this->Banner) && !(isset($request['edit']) && $SlidingBanner[$this->inv['flip']['Banner']])) {
                $this->errorBanner = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.slidingbanner.Banner')]
                );
            }
            if($this->Banner && !$this->_checkimage($this->Banner, $this->Bannerfiletype)) {
                $this->errorBanner = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.slidingbanner.Banner')]
                );
            }

            $this->ShowTime = $request['ShowTime'];
            if(!is_numeric($this->ShowTime)) {
                $this->errorShowTime = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.slidingbanner.ShowTime')]
                );
            }

            $this->BannerStart = $request['BannerStart'];
            $this->BannerEnd = $request['BannerEnd'];

            if($this->ShowTime && (!$this->BannerStart || !$this->BannerEnd)) {
                if(!$this->BannerStart) {
                    $this->errorBannerStart = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.masterdata.slidingbanner.BannerStart')]
                    );
                }
                if(!$this->BannerEnd) {
                    $this->errorBannerEnd = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.masterdata.slidingbanner.BannerEnd')]
                    );
                }
            }
            
            if(!$this->inv['messageerror'] && !$this->errorSlidingBannerID && !$this->errorBanner && !$this->errorBannerURL && !$this->errorTitle && !$this->errorText1 && !$this->errorSubTitle1 && !$this->errorText2 && !$this->errorSubTitle2 && !$this->errorBgColorNote && !$this->errorBrandName && !$this->errorBrandBy && !$this->errorBgColorNote2 && !$this->errorBannerStart && !$this->errorBannerEnd && !$this->errorShowTime && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {
                $BannerStart = $BannerEnd = '';
                if($this->BannerStart) $BannerStart = $this->_datetimeformysql($this->BannerStart.":00");
                if($this->BannerEnd) $BannerEnd = $this->_datetimeformysql($this->BannerEnd.":00");
                $array = array(
                    $this->inv['flip']['SlidingBannerID'] => $this->SlidingBannerID,
                    $this->inv['flip']['BannerURL'] => $this->BannerURL,
                    $this->inv['flip']['Title'] => $this->Title,
                    $this->inv['flip']['Text1'] => $this->Text1,
                    $this->inv['flip']['SubTitle1'] => $this->SubTitle1,
                    $this->inv['flip']['Text2'] => $this->Text2,
                    $this->inv['flip']['SubTitle2'] => $this->SubTitle2,
                    $this->inv['flip']['BgColorNote'] => $this->BgColorNote,
                    $this->inv['flip']['BrandName'] => $this->BrandName,
                    $this->inv['flip']['BrandBy'] => $this->BrandBy,
                    $this->inv['flip']['BgColorNote2'] => $this->BgColorNote2,
                    $this->inv['flip']['BannerStart'] => $BannerStart,
                    $this->inv['flip']['BannerEnd'] => $BannerEnd,
                    $this->inv['flip']['ShowTime'] => $this->ShowTime,
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    
                    $SlidingBanner = $this->SlidingBanner->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->BannerStart.' s/d '.$this->BannerEnd);
                    \Session::put('messagesuccess', "Saving $this->BannerStart s/d $this->BannerEnd Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $SlidingBanner = $this->SlidingBanner->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $SlidingBanner->update($array);
                    
                    $this->_dblog('edit', $this, $this->BannerStart.' s/d '.$this->BannerEnd);
                    \Session::put('messagesuccess', "Update $this->BannerStart s/d $this->BannerEnd Completed !");
                }

                if($this->Banner) {
                    $ImageName = 'Banner_'.$SlidingBanner[$this->inv['flip']['SlidingBannerID']].$this->Bannerfiletype;
                    $array[$this->inv['flip']['Banner']] = $ImageName;
                    $SlidingBanner->update($array);
                    $width = 1920;
                    $height = 878;
                    $this->_imagetofolder($this->Banner, base_path().$this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->Banner, base_path().$this->pathimage, 'medium_'.$ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Banner, base_path().$this->pathimage, 'small_'.$ImageName, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['SlidingBannerID'] = $this->SlidingBannerID; $this->inv['errorSlidingBannerID'] = $this->errorSlidingBannerID;
        $this->inv['Banner'] = $this->Banner; $this->inv['errorBanner'] = $this->errorBanner;
        $this->inv['BannerURL'] = $this->BannerURL; $this->inv['errorBannerURL'] = $this->errorBannerURL;
        $this->inv['Title'] = $this->Title; $this->inv['errorTitle'] = $this->errorTitle;
        $this->inv['Text1'] = $this->Text1; $this->inv['errorText1'] = $this->errorText1;
        $this->inv['SubTitle1'] = $this->SubTitle1; $this->inv['errorSubTitle1'] = $this->errorSubTitle1;
        $this->inv['Text2'] = $this->Text2; $this->inv['errorText2'] = $this->errorText2;
        $this->inv['SubTitle2'] = $this->SubTitle2; $this->inv['errorSubTitle2'] = $this->errorSubTitle2;
        $this->inv['BgColorNote'] = $this->BgColorNote; $this->inv['errorBgColorNote'] = $this->errorBgColorNote;
        $this->inv['BrandName'] = $this->BrandName; $this->inv['errorBrandName'] = $this->errorBrandName;
        $this->inv['BrandBy'] = $this->BrandBy; $this->inv['errorBrandBy'] = $this->errorBrandBy;
        $this->inv['BgColorNote2'] = $this->BgColorNote2; $this->inv['errorBgColorNote2'] = $this->errorBgColorNote2;
        $this->inv['BannerStart'] = $this->BannerStart; $this->inv['errorBannerStart'] = $this->errorBannerStart;
        $this->inv['BannerEnd'] = $this->BannerEnd; $this->inv['errorBannerEnd'] = $this->errorBannerEnd;
        $this->inv['ShowTime'] = $this->ShowTime; $this->inv['errorShowTime'] = $this->errorShowTime;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;

        $arrShowTime = [
            '1' => 'Yes',
            '0' => 'No',
        ];
        $this->inv['arrShowTime'] = $arrShowTime;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([$this->model]);

            foreach($this->inv['delete'] as $val) {
                $SlidingBanner = $this->SlidingBanner->where([[$this->objectkey,'=',$val]])->first();
                if($SlidingBanner) {
                    $this->BannerStart = $this->_datetimeforhtml($SlidingBanner[$this->inv['flip']['BannerStart']], 'red');
                    $this->BannerEnd = $this->_datetimeforhtml($SlidingBanner[$this->inv['flip']['BannerEnd']], 'red');
                    
                    if($SlidingBanner[$this->inv['flip']['Banner']]) {
                        @unlink(base_path().$this->pathimage.$SlidingBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$SlidingBanner[$this->inv['flip']['Banner']]);
                        @unlink(base_path().$this->pathimage.'small_'.$SlidingBanner[$this->inv['flip']['Banner']]);
                    }

                    $SlidingBanner->delete();

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->BannerStart.' s/d '.$this->BannerEnd);
                    $this->inv['messagesuccess'] .= "Delete $this->BannerStart s/d $this->BannerEnd Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'SlidingBanner' ]);

        $result = $this->SlidingBanner->where([['sliding_banner.Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                if($result['data'][$i][$this->inv['flip']['Banner']])
                    $result['data'][$i][$this->inv['flip']['Banner']] = '<img src="'.$this->inv['basesite'].
                str_replace('/resources/', '', $this->pathimage).
                'small_'.$result['data'][$i][$this->inv['flip']['Banner']].'?'.uniqid().'">';

                $check = '';
                if($result['data'][$i][$this->inv['flip']['ShowTime']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['ShowTime']] = '<input type="checkbox" data-size="small" class="make-switch ShowTime '.$result['data'][$i][$this->inv['flip']['SlidingBannerID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['ShowTime'][0]]).'">';

                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['SlidingBannerID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';

                if($result['data'][$i][$this->inv['flip']['BannerStart']] != '0000-00-00 00:00:00')
                    $result['data'][$i][$this->inv['flip']['BannerStart']] = $this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['BannerStart']], 'red');
                else $result['data'][$i][$this->inv['flip']['BannerStart']] = '';

                if($result['data'][$i][$this->inv['flip']['BannerEnd']] != '0000-00-00 00:00:00')
                    $result['data'][$i][$this->inv['flip']['BannerEnd']] = $this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['BannerEnd']], 'red');
                else $result['data'][$i][$this->inv['flip']['BannerEnd']] = '';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);    
    }
}