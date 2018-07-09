<?php namespace App\DB;

class Style extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Style;
		return $this->db;
	}
}