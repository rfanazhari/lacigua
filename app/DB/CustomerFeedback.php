<?php namespace App\DB;

class CustomerFeedback extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\CustomerFeedback;
		return $this->db;
	}
}