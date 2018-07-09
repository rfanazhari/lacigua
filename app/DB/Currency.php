<?php namespace App\DB;

class Currency extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Currency;
		return $this->db;
	}
}