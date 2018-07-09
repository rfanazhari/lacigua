<?php namespace App\DB;

class ProductDetailStyle extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\ProductDetailStyle;
		return $this->db;
	}
}