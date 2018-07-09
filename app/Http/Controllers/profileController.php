<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class profileController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => false, // Active all header function. If all true and this check false then header not show.
        'search'    => false,
        'addnew'    => false,
        'refresh'   => false,
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
        'address'   => 'vaddress',
        'phone'     => 'vphone',
        'mobile'    => 'vmobile',
        'email'     => 'vemail',
        'dateCreate'=> 'createdate',
        'loginDate' => 'datelogin',
        'permalink' => 'permalink',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['Profile', false, true], // Set Title Page (if DB value from database), Title Form (true or false), Breadcrumb (true or false)
        'groupname'     => ['Group Name'],
        'vusername'     => ['Username'],
        'vpassword'     => ['New Password'],
        'repassword'    => ['Re-type New Password'],
        'vname'         => ['Name'],
        'vimage'        => ['Picture'],
        'vaddress'      => ['Address'],
        'vphone'        => ['Phone'],
        'vmobile'       => ['Mobile'],
        'vemail'        => ['E-mail'],
        'datelogin'     => ['Login Date'],
    ];
    
	private $access = [
		'module' => [''],
		'function' => ['index', 'ajaxpost']
	];

    var $pathimage = '/resources/assets/backend/images/userdetail/';
    var $groupname = '', $errorgroupname = '', $vpassword = '', $errorvpassword = '', $repassword = '', $errorrepassword = '', $vusername = '', $errorvusername = '', $vname = '', $errorvname = '', $vimage = '', $errorvimage = '', $vaddress = '', $errorvaddress = '', $vphone = '', $errorvphone = '', $vmobile = '', $errorvmobile = '', $vemail = '', $errorvemail = '', $permalink = '', $vimagefiletype = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__, $this->access);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'deleteimage' :
                    $this->_loaddbclass([ 'MasterUser' ]);

                    $MasterUser = $this->MasterUser->where([[$this->inv['flip']['userid'],'=',\Session::get('userdata')['uuserid']]])->first();

                    if($MasterUser->imagepath) {
                        @unlink(base_path().$this->pathimage.$MasterUser->imagepath);
                        @unlink(base_path().$this->pathimage.'medium_'.$MasterUser->imagepath);
                        @unlink(base_path().$this->pathimage.'small_'.$MasterUser->imagepath);
                    }

                    $MasterUser->update(['imagepath' => '']);
                    exit;
                break;
            }
        }
    }

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__, $this->access);
        if($url) return $this->_redirect($url);

        return $this->addnewedit();
    }
    
    private function addnewedit() {
        $request = \Request::instance()->request->all();
        $requestfile = \Request::file();

        $this->_loaddbclass([ 'MasterUser' ]);

        $pageprofile = 'tab_1_1_1';
        if (isset($request['personalinfo'])) {
            $this->vname = $request['vname'];
            if(empty($this->vname)) { $this->errorvname = $this->_trans('validation.mandatory', ['value' => $this->_trans('backend.profile.vname')]); }
            else if($this->_charactersspace($this->vname)) { $this->errorvname = $this->_trans('validation.format', ['value' => $this->_trans('backend.profile.vname'), 'format' => 'a-Z, spasi']); }
            
            $MasterUser = $this->MasterUser->where([[$this->inv['flip']['vname'],'=',$this->vname]])->first();

            if($MasterUser) {
                if ($MasterUser[$this->inv['flip']['userid']] != \Session::get('userdata')['uuserid']) {
                    if(!$this->errorvname) {
                        $this->errorvname = $this->_trans('validation.already', ['value' => $this->_trans('backend.profile.vname')]);
                    }
                }
            }

            $this->vaddress = $request['vaddress'];
            
            $this->vphone = $request['vphone'];
            if($this->_numbersonly($this->vphone)) { $this->errorvphone = $this->_trans('validation.format', ['value' => $this->_trans('backend.profile.vphone'), 'format' => '0-9']); }

            $this->vmobile = $request['vmobile'];
            if(empty($this->vmobile)) { $this->errorvmobile = $this->_trans('validation.mandatory', ['value' => $this->_trans('backend.profile.vmobile')]); }
            else if($this->_numbersonly($this->vmobile)) { $this->errorvmobile = $this->_trans('validation.format', ['value' => $this->_trans('backend.profile.vmobile'), 'format' => '0-9']); }
            
            $this->vemail = $request['vemail'];
            if(empty($this->vemail)) { $this->errorvemail = $this->_trans('validation.mandatory', ['value' => $this->_trans('backend.profile.vemail')]); }
            else if($this->_email($this->vemail)) { $this->errorvemail = $this->_trans('validation.formatemail', ['value' => $this->_trans('backend.profile.vemail')]); }

            $MasterUser = $this->MasterUser->where([[$this->inv['flip']['vemail'],'=',$this->vemail]])->first();

            if($MasterUser) {
                if ($MasterUser[$this->inv['flip']['userid']] != \Session::get('userdata')['uuserid']) {
                    if(!$this->errorvemail) {
                        $this->errorvemail = $this->_trans('validation.already', ['value' => $this->_trans('backend.profile.vemail')]);
                    }
                }
            }

            if(isset($requestfile['vimage'])) $this->vimage = $requestfile['vimage'];
            if($this->vimage && !$this->_checkimage($this->vimage, $this->vimagefiletype)) { $this->errorvimage = $this->_trans('validation.format', ['value' => $this->_trans('backend.profile.vimage'), 'format' => 'type image']); }
        }

        if(isset($request['personalaccess'])) {
            $pageprofile = 'tab_1_2_2';

            $this->vusername = $request['vusername'];

            if (isset($request['addnew']) || $request['vpassword'] || $request['repassword']) {
                $this->vpassword = $request['vpassword'];
                $this->repassword = $request['repassword'];
                if(empty($this->vpassword)) { $this->errorvpassword = $this->_trans('validation.mandatory', ['value' => $this->_trans('backend.profile.vpassword')]); }
                if(empty($this->repassword)) { $this->errorrepassword = $this->_trans('validation.mandatory', ['value' => $this->_trans('backend.profile.repassword')]); }
                else if(!empty($this->repassword) && $this->repassword != $this->vpassword) { $this->errorrepassword = $this->_trans('validation.notsame', ['value' => $this->_trans('backend.profile.repassword')]); }
            }
        }
        
        if(!$this->inv['messageerror'] && !$this->errorgroupname && !$this->errorvusername && !$this->errorvpassword && !$this->errorrepassword && !$this->errorvname && !$this->errorvimage && !$this->errorvphone && !$this->errorvmobile && !$this->errorvemail && !$this->errorvimage) {

            $MasterUser = $this->MasterUser->where([[$this->inv['flip']['userid'],'=',\Session::get('userdata')['uuserid']]])->first();

            if(isset($request['personalinfo'])) {
                $array = array(
                    $this->inv['flip']['vname']     => $this->vname,
                    $this->inv['flip']['vaddress']  => $this->vaddress,
                    $this->inv['flip']['vphone']    => $this->vphone,
                    $this->inv['flip']['vmobile']   => $this->vmobile,
                    $this->inv['flip']['vemail']    => $this->vemail,
                    'permalink'                     => $this->_permalink($this->vname),
                );
                
                $this->_dblog('personalinfo', $this, $this->vname);
                $this->inv['messagepersonalinfo'] = "Update Personal Info $this->vname Completed !";

                if($this->vimage) {
                    $vimagename = 'user_'.$MasterUser[$this->inv['flip']['userid']].$this->vimagefiletype;
                    $array[$this->inv['flip']['vimage']] = $vimagename;
                    $MasterUser->update($array);
                    list($width, $height) = getimagesize($this->vimage->GetPathName());
                    $this->_imagetofolderratio($this->vimage, base_path().$this->pathimage, $vimagename, $width, $height);
                    $this->_imagetofolderratio($this->vimage, base_path().$this->pathimage, 'medium_'.$vimagename, $width / 3, $height / 3);
                    $this->_imagetofolderratio($this->vimage, base_path().$this->pathimage, 'small_'.$vimagename, $width / 6, $height / 6);
                }

                $MasterUser->update($array);
            }

            if(isset($request['personalaccess'])) {
                if($this->vpassword) { 
                    $array[$this->inv['flip']['vpassword']] = \Hash::make($this->vpassword);
                    $this->vpassword = $this->repassword = '';

                    $this->_dblog('personalaccess', $this, $this->vname);
                    $this->inv['messagepersonalaccess'] = "Update Personal Access $this->vname Completed !";

                    $MasterUser->update($array);
                }
            }
        }

        $MasterUser = $this->MasterUser->join([
            ['master_group', 'master_group.idGroup', '=', 'master_user.idGroup']
        ])->where([['idUser','=',\Session::get('userdata')['uuserid']]])
        ->select(['namaGroup','username','name','imagepath','address','phone','mobile','email','master_user.permalink'])
        ->first();

        $this->groupname    = $MasterUser->namaGroup;
        $this->vusername    = $MasterUser->username;
        $this->vname        = $MasterUser->name;
        $this->vimage       = $MasterUser->imagepath ? $MasterUser->imagepath : 'nouser.jpg';
        $this->vaddress     = $MasterUser->address;
        $this->vphone       = $MasterUser->phone;
        $this->vmobile      = $MasterUser->mobile;
        $this->vemail       = $MasterUser->email;
        $this->permalink    = $MasterUser->permalink;
        
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
        $this->inv['vimage']            = $this->vimage;
        $this->inv['errorvimage']       = $this->errorvimage;
        $this->inv['vaddress']          = $this->vaddress;
        $this->inv['errorvaddress']     = $this->errorvaddress;
        $this->inv['vphone']            = $this->vphone;
        $this->inv['errorvphone']       = $this->errorvphone;
        $this->inv['vmobile']           = $this->vmobile;
        $this->inv['errorvmobile']      = $this->errorvmobile;
        $this->inv['vemail']            = $this->vemail;
        $this->inv['errorvemail']       = $this->errorvemail;
        $this->inv['permalink']         = $this->permalink;
        $this->inv['pageprofile']       = $pageprofile;
        $this->inv['extlink']           = 'profile';

        return $this->_showview(["profile"]);
    }
}