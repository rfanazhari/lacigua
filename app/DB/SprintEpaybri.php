<?php namespace App\DB;

class SprintEpaybri extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SprintEpaybri;
		return $this->db;
	}
}