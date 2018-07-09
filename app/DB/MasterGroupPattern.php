<?php namespace App\DB;

class MasterGroupPattern extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MasterGroupPattern;
		return $this->db;
	}
}