<?php namespace App\DB;

class SellerPartner extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SellerPartner;
		return $this->db;
	}
}