<?php namespace App\DB;

class SprintBcava extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SprintBcava;
		return $this->db;
	}
}