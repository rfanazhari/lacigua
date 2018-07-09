<?php namespace App\DB;

class MasterMenu extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\MasterMenu;
		return $this->db;
	}
}