<?php namespace App\DB;

class Village extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Village;
		return $this->db;
	}
}