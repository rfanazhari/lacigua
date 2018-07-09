<?php namespace App\DB;

class IconSocialMedia extends \App\Library\ModelFunction
{
	var $db;
	public function __construct() {
		$this->db = new \App\Models\IconSocialMedia;
		return $this->db;
	}
}