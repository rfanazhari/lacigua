<?php namespace App\DB;

class CustomerVoucher extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CustomerVoucher;
		return $this->db;
	}
}