<?php namespace App\DB;

class CareerDivision extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CareerDivision;
		return $this->db;
	}
}