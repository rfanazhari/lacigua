<?php namespace App\DB;

class Return extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Return;
		return $this->db;
	}
}