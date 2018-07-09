<?php namespace App\DB;

class MainCategory extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MainCategory;
		return $this->db;
	}
}