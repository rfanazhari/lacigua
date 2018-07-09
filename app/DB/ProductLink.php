<?php namespace App\DB;

class ProductLink extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\ProductLink;
		return $this->db;
	}
}