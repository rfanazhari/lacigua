<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class loginController extends Controller
{
    public function index()
    {
        if(isset(\Session::get('userdata')['uuserid']) || isset(\Cookie::get('userdata')['uuserid'])) {
            $this->_reupdatesession('userdata');
            $url = $this->_startmenu();
            
            return \Redirect::to($url);
        }

        $checkform = $username = $password = $email = $errormsg = $errorforget = $successforget = $remember = '';
        $request = \Request::instance()->request->all();

        $this->_loaddbclass([ 'MasterUser' ]);

        if (isset($request['username']) && isset($request['password'])) {
            $username   = $request['username'];
            $password   = $request['password'];
            if(isset($request['remember']))
                $remember = $request['remember'];
            
            $MasterUser = $this->MasterUser->join([['master_group','master_group.idGroup','=','master_user.idGroup']])
                            ->where([['username','=',$username]])->first();

            if($MasterUser) {
                if(\Hash::check($password, $MasterUser->pass)) {
                    if($MasterUser->statususer == 'Active') {
                        $userdata = array(
                            'uuserid'           => $MasterUser->idUser,
                            'uusergroupid'      => $MasterUser->idGroup,
                            'uusergroup'        => $this->_permalink($MasterUser->namaGroup),
                            'uusername'         => $MasterUser->username,
                            'uname'             => $MasterUser->name,
                            'uimage'            => $MasterUser->imagepath ? $MasterUser->imagepath : 'nouser.jpg',
                            'uemail'            => $MasterUser->email,
                        );

                        $array['loginDate'] = new \DateTime("now");
                        $MasterUser->update($array);
                        
                        $cookie = null;

                        \Session::put('userdata', $userdata);

                        $this->_dblog('login', $this, $MasterUser->name);

                        $url = $this->_startmenu();
                        
                        $oneday = 60 * 24;
                        $onemonth = $oneday * 30;
                        $oneyear = $onemonth * 12;

                        $minute = $oneyear * 5;
                        
                        if($remember) return \Redirect::to($url)->withCookie('userdata', $userdata, $minute);
                        else return \Redirect::to($url);
                    } else {
                        $errormsg = $this->_trans('backend.login.errornotactive');
                    }
                } else {
                    $errormsg = $this->_trans('backend.login.errorinvalid');
                }
            } else {
                $errormsg = $this->_trans('backend.login.errorinvalid');
            }
            $checkform = "login-form";
        }
        
        if (isset($request['email'])) {
            $email      = $request['email'];
            $MasterUser = $this->MasterUser->where([['email','=',$email]])->first();
            if($MasterUser) {
                if($MasterUser->statususer == 'Active') {
                    $randompass = uniqid();
                    $condition = [
                        'subject' => 'Forgot Password '.$this->inv['config']['project']['name'],
                        'from' => $this->inv['config']['email']['smtp_user'],
                        'fromname' => 'Administrator '.$this->inv['config']['project']['name'],
                        'to' => $MasterUser->email,
                        'toname' => $MasterUser->name,
                        'message' => 'Hello '.$MasterUser->name.',<br/><br/>
                        
                        System is automatically reset your password.<br/><br/>
                        
                        Your username is <b>'.$MasterUser->username.'</b><br/>
                        Your new password is <b>'.$randompass.'</b><br/><br/>
                        
                        Please update your password in Profile !<br/><br/>
                        
                        Best Regards.',
                        'successmessage' => 'New password is send to '.$email.' !',
                    ];

                    $successforget = $this->_sendemail($condition);
                    
                    if($successforget == $condition['successmessage']) {
                        $this->_dblog('forget', $this, $MasterUser->name);

                        $MasterUser->update(['pass' => \Hash::make($randompass)]);
                        $email = '';
                    } else {
                        $errorforget = $successforget;
                    }
                } else {
                    $errorforget = $this->_trans('backend.login.errornotactive');
                }
            } else {
                $errorforget = $this->_trans('backend.login.erroremailnotfound');
            }

            $checkform = "forget-form";
        }

        if(!$checkform) $checkform = "login-form";
        $this->inv['inv']           = $this;
        $this->inv['checkform']     = $checkform;
        $this->inv['username']      = $username;
        $this->inv['password']      = $password;
        $this->inv['email']         = $email;
        $this->inv['errormsg']      = $errormsg;
        $this->inv['errorforget']   = $errorforget;
        $this->inv['successforget'] = $successforget;
        $this->inv['remember']      = $remember;

        return view('login', $this->inv);
    }
}