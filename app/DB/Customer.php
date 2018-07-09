<?php namespace App\DB;

class Customer extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Customer;
		return $this->db;
	}
}