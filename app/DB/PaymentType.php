<?php namespace App\DB;

class PaymentType extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\PaymentType;
		return $this->db;
	}
}