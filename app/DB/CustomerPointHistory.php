<?php namespace App\DB;

class CustomerPointHistory extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CustomerPointHistory;
		return $this->db;
	}
}