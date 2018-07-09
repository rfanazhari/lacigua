<?php namespace App\DB;

class SprintPermatava extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SprintPermatava;
		return $this->db;
	}
}