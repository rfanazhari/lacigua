<?php namespace App\DB;

class CustomerCc extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CustomerCc;
		return $this->db;
	}
}