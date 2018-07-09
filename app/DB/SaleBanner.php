<?php namespace App\DB;

class SaleBanner extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SaleBanner;
		return $this->db;
	}
}