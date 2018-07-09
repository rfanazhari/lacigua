<?php namespace App\Library;

use Illuminate\Database\Eloquent\Model;

class GlobalFunctionsCall extends Model {
	public function __call($method, $args) {
		$globalcall = new \App\Library\GlobalFunctions();
		if (method_exists($globalcall, $method)) return call_user_func_array(array($globalcall, $method), $args);
	}
}