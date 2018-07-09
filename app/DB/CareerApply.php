<?php namespace App\DB;

class CareerApply extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CareerApply;
		return $this->db;
	}
}