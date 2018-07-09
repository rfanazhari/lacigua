<?php namespace App\DB;

class Brand extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Brand;
		return $this->db;
	}
}