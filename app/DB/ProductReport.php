<?php namespace App\DB;

class ProductReport extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\ProductReport;
		return $this->db;
	}
}