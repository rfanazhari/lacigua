<?php

namespace App\Modules\api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class apiController extends Controller
{
    public function index()
    {
        $inv['location']    = '\App\Http\Controllers\Errors\page404Controller';
        $inv['action']      = 'index';
        
        $container  = app(\Illuminate\Container\Container::class);
        $route      = app(\Illuminate\Routing\Route::class);
        
        return (new \Illuminate\Routing\ControllerDispatcher($container))->dispatch($route, new $inv['location'], $inv['action']);
    }
}