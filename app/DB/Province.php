<?php namespace App\DB;

class Province extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Province;
		return $this->db;
	}
}