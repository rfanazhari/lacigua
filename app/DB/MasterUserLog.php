<?php namespace App\DB;

class MasterUserLog extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MasterUserLog;
		return $this->db;
	}
}