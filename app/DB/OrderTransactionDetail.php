<?php namespace App\DB;

class OrderTransactionDetail extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\OrderTransactionDetail;
		return $this->db;
	}
}