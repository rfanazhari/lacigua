<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class colorsController extends Controller
{
    public $model = 'Color';
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
        'ID'          => 'ColorID',
        'Name'        => 'Name',
        'Hexa'        => 'Hexa',
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
        'titlepage'   => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'ColorID'     => ['ID'],
        'Name'        => ['Name', true],
        'Hexa'        => ['Color Picker', true],
        'IsActive'    => ['Is Active', true],
        'Status'      => ['Status'],
        'CreatedDate' => ['CreatedDate'],
        'CreatedBy'   => ['CreatedBy'],
        'UpdatedDate' => ['UpdatedDate'],
        'UpdatedBy'   => ['UpdatedBy'],
        'permalink'   => ['permalink'],
    ];

    //var $pathimage = '/resources/assets/backend/images/userdetail/'; //kalau  gak ada image remark aja (buat path images)

    public $objectkey = '', $ColorID = '', $errorColorID = '', $Name = '', $errorName = '', $Hexa = '', $errorHexa = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';

    //var $optmenu = []; // buat transaksi, klo gak ada transaksi remark aja

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

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) {
            exit;
        }

        $request = \Request::instance()->request->all();
        if (isset($request['ajaxpost'])) {
            switch ($request['ajaxpost']) {
                case 'setactive':
                    $id = $request['value'];

                    $this->_loaddbclass([$this->model]);

                    $Color = $this->Color->where([['ID', '=', $id]])->first();

                    if ($Color) {
                        $this->Name = $Color[$this->inv['flip']['Name']];

                        $IsActive = 1;
                        if ($Color->IsActive == 1) {
                            $IsActive = 0;
                        }

                        $userdata = \Session::get('userdata');
                        $userid   = $userdata['uuserid'];

                        $array[$this->inv['flip']['IsActive']]    = $IsActive;
                        $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                        $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                        $Color->update($array);

                        if ($IsActive) {
                            $IsActive = 'Active';
                        } else {
                            $IsActive = 'Non Active';
                        }

                        $this->_dblog('edit', $this, 'Set ' . $IsActive . ' ' . $this->Name);

                        die('OK');
                    } else {
                        die('Error');
                    }

                    break;
            }
        }
    }

    private function getdata()
    {
        if (isset($this->inv['getid'])) {
            if (!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass([$this->model]);

                $Color = $this->Color->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if ($Color) {
                    $this->ColorID     = $Color[$this->inv['flip']['ColorID']];
                    $this->Name        = $Color[$this->inv['flip']['Name']];
                    $this->Hexa        = $Color[$this->inv['flip']['Hexa']];
                    $this->IsActive    = $Color[$this->inv['flip']['IsActive']];
                    $this->Status      = $Color[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Color[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy   = $Color[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Color[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy   = $Color[$this->inv['flip']['UpdatedBy']];
                    $this->permalink   = $Color[$this->inv['flip']['permalink']];

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
                $Color = $this->Color->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if (!$Color) {
                    $this->_redirect('404');
                }
            }

            $this->Name = $request['Name'];
            if (empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.Color.Name')]
                );
            }

            $this->Hexa = $request['Hexa'];
            if (empty($this->Hexa)) {
                $this->errorHexa = $this->_trans('validation.mandatory',
                    ['value' => $this->_trans('dashboard.masterdata.Color.Hexa')]
                );
            }

            $Color = $this->Color->where([[$this->inv['flip']['Hexa'],'=',$this->Hexa]])->first();
            if($Color) {
                if(isset($request['addnew']) && strtoupper($Color[$this->inv['flip']['Hexa']]) == strtoupper($this->Hexa)) {
                    if(!$this->errorHexa) {
                        $this->errorHexa = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.Color.Hexa')]
                        );
                    }
                } else {
                    if (isset($this->inv['getid']) && $Color[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorHexa) {
                            $this->errorHexa = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.Color.Hexa')]
                            );
                        }
                    }
                }
            }

            //handling error
            if (!$this->inv['messageerror'] && !$this->errorColorID && !$this->errorName && !$this->errorHexa && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {

                $array = array(
                    $this->inv['flip']['ColorID']   => $this->ColorID,
                    $this->inv['flip']['Name']      => $this->Name,
                    $this->inv['flip']['Hexa']      => $this->Hexa,
                    $this->inv['flip']['IsActive']  => $this->IsActive,
                    $this->inv['flip']['Status']    => $this->Status,
                    $this->inv['flip']['permalink'] => $this->_permalink($this->Name),
                );

                $userdata = \Session::get('userdata');
                $userid   = $userdata['uuserid'];

                if (isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']]   = $userid;

                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']]   = 0;

                    $Color = $this->Color->creates($array);

                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']]   = $userid;

                    $Color = $this->Color->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                    $Color->update($array);

                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['ColorID']          = $this->ColorID;
        $this->inv['errorColorID']     = $this->errorColorID;
        $this->inv['Name']             = $this->Name;
        $this->inv['errorName']        = $this->errorName;
        $this->inv['Hexa']             = $this->Hexa;
        $this->inv['errorHexa']        = $this->errorHexa;
        $this->inv['IsActive']         = $this->IsActive;
        $this->inv['errorIsActive']    = $this->errorIsActive;
        $this->inv['Status']           = $this->Status;
        $this->inv['errorStatus']      = $this->errorStatus;
        $this->inv['CreatedDate']      = $this->CreatedDate;
        $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy']        = $this->CreatedBy;
        $this->inv['errorCreatedBy']   = $this->errorCreatedBy;
        $this->inv['UpdatedDate']      = $this->UpdatedDate;
        $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy']        = $this->UpdatedBy;
        $this->inv['errorUpdatedBy']   = $this->errorUpdatedBy;
        $this->inv['permalink']        = $this->permalink;
        $this->inv['errorpermalink']   = $this->errorpermalink;

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
                $Color = $this->Color->where([[$this->objectkey, '=', $val]])->first();
                if ($Color) {
                    $this->Name = $Color[$this->inv['flip']['Name']];

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['permalink']] = '';

                    $Color->update($array);

                    if (end($this->inv['delete']) != $val) {
                        $br = "<br/>";
                    } else {
                        $br = "";
                    }

                    $this->_dblog('delete', $this, $this->Name);
                    $this->inv['messagesuccess'] .= "Delete $this->Name Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"])
    {
        $this->_loaddbclass([$this->model]);

        $result = $this->Color->where([['Status', '=', 0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        if (isset($this->inv['getsearchby'])) {
            $this->_dbquerysearch($result, $this->inv['flip']);
        }

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        } else {
            for ($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                if ($result['data'][$i][$this->inv['flip']['IsActive']] == 1) {
                    $check = 'checked';
                }

                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive ' . $result['data'][$i][$this->inv['flip']['ColorID']] . '" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" ' . $check . ' rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]) . '">';

                $check = '';
                if ($result['data'][$i][$this->inv['flip']['Hexa']] == 1) {
                    $check = 'checked';
                }

                $result['data'][$i][$this->inv['flip']['Hexa']] = '<div class="col-md-1" style="height:25px;border:1px solid grey;background-color:' . $result['data'][$i][$this->inv['flip']['Hexa']] . '"></div>';

            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}
