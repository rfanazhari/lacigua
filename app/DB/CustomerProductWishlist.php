<?php namespace App\DB;

class CustomerProductWishlist extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CustomerProductWishlist;
		return $this->db;
	}
}