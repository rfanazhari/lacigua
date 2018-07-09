<?php namespace App\DB;

class CustomerDiscountCode extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CustomerDiscountCode;
		return $this->db;
	}
}