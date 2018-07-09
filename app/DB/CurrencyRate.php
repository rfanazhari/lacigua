<?php namespace App\DB;

class CurrencyRate extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CurrencyRate;
		return $this->db;
	}
}