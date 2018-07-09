<?php namespace App\DB;

class Seller extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Seller;
		return $this->db;
	}
}