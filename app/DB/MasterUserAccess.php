<?php namespace App\DB;

class MasterUserAccess extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MasterUserAccess;
		return $this->db;
	}
}