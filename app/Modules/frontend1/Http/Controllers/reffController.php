<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class reffController extends Controller
{
    public function index()
    {
        $this->_geturi();

        if(!isset($this->inv['getcode'])) return $this->_redirect($this->inv['basesite']);

        $this->_loaddbclass(['Customer']);
        $Customer = $this->Customer->where([['CustomerShareLink','=',$this->inv['getcode']]])->first();

        if(!$Customer) return $this->_redirect($this->inv['basesite']);

        \Session::put('ReferralCustomerID', $Customer->ID);

        return \Redirect::to('login');
    }
}