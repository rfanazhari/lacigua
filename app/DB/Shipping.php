<?php namespace App\DB;

class Shipping extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Shipping;
		return $this->db;
	}
}