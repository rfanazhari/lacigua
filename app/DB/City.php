<?php namespace App\DB;

class City extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\City;
		return $this->db;
	}
}