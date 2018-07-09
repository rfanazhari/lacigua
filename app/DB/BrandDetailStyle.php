<?php namespace App\DB;

class BrandDetailStyle extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\BrandDetailStyle;
		return $this->db;
	}
}