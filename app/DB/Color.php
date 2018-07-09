<?php namespace App\DB;

class Color extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Color;
		return $this->db;
	}
}