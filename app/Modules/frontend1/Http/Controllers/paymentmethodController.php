<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class paymentmethodController extends Controller
{
	public function index()
	{
		$Cart = \Session::get('Cart');
		if(!$Cart) return $this->_redirect('404');

		$Cart = $this->_constructCart($Cart);
		$this->inv['Cart'] = $Cart;

		$this->_loaddbclass(['PaymentType']);

		$arrTransferPaymentType = $this->PaymentType->leftjoin([
			['our_bank', 'our_bank.ID', '=', 'payment_type.OurBankID']
		])->where([['Type','=','0'],['payment_type.IsActive','=',1],['payment_type.Status','=',0]])
		->selectraw('payment_type.*,our_bank.BankAccountNumber')->orderby('Name')->get();
		$this->inv['arrTransferPaymentType'] = $arrTransferPaymentType;

		// 0 => Bank Transfer; 1 => Virtual Account; 2 => Internet Banking; 3 => Credit Card / Virtual Card; 4 => Another / Gerai;

		$arrVirtualPaymentType = $this->PaymentType->where([['Type','=','1'],['IsActive','=',1],['Status','=',0]])->orderby('Name')->get();
		$this->inv['arrVirtualPaymentType'] = $arrVirtualPaymentType;

		$arrInternetPaymentType = $this->PaymentType->where([['Type','=','2'],['IsActive','=',1],['Status','=',0]])->orderby('Name')->get();
		$this->inv['arrInternetPaymentType'] = $arrInternetPaymentType;

		$arrCreditPaymentType = $this->PaymentType->where([['Type','=','3'],['IsActive','=',1],['Status','=',0]])->orderby('Name')->get();
		$this->inv['arrCreditPaymentType'] = $arrCreditPaymentType;

		$arrAnotherPaymentType = $this->PaymentType->where([['Type','=','4'],['IsActive','=',1],['Status','=',0]])->orderby('Name')->get();
		$this->inv['arrAnotherPaymentType'] = $arrAnotherPaymentType;

		return $this->_showviewfront(['paymentmethod']);
	}
}