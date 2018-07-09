<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class lockController extends Controller
{
    private $access = [
        'module' => [''],
        'function' => ['index']
    ];

    var $pathimage = '/resources/assets/backend/images/userdetail/';
    var $vname = '', $vimage = '', $vpassword = '', $errorvpassword = '';

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__, $this->access);
        if($url) return $this->_redirect($url);

        if(!(isset($this->inv['config']['backend']['autolock']) && $this->inv['config']['backend']['autolock'])) return $this->_redirect('404');

        return $this->addnewedit();
    }

    private function addnewedit() {
        $this->_loaddbclass([ 'MasterUser' ]);

        $MasterUser = $this->MasterUser->join([
            ['master_group', 'master_group.idGroup', '=', 'master_user.idGroup']
        ])->where([['idUser','=',\Session::get('userdata')['uuserid']]])->select(['name','pass','imagepath','statususer'])->first();

        $this->vname    = $MasterUser->name;
        $this->vimage   = $MasterUser->imagepath ? $MasterUser->imagepath : 'nouser.jpg';

        $request = \Request::instance()->request->all();

        if(!isset(\Session::get('previousurl')['previousurl'])) {
            $previousurl = str_replace($this->inv['basesite'].$this->inv['config']['backend']['aliaspage'], '', \URL::previous());

            if($previousurl == 'lock') {
                $previousurl = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'];
            } else {
                $previousurl = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].$previousurl;
            }

            \Session::put('previousurl', ['previousurl' => $previousurl]);
        }

        if (isset($request['vpassword'])) {
            $this->vpassword   = $request['vpassword'];

            if($MasterUser) {
                if(\Hash::check($this->vpassword, $MasterUser->pass)) {
                    if($MasterUser->statususer == 'Active') {
                        $previousurl = \Session::get('previousurl')['previousurl'];
                        \Session::forget('previousurl');
                        
                        return $this->_redirect($previousurl);
                    } else {
                        $this->errorvpassword = $this->_trans('backend.lock.errornotactive');
                    }
                } else {
                    $this->errorvpassword = $this->_trans('backend.lock.errorinvalid');
                }
            } else {
                $this->errorvpassword = $this->_trans('backend.lock.errorinvalid');
            }
        }
        
        $this->inv['vname']             = $this->vname;
        $this->inv['vimage']            = $this->vimage;
        $this->inv['vpassword']         = $this->vpassword;
        $this->inv['errorvpassword']    = $this->errorvpassword;

        return view("lock", $this->inv);
    }
}