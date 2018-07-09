<?php

namespace App\Modules\dashboard\Http\Controllers\userteam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class userlogController extends Controller
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
    // Set idfunction => UNIQUEID for edit, detail, delete and etc
    public $alias = [
        'dateLog'       => 'logdate',
        'idGroup'       => 'groupid',
        'namaGroup'     => 'groupname',
        'idUser'        => 'userid',
        'username'      => 'vusername',
        'pageLog'       => 'logpage',
        'actionLog'     => 'logaction',
        'descLog'       => 'logdesc',
        'idfunction'    => 'idUserLog',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage' => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'logdate'   => ['Date LOG', true, 'width:190px;'],
        'groupname' => ['Group Name', true, 'width:140px;'],
        'vusername' => ['Username', true, 'width:120px;'],
        'logpage'   => ['Page LOG', true, 'width:120px;'],
        'logaction' => ['Action LOG', true, 'width:120px;'],
        'logdesc'   => ['Description LOG', true],
    ];

    var $objectkey = '';

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->views();
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([ 'MasterUserLog' ]);

            foreach($this->inv['delete'] as $val) {
                $MasterUserLog = $this->MasterUserLog->where([[$this->objectkey,'=',$val,]])->first();
                if($MasterUserLog) {
                    $logdesc    = $MasterUserLog[$this->inv['flip']['logdesc']];
                    $date       = $this->_datetimeforhtml($MasterUserLog[$this->inv['flip']['logdate']], 'red');
                    $MasterUserLog->delete();

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('log', $this, $logdesc);
                    $this->inv['messagesuccess'] .= "Delete $date Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'MasterUserLog' ]);

        $result = $this->MasterUserLog->leftjoin([
            ['master_group','master_group.'.$this->inv['flip']['groupid'],'=','master_user_log.'.$this->inv['flip']['groupid']],
            ['master_user','master_user.'.$this->inv['flip']['userid'],'=','master_user_log.'.$this->inv['flip']['userid']]
        ])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $result['data'][$i][$this->inv['flip']['logdate']] = $this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['logdate']], 'red');
            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}