<?php namespace App\DB;

class SellerShipping extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SellerShipping;
		return $this->db;
	}
}