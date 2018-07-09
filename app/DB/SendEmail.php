<?php namespace App\DB;

class SendEmail extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SendEmail;
		return $this->db;
	}
}