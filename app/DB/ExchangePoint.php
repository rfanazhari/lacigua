<?php namespace App\DB;

class ExchangePoint extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\ExchangePoint;
		return $this->db;
	}
}