<?php namespace App\DB;

class SubCategory extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SubCategory;
		return $this->db;
	}
}