<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class paymenttypeController extends Controller
{

    public $model = 'PaymentType';
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
        'ID' => 'PaymentTypeID',
        'Type' => 'Type',
        'OurBankID' => 'OurBankID',
        'OurBankName' => 'OurBankName',
        'Name' => 'Name',
        'Notes' => 'Notes',
        'Image' => 'Image',
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
        'PaymentTypeID' => ['Payment Type ID'],
        'Type' => ['Type Payment', true],
        'OurBankID' => ['Our Bank ID'],
        'OurBankName' => ['Our Bank Name'],
        'Name' => ['Payment Type Name', true],
        'Notes' => ['Notes'],
        'Image' => ['Logo', true, '','image'],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Update Date'],
        'UpdatedBy' => ['Update By'],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/paymenttype/';
    var $arrtype = [
        0 => 'Bank Transfer',
        1 => 'Virtual Account',
        2 => 'Internet Banking',
        3 => 'Credit Card / Virtual Card',
        4 => 'Another / Gerai'
    ];

    public $objectkey = '', $PaymentTypeID = '', $errorPaymentTypeID = '', $Type = '', $errorType = '', $OurBankID = '', $errorOurBankID = '', $Name = '', $errorName = '', $Notes = '', $errorNotes = '', $Image = '', $errorImage = '', $Imagefiletype, $Status = '', $errorStatus = '', $IsActive = '', $errorIsActive = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) { exit; }

        $request = \Request::instance()->request->all();
        if (isset($request['ajaxpost'])) {
            if($request['ajaxpost'] != 'GetOurBank') {
                $id = $request['value'];
                $this->_loaddbclass(['PaymentType']);
                $PaymentType = $this->PaymentType->where([['ID', '=', $id]])->first();
            }
            switch ($request['ajaxpost']) {
                case 'setactive':
                    if ($PaymentType) {
                        $IsActive = 1;
                        if ($PaymentType->IsActive == 1) {
                            $IsActive = 0;
                        }

                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $PaymentType->update($array);

                        die('OK');
                    } else {
                        die('Error');
                    }
                break;
                case 'deleteImage':
                    if ($PaymentType[$this->inv['flip']['Image']]) {
                        @unlink(base_path() . $this->pathimage . $PaymentType[$this->inv['flip']['Image']]);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $PaymentType[$this->inv['flip']['Image']]);
                        @unlink(base_path() . $this->pathimage . 'small_' . $PaymentType[$this->inv['flip']['Image']]);
                        $PaymentType->update([$this->inv['flip']['Image'] => '']);
                    }
                break;
                case 'GetOurBank' :
                    $this->_loaddbclass([ 'OurBank' ]);

                    $OurBank = $this->OurBank->where([['Status','=',0],['IsActive','=',1]])->get()->toArray();

                    if(count($OurBank)) die(json_encode(['response' => 'OK', 'data' => $OurBank], JSON_FORCE_OBJECT));
                    else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
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
                $this->_loaddbclass([$this->model]);

                $PaymentType = $this->PaymentType->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if ($PaymentType) {
                    $this->PaymentTypeID = $PaymentType[$this->inv['flip']['PaymentTypeID']];
                    $this->Type          = $PaymentType[$this->inv['flip']['Type']];
                    $this->OurBankID     = $PaymentType[$this->inv['flip']['OurBankID']];
                    $this->Name          = $PaymentType[$this->inv['flip']['Name']];
                    $this->Notes         = $PaymentType[$this->inv['flip']['Notes']];
                    $this->IsActive      = $PaymentType[$this->inv['flip']['IsActive']];
                    $this->Status        = $PaymentType[$this->inv['flip']['Status']];
                    $this->CreatedDate   = $PaymentType[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy     = $PaymentType[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate   = $PaymentType[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy     = $PaymentType[$this->inv['flip']['UpdatedBy']];

                    if ($PaymentType[$this->inv['flip']['Image']]) {
                        $this->Image = $this->inv['basesite'] . str_replace('/resources/', '', $this->pathimage) .
                            'medium_' . $PaymentType[$this->inv['flip']['Image']];
                    }
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
                $PaymentType = $this->PaymentType->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if (!$PaymentType) {
                    $this->_redirect('404');
                }
            }

            $this->Type = $request['Type'];
            if (!is_numeric($this->Type)) {
                $this->errorType = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.PaymentType.Type')]
                );
            }

            $this->OurBankID = $request['OurBankID'];
            if (is_numeric($this->Type) && $this->Type == 0 && !is_numeric($this->OurBankID)) {
                $this->errorOurBankID = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.PaymentType.OurBankID')]
                );
            }

            $this->Name = $request['Name'];
            if (empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.PaymentType.Name')]
                );
            }

            $PaymentType = $this->PaymentType->where([[$this->inv['flip']['Type'],'=',$this->Type],[$this->inv['flip']['Name'],'=',$this->Name],['Status','=',0]])->first();

            if($PaymentType) {
                if(isset($request['addnew']) && strtoupper($PaymentType[$this->inv['flip']['Name']]) == strtoupper($this->Name) && $PaymentType[$this->inv['flip']['Type']] == $this->Type) {
                    if(!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.PaymentType.Name')]
                        );
                    }
                } else {
                    if ($PaymentType[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.PaymentType.Name')]
                            );
                        }
                    }
                }
            }

            $this->Notes = $request['Notes'];
            if (empty($this->Notes)) {
                $this->errorNotes = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.PaymentType.Notes')]
                );
            }

            if (isset($requestfile['Image'])) {
                $this->Image = $requestfile['Image'];
            } else {
                $this->Image = '';
            }

            if (empty($this->Image) && !(isset($request['edit']) && $PaymentType[$this->inv['flip']['Image']])) {
                $this->errorImage = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.PaymentType.Image')]
                );
            }
            if ($this->Image && !$this->_checkimage($this->Image, $this->Imagefiletype)) {
                $this->errorImage = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.PaymentType.Image')]
                );
            }

            if (!$this->inv['messageerror'] && !$this->errorPaymentTypeID && !$this->errorType && !$this->errorOurBankID && !$this->errorName && !$this->errorNotes && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {
                $array = array(
                    $this->inv['flip']['PaymentTypeID'] => $this->PaymentTypeID,
                    $this->inv['flip']['Type']          => $this->Type,
                    $this->inv['flip']['OurBankID']     => $this->OurBankID,
                    $this->inv['flip']['Name']          => $this->Name,
                    $this->inv['flip']['Notes']         => $this->Notes,
                    $this->inv['flip']['IsActive']      => $this->IsActive,
                    $this->inv['flip']['Status']        => $this->Status,
                );

                $userdata = \Session::get('userdata');
                $userid   = $userdata['uuserid'];

                if (isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']]   = $userid;

                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']]   = 0;

                    $PaymentType = $this->PaymentType->creates($array);

                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                    $PaymentType = $this->PaymentType->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                    $PaymentType->update($array);

                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                if ($this->Image) {
                    $ImageName = 'Image_' . $PaymentType[$this->inv['flip']['PaymentTypeID']] . $this->Imagefiletype;
                    $array[$this->inv['flip']['Image']] = $ImageName;
                    $PaymentType->update($array);
                    list($width, $height) = getimagesize($this->Image->GetPathName());

                    $percentage = (100 / $height) * 100;
                    $width = (($width * $percentage) / 100);
                    $height = 100;

                    $this->_imagetofolder($this->Image, base_path() . $this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolder($this->Image, base_path() . $this->pathimage, 'medium_' . $ImageName, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Image, base_path() . $this->pathimage, 'small_' . $ImageName, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['arrtype'] = $this->arrtype;
        $this->inv['PaymentTypeID'] = $this->PaymentTypeID; $this->inv['errorPaymentTypeID'] = $this->errorPaymentTypeID;
        $this->inv['Type'] = $this->Type; $this->inv['errorType'] = $this->errorType;
        $this->inv['OurBankID'] = $this->OurBankID; $this->inv['errorOurBankID'] = $this->errorOurBankID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['Notes'] = $this->Notes; $this->inv['errorNotes'] = $this->errorNotes;
        $this->inv['Image'] = $this->Image; $this->inv['errorImage'] = $this->errorImage;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $arrourbank = [];
        if(is_numeric($this->Type) && $this->Type == 0) {
            $this->_loaddbclass(['OurBank']);
            $arrourbank = $this->OurBank->where([['IsActive','=',1],['Status','=',0]])->get();
        }
        $this->inv['arrourbank'] = $arrourbank;

        return $this->_showview(["new"]);
    }

    private function views($views = ["defaultview"])
    {
        $this->_loaddbclass([$this->model]);

        $result = $this->PaymentType->where([['Status', '=', 0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        if (isset($this->inv['getsearchby'])) {
            $this->_dbquerysearch($result, $this->inv['flip']);
        }

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        } else {
            for ($i = 0; $i < count($result['data']); $i++) {
                if(is_numeric($result['data'][$i][$this->inv['flip']['Type']]))
                    $result['data'][$i][$this->inv['flip']['Type']] = $this->arrtype[$result['data'][$i][$this->inv['flip']['Type']]];

                $check = '';
                if ($result['data'][$i][$this->inv['flip']['IsActive']] == 1) {
                    $check = 'checked';
                }

                if ($result['data'][$i][$this->inv['flip']['Image']]) {
                    $result['data'][$i][$this->inv['flip']['Image']] =
                    $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) .
                        'small_' . $result['data'][$i][$this->inv['flip']['Image']];
                }

                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive ' . $result['data'][$i][$this->inv['flip']['PaymentTypeID']] . '" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" ' . $check . ' rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]) . '">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}
