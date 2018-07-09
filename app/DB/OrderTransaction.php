<?php namespace App\DB;

class OrderTransaction extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\OrderTransaction;
		return $this->db;
	}
}