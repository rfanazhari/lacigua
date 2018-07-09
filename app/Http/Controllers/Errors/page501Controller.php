<?php

namespace App\Http\Controllers\Errors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class page501Controller extends Controller
{
    public function index()
    {
  //   	$this->_loaddbclass([ 'mastermenu' ]);

  //       $mastermenu = $this->mastermenu->_execute([
  //           '_getall',
  //           'wherein' => ['key' => 'menu', 'val' => [3,4]],
  //           'orderby' => ['key' => 'priority', 'by' => "ASC"],
  //       ]);

  //       \Session::put('userdata', $mastermenu);

  //       $this->_debugvar($mastermenu);

  //   	$uuserdata = \Session::get('userdata');
		// $this->_debugvar($uuserdata);
		
        echo 'error501';
    }
}