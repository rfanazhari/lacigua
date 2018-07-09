<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class activateController extends Controller
{
	public function index()
	{
		$this->_geturi();

                if(!isset($this->inv['getcode'])) return $this->_redirect($this->inv['basesite']);

                $this->_loaddbclass(['Customer']);
                $Customer = $this->Customer->where([['CustomerUniqueID','=',decrypt($this->inv['getcode'])]])->first();

                if(!$Customer) return $this->_redirect($this->inv['basesite']);

                $Customer->update(['IsActive' => 1]);
                
                return \Redirect::to('login');
	}
}