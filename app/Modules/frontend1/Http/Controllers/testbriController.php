<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class testbriController extends Controller
{
	public function index()
	{
		$this->_geturi();

        $request = \Request::instance()->request->all();

        $this->_debugvar($request);
	}
}