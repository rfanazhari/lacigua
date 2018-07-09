<?php namespace App\DB;

class OrderTransactionShipment extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\OrderTransactionShipment;
		return $this->db;
	}
}