<?php namespace App\DB;

class ProductDetailSizeVariant extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\ProductDetailSizeVariant;
		return $this->db;
	}
}