<?php namespace App\DB;

class GroupSize extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\GroupSize;
		return $this->db;
	}
}