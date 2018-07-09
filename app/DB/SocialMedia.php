<?php namespace App\DB;

class SocialMedia extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\SocialMedia;
		return $this->db;
	}
}