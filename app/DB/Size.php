<?php namespace App\DB;

class Size extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Size;
		return $this->db;
	}
}