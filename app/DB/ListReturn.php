<?php namespace App\DB;

class ListReturn extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\ListReturn;
		return $this->db;
	}
}