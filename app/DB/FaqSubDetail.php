<?php namespace App\DB;

class FaqSubDetail extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\FaqSubDetail;
		return $this->db;
	}
}