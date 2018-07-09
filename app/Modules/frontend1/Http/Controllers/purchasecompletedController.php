<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class purchasecompletedController extends Controller
{
	public function index()
	{
		$Cart = \Session::get('Cart');
		if(!$Cart) return $this->_redirect('404');
		$InitialCart = \Session::get('InitialCart');
		if(!isset($InitialCart['CustomerID'])) return $this->_redirect('404');
		$FinishCart = \Session::get('FinishCart');
		if(!$FinishCart) return $this->_redirect('404');

		$Cart = $this->_constructCart($Cart);
		$this->inv['Cart'] = $Cart;
		$this->inv['FinishCart'] = $FinishCart;

		// \Session::forget('Cart');
		// \Session::forget('FinishCart');

		return $this->_showviewfront(['purchasecompleted']);
	}
}