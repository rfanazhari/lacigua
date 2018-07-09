<?php

namespace App\Modules\dashboard\Http\Controllers\userteam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class usergrouppatternController extends Controller
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
    // Set idfunction => UNIQUEID for edit, detail, delete and etc
    public $alias = [
        'idGroupPattern' => 'grouppatternid',
        'idGroup' => 'groupid',
        'namaGroup' => 'groupname',
        'pattern' => 'pattern',
        'idfunction' => 'idGroupPattern',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage' => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'grouppatternid' => array('Group Pattern ID'),
        'groupid' => array('Group ID'),
        'groupname' => array('Group Name', true),
        'pattern' => array('Pattern', true),
    ];

    var $objectkey = '', $grouppatternid = '', $errorgrouppatternid = '', $groupid = '', $errorgroupid = '', $groupname = '', $errorgroupname = '', $pattern = '', $errorpattern = '', $optmenu = '';
    var $optarr = [];

    private function _getfunction(&$arraydata) {
        foreach ($arraydata as $keydata => &$valdata) {
            if($valdata['menu'] != 2) {
                $class = null;
                switch ($valdata['menu']) {
                    case 1:
                        $class = '\App\Modules\\'.$valdata['permalink'].'\Http\Controllers\\'.$valdata['permalink'].'Controller';
                        break;
                    case 3:
                        $route = explode('/', $valdata['route']);
                        $class = '\App\Modules\\'.$route[0].'\Http\Controllers\\'.$route[1].'\\'.$valdata['permalink'].'Controller';
                        break;
                    case 4:
                        $class = '\App\Modules\\'.str_replace('/', '', $valdata['route']).'\Http\Controllers\\'.$valdata['permalink'].'Controller';
                        break;
                }
                if (class_exists($class)) {
                    $class = new $class;
                    $class = new \ReflectionClass($class);
                    $access = [];
                    foreach ($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method)
                        if ($method->class == $class->getName())
                             $access[] = $method->name;
                    $valdata['access'] = $access;
                } else {
                    $valdata['access'] = [];
                }
            }
            if(isset($valdata[$valdata['permalink']]) && is_array($valdata[$valdata['permalink']]) && count($valdata[$valdata['permalink']])) {
                $this->_getfunction($valdata[$valdata['permalink']]);
            }
        }
    }

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'getaccess' :
                    $permalinkgroup = $request['value'];
                    $action = $request['action'];
                    $optmenu = json_decode($request['optmenu'], 1);
                    if($action == 'addnew' && !$optmenu) $optmenu = 'all';

                    $this->_loaddbclass([ 'MasterGroup','MasterMenu','MasterMenuAccess' ]);

                    $MasterGroup = $this->MasterGroup->where([['permalink','=',$permalinkgroup]])->first();

                    $arrmenu = $this->MasterMenu->getmenu(['idMParrent','=',0])->get()->toArray();
                    $arrmenu = $this->MasterMenuAccess->getmenuextends([$arrmenu,['idGroup','=',$MasterGroup->idGroup]]);

                    $this->_getfunction($arrmenu);
                    
                    die(view('dashboard.userteam.listmenu1', [
                        'arrmenu'=> $arrmenu, 'optmenu'=> $optmenu
                    ])->render());
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
                $this->_loaddbclass([ 'MasterGroup', 'MasterGroupPattern' ]);
                
                $MasterGroupPattern = $this->MasterGroupPattern->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($MasterGroupPattern) {
                    $MasterGroup = $this->MasterGroup->where([[$this->inv['flip']['groupid'],'=',$MasterGroupPattern[$this->inv['flip']['groupid']]]])->first();
                    $this->groupname      = $MasterGroup->permalink;
                    foreach (json_decode($MasterGroupPattern->pattern, 1) as $key => $val) {
                        $this->optmenu[$key] = $val;
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

    private function addnewedit() {
        $request = \Request::instance()->request->all();
        $requestfile = \Request::file();

        $this->_loaddbclass([ 'MasterGroup' ]);

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([ 'MasterGroupPattern' ]);

            if(isset($request['edit'])) {
                $MasterGroupPattern = $this->MasterGroupPattern->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$MasterGroupPattern) {
                    $this->_redirect('404');
                }
            }

            $this->groupname = $request['groupname'];
            if(empty($this->groupname)) { $this->errorgroupname = 'Silahkan pilih '.$this->aliasform['groupname'][0].' !'; }
            else if($this->_checkpermalink($this->groupname)) { $this->_redirect('404'); }
            
            if(isset($request['optmenu'])) $this->optmenu = $request['optmenu'];
            else {
                $this->inv['messageerror'] = 'Silahkan pilih Function for this Group !!!';
            }

            if(!$this->inv['messageerror'] && !$this->errorgrouppatternid && !$this->errorgroupid && !$this->errorgroupname && !$this->errorpattern) {
                $this->_loaddbclass([ 'MasterGroup' ]);
                $MasterGroup = $this->MasterGroup->where([['permalink','=',$this->groupname]])->first();

                $arraypattern = [];
                foreach ($this->optmenu as $key => $val) {
                    $arraypattern[$key] = $val;
                }
                $arraypattern = [
                    'idGroup' => $MasterGroup->idGroup,
                    'pattern' => json_encode($arraypattern, JSON_FORCE_OBJECT)
                ];

                if(isset($request['addnew'])) {
                    $this->MasterGroupPattern->creates($arraypattern);
                    
                    $this->_dblog('addnew', $this, $MasterGroup[$this->inv['flip']['groupname']]);
                    \Session::put('messagesuccess', "Saving ".$MasterGroup[$this->inv['flip']['groupname']]." Completed !");
                } else {
                    $this->MasterGroupPattern->where([[$this->objectkey,'=',$this->inv['getid']]])->delete();
                    $this->MasterGroupPattern->creates($arraypattern);
                    
                    $this->_dblog('edit', $this, $MasterGroup[$this->inv['flip']['groupname']]);
                    \Session::put('messagesuccess', "Update ".$MasterGroup[$this->inv['flip']['groupname']]." Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $arrgroup = $this->MasterGroup->getmodel()->orderBy($this->inv['flip']['groupname'],'ASC')->get()->toArray();
        
        $this->inv['arrgroup']              = $arrgroup;
        $this->inv['grouppatternid']        = $this->grouppatternid;
        $this->inv['errorgrouppatternid']   = $this->errorgrouppatternid;
        $this->inv['groupid']               = $this->groupid;
        $this->inv['errorgroupid']          = $this->errorgroupid;
        $this->inv['groupname']             = $this->groupname;
        $this->inv['errorgroupname']        = $this->errorgroupname;
        $this->inv['pattern']               = $this->pattern;
        $this->inv['errorpattern']          = $this->errorpattern;
        $this->inv['optmenu']               = $this->optmenu;
        $this->inv['optarr']                = $this->optarr;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([ 'MasterGroup', 'MasterGroupPattern' ]);

            foreach($this->inv['delete'] as $val) {
                $MasterGroupPattern = $this->MasterGroupPattern->where([[$this->objectkey,'=',$val]])->first();
                if($MasterGroupPattern) {
                    $MasterGroup = $this->MasterGroup->where([[$this->inv['flip']['groupid'],'=',$MasterGroupPattern[$this->inv['flip']['groupid']]]])->first();
                    $this->groupname      = $MasterGroup[$this->inv['flip']['groupname']];

                    $MasterGroupPattern->delete();

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $MasterGroup[$this->inv['flip']['groupname']]);
                    $this->inv['messagesuccess'] .= "Delete ".$MasterGroup[$this->inv['flip']['groupname']]." Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'MasterGroupPattern' ]);

        $result = $this->MasterGroupPattern->leftjoin([
            ['master_group','master_group.'.$this->inv['flip']['groupid'],'=','master_group_pattern.'.$this->inv['flip']['groupid']]
        ])->select([
            'master_group.'.$this->inv['flip']['groupname'],
            'master_group_pattern.*'
        ])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $result['data'][$i][$this->inv['flip']['pattern']] = '<a class="btn btn-small green" href="'.$this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].$this->inv['extlink'].'/edit/id_'.$result['data'][$i][$this->inv['flip']['grouppatternid']].'">See Pattern</a>';
            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}