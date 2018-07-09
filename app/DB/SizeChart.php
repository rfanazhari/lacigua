<?php namespace App\DB;

class SizeChart extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SizeChart;
		return $this->db;
	}
}