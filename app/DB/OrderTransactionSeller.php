<?php namespace App\DB;

class OrderTransactionSeller extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\OrderTransactionSeller;
		return $this->db;
	}
}