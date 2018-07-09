<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class logoutController extends Controller
{
    public function index()
    {
    	\Session::forget('customerdata');
        $minute = -1;
        $path = null;
        $domain = '';
        $secure = false;
        $http = false;
        $cookie = \Cookie::make('customerdata', '', $minute, $path, $domain, $secure, $http);
        setcookie($cookie->getName(), \Crypt::encrypt($cookie->getValue()), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
        \Session::forget('previousurl');
        
    	return $this->_redirect($this->inv['basesite']);
    }
}