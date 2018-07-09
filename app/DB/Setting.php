<?php namespace App\DB;

class Setting extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Setting;
		return $this->db;
	}
}