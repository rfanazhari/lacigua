<?php namespace App\DB;

class ProductReturn extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\ProductReturn;
		return $this->db;
	}
}