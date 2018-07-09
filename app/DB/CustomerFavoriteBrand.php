<?php namespace App\DB;

class CustomerFavoriteBrand extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CustomerFavoriteBrand;
		return $this->db;
	}
}