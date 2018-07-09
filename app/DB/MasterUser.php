<?php namespace App\DB;

class MasterUser extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MasterUser;
		return $this->db;
	}
}