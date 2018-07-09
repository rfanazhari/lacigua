<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ourbankController extends Controller
{
    public $model = 'OurBank';
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
        'ID'                  => 'OurBankID',
        'BankName'            => 'BankName',
        'BankAccountNumber'   => 'BankAccountNumber',
        'BankBeneficiaryName' => 'BankBeneficiaryName',
        'BankCode'            => 'BankCode',
        'BankLogo'            => 'BankLogo',
        'BankBranch'          => 'BankBranch',
        'IsActive'            => 'IsActive',
        'Status'              => 'Status',
        'CreatedDate'         => 'CreatedDate',
        'CreatedBy'           => 'CreatedBy',
        'UpdatedDate'         => 'UpdatedDate',
        'UpdatedBy'           => 'UpdatedBy',
        'idfunction'          => 'ID',
    ];

    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'           => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'OurBankID'           => ['Our Bank ID'],
        'BankName'            => ['Bank Name', true],
        'BankAccountNumber'   => ['Bank Account Number', true],
        'BankBeneficiaryName' => ['Bank Beneficiary Name', true],
        'BankCode'            => ['Bank Transfer Code', true],
        'BankLogo'            => ['Bank Logo', true, '', 'image'],
        'BankBranch'          => ['Bank Branch', true],
        'IsActive'            => ['Is Active', true],
        'Status'              => ['Status'],
        'CreatedDate'         => ['Created Date'],
        'CreatedBy'           => ['Created By'],
        'UpdatedDate'         => ['Updated Date'],
        'UpdatedBy'           => ['Update By'],
    ];

    var $pathBankLogo = '/resources/assets/frontend/images/content/bank/';
    var $objectkey = '', $OurBankID = '', $errorOurBankID = '', $BankName = '', $errorBankName = '', $BankAccountNumber = '', $errorBankAccountNumber = '', $BankBeneficiaryName    = '', $errorBankBeneficiaryName = '', $BankCode = '', $errorBankCode = '', $BankLogo = '', $errorBankLogo = '', $BankLogofiletype = '', $BankBranch = '', $errorBankBranch = '', $Status = '', $errorStatus = '', $IsActive = '', $errorIsActive = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) exit;

        $request = \Request::instance()->request->all();
        if (isset($request['ajaxpost'])) {
            $id = $request['value'];
            $this->_loaddbclass(['OurBank']);
            $OurBank = $this->OurBank->where([['ID', '=', $id]])->first();
            switch ($request['ajaxpost']) {
                case 'setactive':
                    if ($OurBank) {
                        $IsActive = 1;
                        if ($OurBank->IsActive == 1) $IsActive = 0;

                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $OurBank->update($array);

                        die('OK');
                    } else {
                        die('Error');
                    }
                break;
                case 'deleteBankLogo':
                    if ($OurBank[$this->inv['flip']['BankLogo']]) {
                        @unlink(base_path() . $this->pathimage . $OurBank[$this->inv['flip']['BankLogo']]);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $OurBank[$this->inv['flip']['BankLogo']]);
                        @unlink(base_path() . $this->pathimage . 'small_' . $OurBank[$this->inv['flip']['BankLogo']]);
                        $OurBank->update([$this->inv['flip']['BankLogo'] => '']);
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

        return $this->getdata();
    }

    private function getdata()
    {
        if (isset($this->inv['getid'])) {
            if (!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass([$this->model]);

                $OurBank = $this->OurBank->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if ($OurBank) {

                    $this->OurBankID           = $OurBank[$this->inv['flip']['OurBankID']];
                    $this->BankName            = $OurBank[$this->inv['flip']['BankName']];
                    $this->BankAccountNumber   = $OurBank[$this->inv['flip']['BankAccountNumber']];
                    $this->BankBeneficiaryName = $OurBank[$this->inv['flip']['BankBeneficiaryName']];
                    $this->BankCode            = $OurBank[$this->inv['flip']['BankCode']];

                    if ($OurBank[$this->inv['flip']['BankLogo']]) {
                        $this->BankLogo = $this->inv['basesite'] . str_replace('/resources/', '', $this->pathBankLogo) .
                            'medium_' . $OurBank[$this->inv['flip']['BankLogo']];
                    }

                    $this->BankBranch  = $OurBank[$this->inv['flip']['BankBranch']];
                    $this->Status      = $OurBank[$this->inv['flip']['Status']];
                    $this->IsActive    = $OurBank[$this->inv['flip']['IsActive']];
                    $this->CreatedDate = $OurBank[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy   = $OurBank[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $OurBank[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy   = $OurBank[$this->inv['flip']['UpdatedBy']];

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
                $OurBank = $this->OurBank->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if (!$OurBank) {
                    $this->_redirect('404');
                }
            }

            $this->BankName = $request['BankName'];
            if (empty($this->BankName)) {
                $this->errorBankName = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.OurBank.BankName')]
                );
            }

            $this->BankAccountNumber = $request['BankAccountNumber'];
            if (empty($this->BankAccountNumber)) {
                $this->errorBankAccountNumber = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.OurBank.BankAccountNumber')]
                );
            }

            $this->BankBeneficiaryName = $request['BankBeneficiaryName'];
            if (empty($this->BankBeneficiaryName)) {
                $this->errorBankBeneficiaryName
                 = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.OurBank.BankBeneficiaryName')]
                );
            }

            $this->BankCode = $request['BankCode'];
            if (empty($this->BankCode)) {
                $this->errorBankCode = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.OurBank.BankCode')]
                );
            }

            $this->BankBranch = $request['BankBranch'];
            if (empty($this->BankBranch)) {
                $this->errorBankBranch = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.OurBank.BankBranch')]
                );
            }

            $OurBank = $this->OurBank->where([[$this->inv['flip']['BankName'], '=', $this->BankName],['Status','=',0]])->first();

            if ($OurBank) {
                if (isset($request['addnew']) && strtoupper($OurBank->BankName) == strtoupper($this->BankName)) {
                    if (!$this->errorBankName) {
                        $this->errorBankName = $this->_trans('validation.already',
                            ['value' => $this->_trans('dashboard.masterdata.OurBank.BankName')]
                        );
                    }
                } else {
                    if ($OurBank[$this->objectkey] != $this->inv['getid']) {
                        if (!$this->errorBankName) {
                            $this->errorBankName = $this->_trans('validation.already',
                                ['value' => $this->_trans('dashboard.masterdata.OurBank.BankName')]
                            );
                        }
                    }
                }
            }

            if(isset($requestfile['BankLogo'])) $this->BankLogo = $requestfile['BankLogo'];
            else $this->BankLogo = '';
            if(empty($this->BankLogo) && !(isset($request['edit']) && $OurBank[$this->inv['flip']['BankLogo']])) {
                $this->errorBankLogo = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.OurBank.BankLogo')]
                );
            }
            if($this->BankLogo && !$this->_checkimage($this->BankLogo, $this->BankLogofiletype)) {
                $this->errorBankLogo = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.OurBank.BankLogo')]
                );
            }

            //handling error
            if (!$this->inv['messageerror'] && !$this->errorOurBankID && !$this->errorBankName && !$this->errorBankAccountNumber && !$this->errorBankBeneficiaryName && !$this->errorBankCode && !$this->errorBankLogo && !$this->errorBankBranch && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {

                $array = array(
                    $this->inv['flip']['OurBankID']           => $this->OurBankID,
                    $this->inv['flip']['BankName']            => $this->BankName,
                    $this->inv['flip']['BankAccountNumber']   => $this->BankAccountNumber,
                    $this->inv['flip']['BankBeneficiaryName'] => $this->BankBeneficiaryName,
                    $this->inv['flip']['BankCode']            => $this->BankCode,
                    $this->inv['flip']['BankBranch']          => $this->BankBranch,
                    $this->inv['flip']['IsActive']            => $this->IsActive,
                    $this->inv['flip']['Status']              => $this->Status,
                    $this->inv['flip']['CreatedDate']         => $this->CreatedDate,
                    $this->inv['flip']['CreatedBy']           => $this->CreatedBy,
                    $this->inv['flip']['UpdatedDate']         => $this->UpdatedDate,
                    $this->inv['flip']['UpdatedBy']           => $this->UpdatedBy,
                );

                $userdata = \Session::get('userdata');
                $userid   = $userdata['uuserid'];

                if (isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']]   = $userid;

                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']]   = 0;

                    $OurBank = $this->OurBank->creates($array);

                    $this->_dblog('addnew', $this, $this->BankName);
                    \Session::put('messagesuccess', "Saving $this->BankName Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                    $OurBank = $this->OurBank->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                    $OurBank->update($array);

                    $this->_dblog('edit', $this, $this->BankName);
                    \Session::put('messagesuccess', "Update $this->BankName Completed !");
                }

                if ($this->BankLogo) {
                    $BankLogoname                          = 'bank_' . $OurBank[$this->inv['flip']['OurBankID']] . $this->BankLogofiletype;
                    $array[$this->inv['flip']['BankLogo']] = $BankLogoname;
                    $OurBank->update($array);
                    list($width, $height) = getimagesize($this->BankLogo->GetPathName());

                    $percentage = (100 / $height) * 100;
                    $width = (($width * $percentage) / 100);
                    $height = 100;

                    $this->_imagetofolder($this->BankLogo, base_path() . $this->pathBankLogo, $BankLogoname, $width, $height);
                    $this->_imagetofolder($this->BankLogo, base_path() . $this->pathBankLogo, 'medium_' . $BankLogoname, $width / 3, $height / 3);
                    $this->_imagetofolder($this->BankLogo, base_path() . $this->pathBankLogo, 'small_' . $BankLogoname, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['OurBankID']                = $this->OurBankID;
        $this->inv['errorOurBankID']           = $this->errorOurBankID;
        $this->inv['BankName']                 = $this->BankName;
        $this->inv['errorBankName']            = $this->errorBankName;
        $this->inv['BankAccountNumber']        = $this->BankAccountNumber;
        $this->inv['errorBankAccountNumber']   = $this->errorBankAccountNumber;
        $this->inv['BankBeneficiaryName']      = $this->BankBeneficiaryName;
        $this->inv['errorBankBeneficiaryName'] = $this->errorBankBeneficiaryName;
        $this->inv['BankCode']                 = $this->BankCode;
        $this->inv['errorBankCode']            = $this->errorBankCode;
        $this->inv['BankLogo']                 = $this->BankLogo;
        $this->inv['errorBankLogo']            = $this->errorBankLogo;
        $this->inv['BankBranch']               = $this->BankBranch;
        $this->inv['errorBankBranch']          = $this->errorBankBranch;
        $this->inv['IsActive']                 = $this->IsActive;
        $this->inv['errorIsActive']            = $this->errorIsActive;
        $this->inv['Status']                   = $this->Status;
        $this->inv['errorStatus']              = $this->errorStatus;
        $this->inv['CreatedDate']              = $this->CreatedDate;
        $this->inv['errorCreatedDate']         = $this->errorCreatedDate;
        $this->inv['CreatedBy']                = $this->CreatedBy;
        $this->inv['errorCreatedBy']           = $this->errorCreatedBy;
        $this->inv['UpdatedDate']              = $this->UpdatedDate;
        $this->inv['errorUpdatedDate']         = $this->errorUpdatedDate;
        $this->inv['UpdatedBy']                = $this->UpdatedBy;
        $this->inv['errorUpdatedBy']           = $this->errorUpdatedBy;

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
                $OurBank = $this->OurBank->where([[$this->objectkey, '=', $val]])->first();
                if ($OurBank) {
                    $this->BankName = $OurBank[$this->inv['flip']['BankName']];

                    if ($OurBank->BankLogo) {
                        @unlink(base_path() . $this->pathBankLogo . $OurBank->BankLogo);
                        @unlink(base_path() . $this->pathBankLogo . 'medium_' . $OurBank->BankLogo);
                        @unlink(base_path() . $this->pathBankLogo . 'small_' . $OurBank->BankLogo);
                    }

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']]   = 1;
                    $OurBank->update($array);

                    if (end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->BankName);
                    $this->inv['messagesuccess'] .= "Delete $this->BankName Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"])
    {
        $this->_loaddbclass([$this->model]);

        $result = $this->OurBank->where([['Status', '=', 0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        if (isset($this->inv['getsearchby'])) {
            $this->_dbquerysearch($result, $this->inv['flip']);
        }

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        } else {
            for ($i = 0; $i < count($result['data']); $i++) {
                if ($result['data'][$i][$this->inv['flip']['BankLogo']]) {
                    $result['data'][$i][$this->inv['flip']['BankLogo']] =
                    $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathBankLogo) .
                        'small_' . $result['data'][$i][$this->inv['flip']['BankLogo']];
                }

                $check = '';
                if ($result['data'][$i][$this->inv['flip']['IsActive']] == 1) {
                    $check = 'checked';
                }

                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive ' . $result['data'][$i][$this->inv['flip']['OurBankID']] . '" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" ' . $check . ' rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]) . '">';

            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}
