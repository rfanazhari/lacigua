<?php namespace App\DB;

class MasterGroup extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MasterGroup;
		return $this->db;
	}
}