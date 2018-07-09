<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class printreturnController extends Controller
{
	public function index()
	{
		if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

		$this->_geturi();

		if(isset($this->inv['getcode'])) {
			$this->_loaddbclass(['ListReturn']);

			$ListReturn = $this->ListReturn->where([['ReturCode', '=', $this->inv['getcode']]])->first();
			$this->inv['ListReturn'] = $ListReturn;

			return $this->_showviewfront(['printreturn'], false);
        } else return $this->_redirect('404');
	}
}