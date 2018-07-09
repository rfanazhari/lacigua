<?php namespace App\DB;

class CustomerInvitation extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CustomerInvitation;
		return $this->db;
	}
}