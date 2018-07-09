<?php namespace App\DB;

class OurBank extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\OurBank;
		return $this->db;
	}
}