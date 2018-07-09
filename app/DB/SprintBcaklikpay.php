<?php namespace App\DB;

class SprintBcaklikpay extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SprintBcaklikpay;
		return $this->db;
	}
}