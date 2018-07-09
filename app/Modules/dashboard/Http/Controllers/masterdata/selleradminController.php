<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class selleradminController extends Controller
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
        'idUser'    => 'userid',
        'idGroup'   => 'groupid',
        'namaGroup' => 'groupname',
        'username'  => 'vusername',
        'pass'      => 'vpassword',
        'name'      => 'vname',
        'imagepath' => 'vimage',
        'imagesignature' => 'signatureimage',
        'address'   => 'vaddress',
        'phone'     => 'vphone',
        'mobile'    => 'vmobile',
        'email'     => 'vemail',
        'dateCreate'=> 'createdate',
        'loginDate' => 'datelogin',
        'statususer' => 'userstatus',
        'permalink' => 'permalink',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'groupname'     => array('Group Name', true, 'width:140px;'),
        'vusername'     => array('User Name', true),
        'vpassword'     => array('Password'),
        'vname'         => array('Name', true),
        'vimage'        => array('Picture', true, '', 'image'),
        'signatureimage' => array('Signature'),
        'vaddress'      => array('Address'),
        'vphone'        => array('Phone'),
        'vmobile'       => array('Mobile'),
        'vemail'        => array('Email', true, 'width:100px;'),
        'datelogin'     => array('Login Date', true, 'width:190px;'),
        'userstatus'     => array('Status', true),
    ];

    var $pathimage = '/resources/assets/backend/images/userdetail/';
    var $objectkey = '', $groupname = '', $errorgroupname = '', $vusername = '', $errorvusername = '', $vpassword = '', $errorvpassword = '', $repassword = '', $errorrepassword = '', $vname = '', $errorvname = '', $vmobile = '', $errorvmobile = '', $vemail = '', $errorvemail = '', $vphone = '', $errorvphone = '', $vaddress = '', $vimage = '', $errorvimage = '', $signatureimage = '', $errorsignatureimage = '', $userstatus = '', $vimagefiletype = '', $signatureimagefiletype = '';
    var $optmenu = [];

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
                        if ($method->class == $class->getName()) {
                            if($valdata['permalink'] == 'product') {
                                if(!in_array($method->name, ['popup','ajaxpost','index'])) continue;
                                else $access[] = $method->name;
                            } else $access[] = $method->name;
                        }
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

                    $this->_loaddbclass([ 'MasterGroup','MasterGroupPattern','MasterMenu','MasterMenuAccess' ]);

                    $MasterGroup = $this->MasterGroup->where([['permalink','=',$permalinkgroup]])->first();

                    if(!$optmenu) {
                        $MasterGroupPattern = $this->MasterGroupPattern->where([['idGroup','=',$MasterGroup->idGroup]])->first();
                        if($MasterGroupPattern) {
                            foreach (json_decode($MasterGroupPattern->pattern, 1) as $key => $val) {
                                $optmenu[$key] = $val;
                            }
                        }
                    }

                    if($action == 'addnew' && !$optmenu) $optmenu = 'all';

                    $arrmenu = $this->MasterMenu->getmenu(['idMParrent','=',0])->get()->toArray();
                    $arrmenu = $this->MasterMenuAccess->getmenuextends([$arrmenu,['idGroup','=',$MasterGroup->idGroup]]);

                    $this->_getfunction($arrmenu);
                    
                    die(view('dashboard.userteam.listmenu1', [
                        'arrmenu'=> $arrmenu, 'optmenu'=> $optmenu
                    ])->render());
                break;
                case 'deleteimage' :
                    $id = $request['id'];
                    
                    $this->_loaddbclass([ 'MasterUser' ]);

                    $MasterUser = $this->MasterUser->where([['permalink', '=', $id]])->first();

                    if($MasterUser[$this->inv['flip']['vimage']]) {
                        @unlink(base_path().$this->pathimage.$MasterUser[$this->inv['flip']['vimage']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$MasterUser[$this->inv['flip']['vimage']]);
                        @unlink(base_path().$this->pathimage.'small_'.$MasterUser[$this->inv['flip']['vimage']]);
                        
                        $MasterUser->update(['imagepath' => '']);
                    }
                    exit;
                break;
                case 'deletesignature' :
                    $id = $request['id'];
                    
                    $this->_loaddbclass([ 'MasterUser' ]);

                    $MasterUser = $this->MasterUser->where([['permalink', '=', $id]])->first();

                    if($MasterUser[$this->inv['flip']['signatureimage']]) {
                        @unlink(base_path().$this->pathimage.'signature_'.$MasterUser[$this->inv['flip']['signatureimage']]);
                        @unlink(base_path().$this->pathimage.'signature_medium_'.$MasterUser[$this->inv['flip']['signatureimage']]);
                        @unlink(base_path().$this->pathimage.'signature_small_'.$MasterUser[$this->inv['flip']['signatureimage']]);
                        
                        $MasterUser->update(['imagesignature' => '']);
                    }
                    exit;
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
                $this->_loaddbclass([ 'MasterUser','MasterGroup' ]);

                $MasterUser = $this->MasterUser->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($MasterUser) {
                    $MasterGroup = $this->MasterGroup->where([[$this->inv['flip']['groupid'],'=',$MasterUser[$this->inv['flip']['groupid']]]])->first();
                    $this->groupname      = $MasterGroup->permalink;
                    $this->vusername      = $MasterUser[$this->inv['flip']['vusername']];
                    $this->vpassword      = '';
                    $this->repassword     = $this->vpassword;
                    $this->vname          = $MasterUser[$this->inv['flip']['vname']];
                    if($MasterUser[$this->inv['flip']['signatureimage']])
                    $this->signatureimage = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                                            'signature_medium_'.$MasterUser[$this->inv['flip']['signatureimage']];
                    if($MasterUser[$this->inv['flip']['vimage']])
                    $this->vimage         = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                                            'medium_'.$MasterUser[$this->inv['flip']['vimage']];
                    $this->vaddress       = $MasterUser[$this->inv['flip']['vaddress']];
                    $this->vphone         = $MasterUser[$this->inv['flip']['vphone']];
                    $this->vmobile        = $MasterUser[$this->inv['flip']['vmobile']];
                    $this->vemail         = $MasterUser[$this->inv['flip']['vemail']];
                    $this->userstatus     = $MasterUser[$this->inv['flip']['userstatus']];

                    $this->_loaddbclass([ 'MasterUserAccess' ]);

                    $MasterUserAccess      = $this->MasterUserAccess->join([
                        ['master_menu', 'master_menu.idMMenu', '=', 'master_user_access.idMMenu']
                    ])->where([[$this->inv['flip']['userid'],'=',$MasterUser[$this->inv['flip']['userid']]]])
                    ->select(['master_menu.idMMenu', 'permalink', 'access'])->get()->toArray();

                    if($MasterUserAccess) {
                        foreach ($MasterUserAccess as $val) {
                            $this->optmenu[$val['permalink'].'-'.$val['idMMenu']] = json_decode($val['access'], 1);
                        }
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

        $this->_loaddbclass([ 'Seller','MasterGroup' ]);

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([ 'MasterUser' ]);

            if(isset($request['edit'])) {
                $MasterUser = $this->MasterUser->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$MasterUser) {
                    $this->_redirect('404');
                }
            }

            $this->groupname = $request['groupname'];
            if(empty($this->groupname)) { $this->errorgroupname = 'Silahkan pilih '.$this->aliasform['groupname'][0].' !'; }
            else if($this->_checkpermalink($this->groupname)) { $this->_redirect('404'); }
            
            $this->vusername = $request['vusername'];
            if(empty($this->vusername)) { $this->errorvusername = 'Silahkan masukkan '.$this->aliasform['vusername'][0].' !'; }
            else if($this->_numberscharacters($this->vusername) && $this->_email($this->vusername)) { $this->errorvusername = 'Format '.$this->aliasform['vusername'][0].' diperbolehkan 0-9, a-Z atau format email !'; }
            
            $MasterUser = $this->MasterUser->where([[$this->inv['flip']['vusername'],'=',$this->vusername]])->first();

            if($MasterUser) {
                if(isset($request['addnew']) && $MasterUser[$this->inv['flip']['vusername']] == $this->_permalink($this->vusername)) {
                    if(!$this->errorvusername) {
                        $this->errorvusername = $this->aliasform['vusername'][0].' is already used !!!';
                    }
                } else {
                    if ($MasterUser[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorvusername) {
                            $this->errorvusername = $this->aliasform['vusername'][0].' is already used !!!';
                        }
                    }
                }
            }

            if (isset($request['addnew']) || $request['vpassword'] || $request['repassword']) {
                $this->vpassword = $request['vpassword'];
                $this->repassword = $request['repassword'];
                if(empty($this->vpassword)) { $this->errorvpassword = 'Silahkan masukkan '.$this->aliasform['vpassword'][0].' !'; }
                if(empty($this->repassword)) { $this->errorrepassword = 'Silahkan masukkan RePasswrod !'; }
                else if(!empty($this->repassword) && $this->repassword != $this->vpassword) { $this->errorrepassword = $this->aliasform['vpassword'][0].' tidak sesuai !'; }
            }

            $this->vname = $request['vname'];
            if(empty($this->vname)) { $this->errorvname = 'Silahkan masukkan '.$this->aliasform['vname'][0].' !'; }
            else if($this->_charactersspace($this->vname)) { $this->errorvname = 'Format '.$this->aliasform['vname'][0].' diperbolehkan a-Z, spasi !'; }
            
            $MasterUser = $this->MasterUser->where([[$this->inv['flip']['vname'],'=',$this->vname]])->first();

            if($MasterUser) {
                if(isset($request['addnew']) && $MasterUser->permalink == $this->_permalink($this->vname)) {
                    if(!$this->errorvname) {
                        $this->errorvname = $this->aliasform['vname'][0].' is already used !!!';
                    }
                } else {
                    if ($MasterUser[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorvname) {
                            $this->errorvname = $this->aliasform['vname'][0].' is already used !!!';
                        }
                    }
                }
            }

            $this->vaddress = $request['vaddress'];
            
            $this->vphone = $request['vphone'];
            if($this->_numbersonly($this->vphone)) { $this->errorvphone = 'Format '.$this->aliasform['vphone'][0].' diperbolehkan 0-9 !'; }
            
            $this->vmobile = $request['vmobile'];
            if(empty($this->vmobile)) { $this->errorvmobile = 'Silahkan masukkan '.$this->aliasform['vmobile'][0].' !'; }
            else if($this->_numbersonly($this->vmobile)) { $this->errorvmobile = 'Format '.$this->aliasform['vmobile'][0].' diperbolehkan 0-9 !'; }
            
            $this->vemail = $request['vemail'];
            if(empty($this->vemail)) { $this->errorvemail = 'Silahkan masukkan '.$this->aliasform['vemail'][0].' !'; }
            else if($this->_email($this->vemail)) { $this->errorvemail = 'Format '.$this->aliasform['vemail'][0].' salah !'; }
            
            $MasterUser = $this->MasterUser->where([[$this->inv['flip']['vemail'],'=',$this->vemail]])->first();

            if($MasterUser) {
                if(isset($request['addnew']) && $MasterUser[$this->inv['flip']['vemail']] == $this->vemail) {
                    if(!$this->errorvemail) {
                        $this->errorvemail = $this->aliasform['vemail'][0].' is already used !!!';
                    }
                } else {
                    if ($MasterUser[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorvemail) {
                            $this->errorvemail = $this->aliasform['vemail'][0].' is already used !!!';
                        }
                    }
                }
            }
            
            if(isset($requestfile['vimage'])) $this->vimage = $requestfile['vimage'];
            else $this->vimage = '';
            if($this->vimage && !$this->_checkimage($this->vimage, $this->vimagefiletype)) { $this->errorvimage = 'Format '.$this->aliasform['vimage'][0].' diperbolehkan type image !'; }
            
            if(isset($requestfile['signatureimage'])) $this->signatureimage = $requestfile['signatureimage'];
            else $this->signatureimage = '';
            if($this->signatureimage && !$this->_checkimage($this->signatureimage, $this->signatureimagefiletype)) { $this->errorsignatureimage = 'Format '.$this->aliasform['signatureimage'][0].' diperbolehkan type image !'; }

            if(isset($request['optmenu'])) $this->optmenu = $request['optmenu'];
            else {
                $this->inv['messageerror'] = 'Silahkan pilih Function for this Group !!!';
            }

            $this->userstatus = $request['userstatus'];
            if(!empty($this->userstatus) && $this->_checkpermalink($this->userstatus)) { $this->_redirect('404'); }
            
            if(!$this->inv['messageerror'] && !$this->errorgroupname && !$this->errorvusername && !$this->errorvpassword && !$this->errorrepassword && !$this->errorvname && !$this->errorvimage && !$this->errorsignatureimage && !$this->errorvphone && !$this->errorvmobile && !$this->errorvemail) {
                
                $array = array(
                    $this->inv['flip']['vusername'] => $this->vusername,
                    $this->inv['flip']['vname']     => $this->vname,
                    $this->inv['flip']['vaddress']  => $this->vaddress,
                    $this->inv['flip']['vphone']    => $this->vphone,
                    $this->inv['flip']['vmobile']   => $this->vmobile,
                    $this->inv['flip']['vemail']    => $this->vemail,
                    $this->inv['flip']['userstatus'] => $this->userstatus,
                    'permalink'                     => $this->_permalink($this->vname),
                );
                
                if($this->vpassword) $array[$this->inv['flip']['vpassword']] = \Hash::make($this->vpassword);

                $MasterGroup = $this->MasterGroup->where([['permalink','=',$this->groupname]])->first();
                
                $array[$this->inv['flip']['groupid']] = $MasterGroup[$this->inv['flip']['groupid']];

                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['createdate']] = new \DateTime("now");
                    
                    $MasterUser = $this->MasterUser->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->vname);
                    \Session::put('messagesuccess', "Saving $this->vname Completed !");
                } else {
                    $MasterUser = $this->MasterUser->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $MasterUser->update($array);
                    
                    $this->_dblog('edit', $this, $this->vname);
                    \Session::put('messagesuccess', "Update $this->vname Completed !");
                }

                $this->_loaddbclass([ 'MasterMenu', 'MasterUserAccess' ]);

                foreach($this->MasterUserAccess->where([[$this->inv['flip']['userid'],'=',$MasterUser[$this->inv['flip']['userid']]]])->get() as $obj) {
                    $obj->delete();
                }
                
                $arrayuserakses = [];
                foreach ($this->optmenu as $key => $val) {
                    list($permalinkoptmenu, $idMMenu) = explode('-', $key);
                    $arrayuserakses[] = [
                        $this->inv['flip']['userid'] => $MasterUser[$this->inv['flip']['userid']],
                        'idMMenu' => $idMMenu,
                        'access' => json_encode($val, JSON_FORCE_OBJECT)
                    ];
                }

                $this->MasterUserAccess->inserts($arrayuserakses);

                if($this->vimage) {
                    $vimagename = 'user_'.$MasterUser[$this->inv['flip']['userid']].$this->vimagefiletype;
                    $array[$this->inv['flip']['vimage']] = $vimagename;
                    $MasterUser->update($array);
                    list($width, $height) = getimagesize($this->vimage->GetPathName());
                    $this->_imagetofolderratio($this->vimage, base_path().$this->pathimage, $vimagename, $width, $height);
                    $this->_imagetofolderratio($this->vimage, base_path().$this->pathimage, 'medium_'.$vimagename, $width / 3, $height / 3);
                    $this->_imagetofolderratio($this->vimage, base_path().$this->pathimage, 'small_'.$vimagename, $width / 6, $height / 6);
                }
                
                if($this->signatureimage) {
                    $vimagename = 'user_'.$MasterUser[$this->inv['flip']['userid']].$this->signatureimagefiletype;
                    $array[$this->inv['flip']['signatureimage']] = $vimagename;
                    $MasterUser->update($array);
                    list($width, $height) = getimagesize($this->signatureimage->GetPathName());
                    $this->_imagetofolderratio($this->signatureimage, base_path().$this->pathimage, 'signature_'.$vimagename, $width, $height);
                    $this->_imagetofolderratio($this->signatureimage, base_path().$this->pathimage, 'signature_medium_'.$vimagename, $width / 3, $height / 3);
                    $this->_imagetofolderratio($this->signatureimage, base_path().$this->pathimage, 'signature_small_'.$vimagename, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }

        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        $arrgroup = $this->MasterGroup->where([['namaGroup', 'like', 'Seller %']]);
        if($Seller) {
            $arrgroup = $arrgroup->where([['idGroup', '=', $Seller->idGroup]]);
        }
        $arrgroup = $arrgroup->orderBy($this->inv['flip']['groupname'],'ASC')->get()->toArray();

        $arrstatus = $this->_dbgetenum('MasterUser', $this->inv['flip']['userstatus']);
        
        $this->inv['arrgroup']          = $arrgroup;
        $this->inv['arrstatus']         = $arrstatus;
        $this->inv['groupname']         = $this->groupname;
        $this->inv['errorgroupname']    = $this->errorgroupname;
        $this->inv['vusername']         = $this->vusername;
        $this->inv['errorvusername']    = $this->errorvusername;
        $this->inv['vpassword']         = $this->vpassword;
        $this->inv['errorvpassword']    = $this->errorvpassword;
        $this->inv['repassword']        = $this->repassword;
        $this->inv['errorrepassword']   = $this->errorrepassword;
        $this->inv['vname']             = $this->vname;
        $this->inv['errorvname']        = $this->errorvname;
        $this->inv['vmobile']           = $this->vmobile;
        $this->inv['errorvmobile']      = $this->errorvmobile;
        $this->inv['vemail']            = $this->vemail;
        $this->inv['errorvemail']       = $this->errorvemail;
        $this->inv['vphone']            = $this->vphone;
        $this->inv['errorvphone']       = $this->errorvphone;
        $this->inv['vaddress']          = $this->vaddress;
        $this->inv['vimage']            = $this->vimage;
        $this->inv['errorvimage']       = $this->errorvimage;
        $this->inv['signatureimage']    = $this->signatureimage;
        $this->inv['errorsignatureimage'] = $this->errorsignatureimage;
        $this->inv['userstatus']        = $this->userstatus;
        $this->inv['optmenu']           = $this->optmenu;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([ 'MasterUser', 'MasterUserAccess' ]);

            foreach($this->inv['delete'] as $val) {
                $MasterUser = $this->MasterUser->where([[$this->objectkey,'=',$val]])->first();
                if($MasterUser) {
                    $this->vname = $MasterUser[$this->inv['flip']['vname']];
                    foreach($this->MasterUserAccess->where([[$this->inv['flip']['userid'],'=',$MasterUser[$this->inv['flip']['userid']]]])->get() as $obj) {
                        $obj->delete();
                    }
                    if($MasterUser->imagepath) {
                        @unlink(base_path().$this->pathimage.$MasterUser->imagepath);
                        @unlink(base_path().$this->pathimage.'medium_'.$MasterUser->imagepath);
                        @unlink(base_path().$this->pathimage.'small_'.$MasterUser->imagepath);
                    }
                    if($MasterUser->imagesignature) {
                        @unlink(base_path().$this->pathimage.'signature_'.$MasterUser->imagesignature);
                        @unlink(base_path().$this->pathimage.'signature_medium_'.$MasterUser->imagesignature);
                        @unlink(base_path().$this->pathimage.'signature_small_'.$MasterUser->imagesignature);
                    }
                    
                    $MasterUser->delete();

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->vname);
                    $this->inv['messagesuccess'] .= "Delete $this->vname Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'Seller', 'MasterUser' ]);

        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        
        $result = $this->MasterUser->leftjoin([
            ['master_group','master_group.'.$this->inv['flip']['groupid'],'=','master_user.'.$this->inv['flip']['groupid']]
        ]);
        $result = $result->where([['master_group.namaGroup', 'like', 'Seller %']]);
        if($Seller) {
            $result = $result->where([['master_group.idGroup', '=', $Seller->idGroup]]);
        }
        $result = $result->select([
            'master_group.'.$this->inv['flip']['groupname'],
            'master_user.*'
        ])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                if(in_array($result['data'][$i][$this->inv['flip']['datelogin']], ['1970-01-01 00:00:01','0000-00-00 00:00:00',''])) {
                    $result['data'][$i][$this->inv['flip']['datelogin']] = '<span class="red">Not Login Now</span>';
                } else {
                    $result['data'][$i][$this->inv['flip']['datelogin']] = $this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['datelogin']], 'red');
                }
                if($result['data'][$i][$this->inv['flip']['vimage']])
                    $result['data'][$i][$this->inv['flip']['vimage']] = 
                        $this->inv['basesite'].
                        str_replace('/resources/', '', $this->pathimage).
                        'small_'.$result['data'][$i][$this->inv['flip']['vimage']];
            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}