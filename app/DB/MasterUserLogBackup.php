<?php namespace App\DB;

class MasterUserLogBackup extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MasterUserLogBackup;
		return $this->db;
	}
}