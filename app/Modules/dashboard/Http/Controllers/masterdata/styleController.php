<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class styleController extends Controller
{

    public $model = 'Style';
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
        'ID'           => 'StyleID',
        'Name'         => 'StyleName',
        'StyleImage'   => 'StyleImage',
        'Priority'     => 'Priority',
        'ShowOnHeader' => 'ShowOnHeader',
        'IsActive'     => 'IsActive',
        'Status'       => 'Status',
        'CreatedDate'  => 'CreatedDate',
        'CreatedBy'    => 'CreatedBy',
        'UpdatedDate'  => 'UpdatedDate',
        'UpdatedBy'    => 'UpdatedBy',
        'permalink'    => 'permalink',
    ];

    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'    => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'StyleID'      => ['Style ID'],
        'StyleImage'   => ['Style Image', true],
        'StyleName'    => ['Style Name', true],
        'ShowOnHeader' => ['Show On Header', true],
        'Priority'     => ['Priority', true],
        'IsActive'     => ['Is Active', true],
        'Status'       => ['Status'],
        'CreatedDate'  => ['Created Date'],
        'CreatedBy'    => ['Created By'],
        'UpdatedDate'  => ['Update Date'],
        'UpdatedBy'    => ['Update By'],
        'permalink'    => ['Permalink'],
    ];

    public $pathimage = '/resources/assets/frontend/images/content/style/';
    public $objectkey = '', $StyleID = '', $errorStyleID = '', $StyleName = '', $errorStyleName = '', $StyleImage = '', $StyleImagefiletype = '', $errorStyleImage = '', $Status = '', $errorStatus = '', $Priority = '', $errorPriority = '', $ShowOnHeader = '', $errorShowOnHeader = '', $IsActive = '', $errorIsActive = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';

    //var $optmenu = []; // buat transaksi, klo gak ada transaksi remark aja

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if (isset($request['ajaxpost'])) {
            $id = $request['value'];
            $this->_loaddbclass(['Style']);
            $Style = $this->Style->where([['ID', '=', $id]])->first();

            switch ($request['ajaxpost']) {
                case 'setactive':
                    if ($Style) {
                        $IsActive = 1;
                        if ($Style->IsActive == 1) $IsActive = 0;

                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $Style->update($array);

                        die('OK');
                    } else die('Error');
                break;
                case 'setonheader':
                    if ($Style) {
                        $ShowOnHeader = 1;
                        if ($Style->ShowOnHeader == 1) $ShowOnHeader = 0;

                        $array[$this->inv['flip']['ShowOnHeader']] = $ShowOnHeader;
                        $Style->update($array);

                        die('OK');
                    } else die('Error');
                break;
                case 'deleteImage':
                    if ($Style[$this->inv['flip']['StyleImage']]) {
                        @unlink(base_path() . $this->pathimage . $Style[$this->inv['flip']['StyleImage']]);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $Style[$this->inv['flip']['StyleImage']]);
                        @unlink(base_path() . $this->pathimage . 'small_' . $Style[$this->inv['flip']['StyleImage']]);
                        $Style->update([$this->inv['flip']['StyleImage'] => '']);
                    }
                    exit;
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

        return $this->getdata();
    }

    private function getdata()
    {
        if (isset($this->inv['getid'])) {
            if (!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass(['Style']);
                $Style = $this->Style->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                // dd($Style);
                if ($Style) {
                    $this->StyleID   = $Style[$this->inv['flip']['StyleID']];
                    $this->StyleName = $Style[$this->inv['flip']['StyleName']];

                    if ($Style[$this->inv['flip']['StyleImage']]) {
                        $this->StyleImage = $this->inv['basesite'] . str_replace('/resources/', '', $this->pathimage) .
                            'medium_' . $Style[$this->inv['flip']['StyleImage']];
                    }

                    $this->Priority     = $Style[$this->inv['flip']['Priority']];
                    $this->ShowOnHeader = $Style[$this->inv['flip']['ShowOnHeader']];
                    $this->IsActive     = $Style[$this->inv['flip']['IsActive']];
                    $this->Status       = $Style[$this->inv['flip']['Status']];
                    $this->CreatedDate  = $Style[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy    = $Style[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate  = $Style[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy    = $Style[$this->inv['flip']['UpdatedBy']];
                    $this->permalink    = $Style[$this->inv['flip']['permalink']];

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
            $this->_loaddbclass(['Style']);

            if (isset($request['edit'])) {
                $Style = $this->Style->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if (!$Style) {
                    $this->_redirect('404');
                }
            }

            $this->StyleName = $request['StyleName'];
            if (empty($this->StyleName)) {
                $this->errorStyleName = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.style.StyleName')]
                );
            }

            $CekStyle = $this->Style->where([[$this->inv['flip']['StyleName'],'=',$this->StyleName]])->first();

            if($CekStyle) {
                if(isset($request['addnew']) && strtoupper($CekStyle[$this->inv['flip']['StyleName']]) == strtoupper($this->StyleName)) {
                    if(!$this->errorStyleName) {
                        $this->errorStyleName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.Country.StyleName')]
                        );
                    }
                } else {
                    if ($CekStyle[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorStyleName) {
                            $this->errorStyleName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.Country.StyleName')]
                            );
                        }
                    }
                }
            }

            if (isset($requestfile['StyleImage'])) {
                $this->StyleImage = $requestfile['StyleImage'];
            } else {
                $this->StyleImage = '';
            }

            if (empty($this->StyleImage) && !(isset($request['edit']) && $Style[$this->inv['flip']['StyleImage']])) {
                $this->errorStyleImage = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.style.StyleImage')]
                );
            }
            if ($this->StyleImage && !$this->_checkimage($this->StyleImage, $this->StyleImagefiletype)) {
                $this->errorStyleImage = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.style.StyleImage')]
                );
            }

            $this->ShowOnHeader = $request['ShowOnHeader'];
            if (!is_numeric($this->ShowOnHeader)) {
                $this->errorShowOnHeader = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.style.ShowOnHeader')]
                );
            }

            //handling error
            if (!$this->inv['messageerror'] && !$this->errorStyleID && !$this->errorStyleName && !$this->errorStatus && !$this->errorStatus && !$this->errorStyleImage && !$this->errorPriority && !$this->errorShowOnHeader && !$this->errorIsActive && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {
                $array = array(
                    $this->inv['flip']['StyleID']      => $this->StyleID,
                    $this->inv['flip']['StyleName']    => $this->StyleName,
                    $this->inv['flip']['Priority']     => $this->Priority,
                    $this->inv['flip']['ShowOnHeader'] => $this->ShowOnHeader,
                    $this->inv['flip']['IsActive']     => $this->IsActive,
                    $this->inv['flip']['Status']       => $this->Status,
                    $this->inv['flip']['permalink']    => $this->_permalink($this->StyleName),
                );

                $userdata = \Session::get('userdata');
                $userid   = $userdata['uuserid'];

                if (isset($request['addnew'])) {

                    $array[$this->inv['flip']['IsActive']]    = 1;
                    $array[$this->inv['flip']['Status']]      = 0;
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']]   = $userid;

                    $Style = $this->Style->creates($array);

                    $this->_dblog('addnew', $this, $this->StyleName);
                    \Session::put('messagesuccess', "Saving $this->StyleName Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                    $Style = $this->Style->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                    $Style->update($array);

                    $this->_dblog('edit', $this, $this->StyleName);
                    \Session::put('messagesuccess', "Update $this->StyleName Completed !");
                }

                if ($this->StyleImage) {
                    $ImageName                               = 'StyleImage_' . $Style[$this->inv['flip']['StyleID']] . $this->StyleImagefiletype;
                    $array[$this->inv['flip']['StyleImage']] = $ImageName;
                    $Style->update($array);
                    $width = 280;
                    $height = 400;
                    $this->_imagetofolder($this->StyleImage, base_path() . $this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->StyleImage, base_path() . $this->pathimage, 'medium_' . $ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->StyleImage, base_path() . $this->pathimage, 'small_' . $ImageName, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['StyleID']           = $this->StyleID;
        $this->inv['errorStyleID']      = $this->errorStyleID;
        $this->inv['StyleName']         = $this->StyleName;
        $this->inv['errorStyleName']    = $this->errorStyleName;
        $this->inv['StyleImage']        = $this->StyleImage;
        $this->inv['errorStyleImage']   = $this->errorStyleImage;
        $this->inv['Priority']          = $this->Priority;
        $this->inv['errorPriority']     = $this->errorPriority;
        if(!$this->ShowOnHeader) $this->ShowOnHeader = 1;
        $this->inv['ShowOnHeader']      = $this->ShowOnHeader;
        $this->inv['errorShowOnHeader'] = $this->errorShowOnHeader;
        $this->inv['IsActive']          = $this->IsActive;
        $this->inv['errorIsActive']     = $this->errorIsActive;
        $this->inv['Status']            = $this->Status;
        $this->inv['errorStatus']       = $this->errorStatus;
        $this->inv['CreatedDate']       = $this->CreatedDate;
        $this->inv['errorCreatedDate']  = $this->errorCreatedDate;
        $this->inv['CreatedBy']         = $this->CreatedBy;
        $this->inv['errorCreatedBy']    = $this->errorCreatedBy;
        $this->inv['UpdatedDate']       = $this->UpdatedDate;
        $this->inv['errorUpdatedDate']  = $this->errorUpdatedDate;
        $this->inv['UpdatedBy']         = $this->UpdatedBy;
        $this->inv['errorUpdatedBy']    = $this->errorUpdatedBy;
        $this->inv['permalink']         = $this->permalink;
        $this->inv['errorpermalink']    = $this->errorpermalink;

        $arrShowOnHeader = [
            '1' => 'Yes',
            '0' => 'No',
        ];
        $this->inv['arrShowOnHeader'] = $arrShowOnHeader;
        $arrShowOnSubHeader           = [
            '1' => 'Yes',
            '0' => 'No',
        ];
        $this->inv['arrShowOnSubHeader'] = $arrShowOnSubHeader;

        return $this->_showview(["new"]);
    }

    public function priority()
    {
        $url = $this->_accessdata($this, __FUNCTION__, $this->access);
        if ($url) {
            return $this->_redirect($url);
        }

        if (isset($this->inv['getset'])) {
            list($function, $id) = explode('.', $this->inv['getset']);

            $this->_loaddbclass(['Style']);

            $StyleOld = $this->Style->where([['ID', '=', $id]])->first();

            if ($StyleOld) {
                $priorityold = $StyleOld->Priority;

                if ($function == 'up') {
                    $array = array('Priority' => $priorityold - 1);
                    $StyleOld->update($array);
                } else {
                    $array = array('Priority' => $priorityold + 1);
                    $StyleOld->update($array);
                }
            }
        }

        return $this->views();
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
                $Style = $this->Style->where([[$this->objectkey, '=', $val]])->first();
                if ($Style) {
                    $this->StyleName = $Style[$this->inv['flip']['StyleName']];

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['permalink']] = '';

                    if ($Style[$this->inv['flip']['StyleImage']]) {
                        @unlink(base_path() . $this->pathimage . $Style[$this->inv['flip']['StyleImage']]);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $Style[$this->inv['flip']['StyleImage']]);
                        @unlink(base_path() . $this->pathimage . 'small_' . $Style[$this->inv['flip']['StyleImage']]);
                    }

                    $Style->update($array);

                    if (end($this->inv['delete']) != $val) {
                        $br = "<br/>";
                    } else {
                        $br = "";
                    }

                    $this->_dblog('delete', $this, $this->StyleName);
                    $this->inv['messagesuccess'] .= "Delete $this->StyleName Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["dashboard.masterdata.stylelist"])
    {
        $this->_loaddbclass([$this->model]);

        $result = $this->Style->where([['Status', '=', 0]])->orderBy('Priority', 'asc');

        if (isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        } else {
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}
