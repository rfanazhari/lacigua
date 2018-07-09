<?php namespace App\DB;

class Product extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Product;
		return $this->db;
	}
}