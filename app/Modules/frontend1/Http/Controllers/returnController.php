<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class returnController extends Controller
{
	public function index()
	{
		$this->_geturi();
		
		if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

		$this->_loaddbclass(['OrderTransaction']);

        $OrderTransaction = $this->OrderTransaction->leftjoin([
            ['order_transaction_detail as otd', 'otd.TransactionCode', '=', 'order_transaction.TransactionCode']
        ])->selectraw('order_transaction.*')->where([
        	['order_transaction.CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
        ]);

		$OrderTransaction = $OrderTransaction->where([['order_transaction.StatusPaid', '=', 1]])->where(function($query) {
			$query->where('order_transaction.StatusOrder', 0)->orWhere('order_transaction.StatusOrder', 1)->orWhere('order_transaction.StatusOrder', 2);
		});

		$OrderTransaction = $OrderTransaction->where(function($query) {
			$query->where('FeedbackDate', '>', \Carbon\Carbon::now()->subDays(7))->orWhere('FeedbackDate', null);
		});

        $OrderTransaction = $OrderTransaction->groupBy('order_transaction.TransactionCode')->get();

        if($OrderTransaction) {
        	$OrderTransaction = $OrderTransaction->toArray();
        } else $OrderTransaction = [];

        $this->inv['OrderTransaction'] = $OrderTransaction;

		return $this->_showviewfront(['listreturn']);
	}
}