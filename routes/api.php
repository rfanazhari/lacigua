<?php

/*
 * This file is dynamically api routes | invasma sinar indonesia.
 *
 * (c) Refnaldi Hakim Monintja <refnaldihakim@invasma.com>
 *
 * INVASMA 2016
 */

$starttime = round(microtime(TRUE), 3);

global $inv;
$inv = [];
$inv['config'] = \App\Library\Setting::loadconfig();

$requestroot	= Request::root();
$requesturl		= Request::url();

if($requestroot == $requesturl) $inv['baseuri'] = '';
else $inv['baseuri'] = str_replace($requestroot.'/', '', $requesturl);

if(strpos($requestroot, 'localhost') !== false) {
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		$arrbasepath = explode('\\', base_path());
	} else {
		$arrbasepath = explode('/', base_path());
	}
	
	$folder			= $arrbasepath[count($arrbasepath) - 1];
	$requestroot	= str_replace('/'.$folder, '', $requestroot);
	$requesturl		= str_replace('/'.$folder, '', $requesturl);
	$requestroot	= str_replace('localhost', $inv['config']['project']['site'], $requestroot);
	$requesturl		= str_replace('localhost', $inv['config']['project']['site'], $requesturl);
}

$inv['basedomain']	= str_replace('http://', '', str_replace('https://', '', $requestroot));

if(strpos(Request::root(), 'localhost') !== false) {
	$inv['basesite']	= (isset($inv['config']['issecure']) && $inv['config']['issecure']? 'https://' : 'http://').str_replace('http://', '', str_replace('https://', '', Request::root())).'/';
} else {
	$inv['basesite']	= (isset($inv['config']['issecure']) && $inv['config']['issecure']? 'https://' : 'http://').$inv['basedomain'].'/';
}

$inv['benchmark']	=  [
	'routessstarttime'		=> $starttime,
	'routessendtime'		=> '',
	'routesloadtime'		=> '',
	'controllerstarttime'	=> $starttime,
	'controllerendtime'		=> '',
	'controllerloadtime'	=> '',
];

if (explode('/', $inv['baseuri'])[0] == 'api') {
    Route::any('{uri}', function ($uri) use (&$inv) {
    	$inv['location']	= '\App\Http\Controllers\Errors\page404Controller';
		$inv['action']		= 'index';
		
    	if($uri != '/') {
    		$uri = explode('/', $uri);

			$folderpath = '\App\Modules\api\Http\Controllers\\'.$uri[0];
			$folderexist = _folder_exist($folderpath);
			
			$checkfolder = true;
			if($folderexist) {
				if(isset($uri[1])) {
					$contoller = $uri[1].'Controller';
					if (class_exists($folderpath.'\\'.$contoller)) {
						$inv['location'] = $folderpath.'\\'.$contoller;
						if(isset($uri[2])) {
							$checkclass = new $inv['location'];
							if (method_exists($checkclass, $uri[2])) {
					            $inv['action'] = $uri[2];
					            $errorpage = false;
					            foreach (array_slice($uri, 3) as $val) {
								    if(substr_count($val, "_") != 1) {
										$errorpage = true;
										break;
									}
								}
								if($errorpage) {
									$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
									$inv['action'] = 'index';
								}
					        } else {
					        	$errorpage = false;
					            foreach (array_slice($uri, 2) as $val) {
								    if(substr_count($val, "_") != 1) {
										$errorpage = true;
										break;
									}
								}
								if($errorpage) {
									$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
									$inv['action'] = 'index';
								}
					        }
						}
					} else {
						$checkfolder = false;
					}
				} else {
					$checkfolder = false;
				}
			} else {
				$checkfolder = false;
			}
			
			if(!$checkfolder) {
				$contoller = $uri[0].'Controller';
				if (class_exists('\App\Modules\api\Http\Controllers\\'.$contoller)) {
					$inv['location'] = '\App\Modules\api\Http\Controllers\\'.$contoller;
					if(isset($uri[1])) {
						$checkclass = new $inv['location'];
						if (method_exists($checkclass, $uri[1])) {
				            $inv['action'] = $uri[1];
				            $errorpage = false;
				            foreach (array_slice($uri, 2) as $val) {
							    if(substr_count($val, "_") != 1) {
									$errorpage = true;
									break;
								}
							}
							if($errorpage) {
								$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
								$inv['action'] = 'index';
							}
				        } else {
				        	$errorpage = false;
				            foreach (array_slice($uri, 1) as $val) {
							    if(substr_count($val, "_") != 1) {
									$errorpage = true;
									break;
								}
							}
							if($errorpage) {
								$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
								$inv['action'] = 'index';
							}
				        }
					}
			    } else {
					$frontend = '';
					switch ($inv['config']['frontend']['type']) {
						case 1:
							$frontend = 'frontend1';
							break;
						case 2:
							$frontend = 'frontend2';
							break;
					}
			    	$contoller = $frontend.'Controller';
				    if (class_exists('\App\Modules\api\Http\Controllers\\'.$contoller)) {
						$inv['location'] = '\App\Modules\api\Http\Controllers\\'.$contoller;
						if(isset($uri[0])) {
							$checkclass = new $inv['location'];
							if (method_exists($checkclass, $uri[0])) {
					            $inv['action'] = $uri[0];
					            $errorpage = false;
					            foreach (array_slice($uri, 1) as $val) {
								    if(substr_count($val, "_") != 1) {
										$errorpage = true;
										break;
									}
								}
								if($errorpage) {
									$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
									$inv['action'] = 'index';
								}
					        } else {
					        	$errorpage = false;
					            foreach (array_slice($uri, 0) as $val) {
								    if(substr_count($val, "_") != 1) {
										$errorpage = true;
										break;
									}
								}
								if($errorpage) {
									$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
									$inv['action'] = 'index';
								}
					        }
						}
				    }
			    }
			}
		}
		
    	$container 	= app(\Illuminate\Container\Container::class);
		$route 		= app(\Illuminate\Routing\Route::class);
		
		$endtime							= round(microtime(TRUE), 3);
		$inv['benchmark']['routessendtime']	= $endtime;
		$inv['benchmark']['routesloadtime']	= round($endtime - $inv['benchmark']['routessstarttime'], 3);

		// _debugvar($inv['location']);
		// _debugvar($inv['action']);
		return (new \Illuminate\Routing\ControllerDispatcher($container))->dispatch($route, new $inv['location'], $inv['action']);
	})->where('uri', '(.*)');
}