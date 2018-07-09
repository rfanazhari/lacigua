<?php namespace App\DB;

class Career extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Career;
		return $this->db;
	}
}