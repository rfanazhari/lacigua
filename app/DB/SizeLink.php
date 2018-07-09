<?php namespace App\DB;

class SizeLink extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SizeLink;
		return $this->db;
	}
}