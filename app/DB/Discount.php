<?php namespace App\DB;

class Discount extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Discount;
		return $this->db;
	}
}