<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class logoutController extends Controller
{
    public function index()
    {
        if(isset(\Session::get('userdata')['uuserid']) || isset(\Cookie::get('userdata')['uuserid'])) {
            $this->_reupdatesession('userdata');
            $this->_dblog('logout', $this, \Session::get('userdata')['uname']);
        }

        \Session::forget('userdata');
        $minute = -1;
        $path = null;
        $domain = '';
        $secure = false;
        $http = false;
        $cookie = \Cookie::make('userdata', '', $minute, $path, $domain, $secure, $http);
        setcookie($cookie->getName(), \Crypt::encrypt($cookie->getValue()), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
        \Session::forget('previousurl');

        return \Redirect::to($this->inv['basesite'].$this->inv['config']['backend']['aliaspage']);
    }
}