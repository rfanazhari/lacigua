<?php namespace App\DB;

class MainCategoryBanner extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MainCategoryBanner;
		return $this->db;
	}
}