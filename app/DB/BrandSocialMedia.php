<?php namespace App\DB;

class BrandSocialMedia extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\BrandSocialMedia;
		return $this->db;
	}
}