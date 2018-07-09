<?php namespace App\DB;

class Faq extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\Faq;
		return $this->db;
	}
}