<?php namespace App\DB;

class ExchangePointStoreKredit extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\ExchangePointStoreKredit;
		return $this->db;
	}
}