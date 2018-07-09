<?php

namespace App\Http\Controllers\Errors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class page404Controller extends Controller
{
  public function index()
  {
    // $this->_debugvar($this->inv);
    $this->inv['inv'] = $this;
    return view('errors.404', $this->inv);
  }
}