<?php namespace App\DB;

class SlidingBanner extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SlidingBanner;
		return $this->db;
	}
}