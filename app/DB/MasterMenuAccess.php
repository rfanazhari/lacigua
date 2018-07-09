<?php namespace App\DB;

class MasterMenuAccess extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MasterMenuAccess;
		return $this->db;
	}
}