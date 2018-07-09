<?php namespace App\DB;

class SizeVariant extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SizeVariant;
		return $this->db;
	}
}