<?php namespace App\DB;

class TransferConfirmation extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\TransferConfirmation;
		return $this->db;
	}
}