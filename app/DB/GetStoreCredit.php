<?php namespace App\DB;

class GetStoreCredit extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\GetStoreCredit;
		return $this->db;
	}
}