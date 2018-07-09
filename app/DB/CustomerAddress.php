<?php namespace App\DB;

class CustomerAddress extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CustomerAddress;
		return $this->db;
	}
}