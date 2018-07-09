<?php namespace App\DB;

class Country extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Country;
		return $this->db;
	}
}