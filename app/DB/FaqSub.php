<?php namespace App\DB;

class FaqSub extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\FaqSub;
		return $this->db;
	}
}