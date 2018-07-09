<?php namespace App\DB;

class Variant extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Variant;
		return $this->db;
	}
}