<?php

/*
 * This file is dynamically web routes | invasma sinar indonesia.
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
	$inv['basesite']		= (isset($inv['config']['issecure']) && $inv['config']['issecure']? 'https://' : 'http://').str_replace('http://', '', str_replace('https://', '', Request::root())).'/';
	$inv['realbasesite']	= (isset($inv['config']['issecure']) && $inv['config']['issecure']? 'https://' : 'http://').str_replace('http://', '', str_replace('https://', '', Request::root())).'/';
} else {
	$inv['basesite']		= (isset($inv['config']['issecure']) && $inv['config']['issecure']? 'https://' : 'http://').$inv['basedomain'].'/';
	$inv['realbasesite']	= (isset($inv['config']['issecure']) && $inv['config']['issecure']? 'https://' : 'http://').$inv['basedomain'].'/';
}

$inv['benchmark']	=  [
	'routessstarttime'		=> $starttime,
	'routessendtime'		=> '',
	'routesloadtime'		=> '',
	'controllerstarttime'	=> $starttime,
	'controllerendtime'		=> '',
	'controllerloadtime'	=> '',
];

if(!function_exists('_truepath')) {
	function _truepath($path) {
	    $unipath = strlen($path) == 0 || $path{0} != '/';

	    if(strpos($path,':') === false && $unipath)
	        $path = getcwd().DIRECTORY_SEPARATOR.$path;

	    $path 		= str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
	    $parts		= array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
	    $absolutes	= array();

	    foreach ($parts as $part) {
	        if ('.'  == $part) continue;
	        if ('..' == $part) {
	            array_pop($absolutes);
	        } else {
	            $absolutes[] = $part;
	        }
	    }

	    $path = implode(DIRECTORY_SEPARATOR, $absolutes);

	    if(file_exists($path) && linkinfo($path)>0) $path = readlink($path);

	    $path = !$unipath ? '/'.$path : $path;

	    return $path;
	}
}

if(!function_exists('_folder_exist')) {
	function _folder_exist($folder) {
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$path = realpath(base_path().$folder);
			if($path !== false AND is_dir($path)) {
		        return $path;
		    }
		} else {
			$path = _truepath(base_path().$folder);
			if($path !== false) {
		        return $path;
		    }
		}

	    return false;
	}
}

if(!function_exists('_debugvar')) {
	function _debugvar($obj, $exit = false) {
		global $inv;
		if($inv['config']['debugmode']) {
			$trace				= debug_backtrace()[0];
			if(isset($trace['file']) && $trace['file']) {
				$result['file']	= str_replace(base_path(), '', $trace['file']);
				$result['line']	= $trace['line'];
			}
			$result['result']	= $obj;
			
			echo '<pre>';
			print_r($result);
			echo '</pre>';
			
			if($exit) exit;
		}
	}
}

if(!function_exists('_checkerror')) {
	function _checkerror($uri, $slice, &$inv) {
		$errorpage = false;
	    foreach (array_slice($uri, $slice) as $val) {
		    if(substr_count($val, "_") < 1) {
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

if (explode('/', $inv['baseuri'])[0] != 'api') {
    Route::any('{uri}', function ($uri) use (&$inv) {
    	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
		$inv['action'] = 'index';

		App::setLocale('en');

		$uri = explode('/', $uri);
		$checklang = false;

		$frontend = '';
		switch ($inv['config']['frontend']['type']) {
			case 1:
				$frontend = 'frontend1';
				break;
			case 2:
				$frontend = 'frontend2';
				break;
		}

		if(array_search(str_replace('/', '', $inv['config']['backend']['aliaspage']), $uri) !== false || $inv['config']['backend']['aliaspage'] == '') {
			if(isset($inv['config']['backend']['lang'])) {
				$inv['lang']['backend'] = $inv['config']['backend']['lang'][0];
				App::setLocale($inv['lang']['backend']['link']);

				if(in_array($uri[0], array_column($inv['config']['backend']['lang'],'link'))) {
					$checklang = true;
					$inv['lang']['backend'] = $inv['config']['backend']['lang'][array_search($uri[0], array_column($inv['config']['backend']['lang'], 'link'))];
					App::setLocale($uri[0]);
					if($inv['lang']['backend']['link'] != array_column($inv['config']['backend']['lang'], 'link')[0])
						$inv['basesite'] .= $uri[0].'/';
					unset($uri[0]);
				}

				$uri = implode('/', array_values($uri));
				if(isset($inv['lang']['backend']['link']) && $inv['lang']['backend']['link'] == array_column($inv['config']['backend']['lang'], 'link')[0] && $checklang == true) {
					return redirect()->to($inv['basesite'].$uri);
				}
			}
		} else {
			if(isset($inv['config']['frontend']['lang'])) {
				$inv['lang']['frontend'] = $inv['config']['frontend']['lang'][0];
				App::setLocale($inv['lang']['frontend']['link']);

				if(in_array($uri[0], array_column($inv['config']['frontend']['lang'],'link'))) {
					$checklang = true;
					$inv['lang']['frontend'] = $inv['config']['frontend']['lang'][array_search($uri[0], array_column($inv['config']['frontend']['lang'], 'link'))];
					App::setLocale($uri[0]);
					if($inv['lang']['frontend']['link'] != array_column($inv['config']['frontend']['lang'], 'link')[0])
						$inv['basesite'] .= $uri[0].'/';
					unset($uri[0]);
				}

				$uri = implode('/', array_values($uri));
				if(isset($inv['lang']['frontend']['link']) && $inv['lang']['frontend']['link'] == array_column($inv['config']['frontend']['lang'], 'link')[0] && $checklang == true) {
					return redirect()->to($inv['basesite'].$uri);
				}
			}
		}

		if(is_array($uri)) $uri = implode('/', array_values($uri));
		
		if(!$uri) $uri = '/';

		if($inv['config']['backend']['aliaspage']) {
			if($uri != '/') {
				if($uri != $frontend) {
					$uri = explode('/', $uri);
					if(strpos($uri[0], '-') !== false && count(array_filter(explode('-', $uri[0]))) > 1)  {
						$uri[0] = str_replace('-', '', $uri[0]);
					}

					$folderpath = '\App\Modules\\'.$frontend.'\Http\Controllers\\'.$uri[0];
					$folderexist = _folder_exist($folderpath);

					$checkfolder = true;
					if($folderexist) {
						if(isset($uri[1])) {
							if(strpos($uri[1], '-') !== false && count(array_filter(explode('-', $uri[1]))) > 1) {
								$uri[1] = str_replace('-', '', $uri[1]);
							}

							$controller = $uri[1].'Controller';
							if (class_exists($folderpath.'\\'.$controller)) {
								$inv['location'] = $folderpath.'\\'.$controller;
								if(isset($uri[2])) {
									$checkclass = new $inv['location'];
									if (method_exists($checkclass, $uri[2])) {
							            $inv['action'] = $uri[2];
							            $errorpage = false;
							            foreach (array_slice($uri, 3) as $val) {
										    if(substr_count($val, "_") < 1) {
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
										    if(substr_count($val, "_") < 1) {
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
						$controller = $uri[0].'Controller';
						if (class_exists('\App\Modules\\'.$frontend.'\Http\Controllers\\'.$controller)) {
							$inv['location'] = '\App\Modules\\'.$frontend.'\Http\Controllers\\'.$controller;
							if(isset($uri[1])) {
								$checkclass = new $inv['location'];
								if (method_exists($checkclass, $uri[1])) {
						            $inv['action'] = $uri[1];
						            $errorpage = false;
						            foreach (array_slice($uri, 2) as $val) {
									    if(substr_count($val, "_") < 1) {
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
									    if(substr_count($val, "_") < 1) {
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
					    	$controller = $frontend.'Controller';
						    if (class_exists('\App\Modules\\'.$frontend.'\Http\Controllers\\'.$controller)) {
								$inv['location'] = '\App\Modules\\'.$frontend.'\Http\Controllers\\'.$controller;
								if(isset($uri[0])) {
									$checkclass = new $inv['location'];
									if (method_exists($checkclass, $uri[0])) {
							            $inv['action'] = $uri[0];
							            $errorpage = false;
							            foreach (array_slice($uri, 1) as $val) {
										    if(substr_count($val, "_") < 1) {
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
										    if(substr_count($val, "_") < 1) {
												$errorpage = true;
												break;
											}
										}
										if($errorpage) {
											if(str_replace('/', '', $inv['config']['backend']['aliaspage']) == $uri[0]) {
												if(count($uri) == 1) {
													$controller = 'loginController';
												    if (class_exists('\App\Http\Controllers\\'.$controller)) {
														$inv['location'] = '\App\Http\Controllers\\'.$controller;
												    }
												} else {
													unset($uri[0]);
													$uri = array_values($uri);
													if(!in_array($uri[0], ['api',$frontend,'errornie'])) {
														if($uri[0] == 'logout') {
															$controller = 'logoutController';
														    if (class_exists('\App\Http\Controllers\\'.$controller)) {
																$inv['location'] = '\App\Http\Controllers\\'.$controller;

																if(isset($uri[1])) {
																	$checkclass = new $inv['location'];
																	if (method_exists($checkclass, $uri[1])) {
															            $inv['action'] = $uri[1];
															            _checkerror($uri, 2, $inv);
															        } else {
															        	_checkerror($uri, 1, $inv);
															        }
																}
														    }
														} else if($uri[0] == 'default') {
															$controller = 'defaultController';
														    if (class_exists('\App\Http\Controllers\\'.$controller)) {
																$inv['location'] = '\App\Http\Controllers\\'.$controller;

																if(isset($uri[1])) {
																	$checkclass = new $inv['location'];
																	if (method_exists($checkclass, $uri[1])) {
															            $inv['action'] = $uri[1];
															            _checkerror($uri, 2, $inv);
															        } else {
															        	_checkerror($uri, 1, $inv);
															        }
																}
														    }
														} else if($uri[0] == 'profile') {
															$controller = 'profileController';
														    if (class_exists('\App\Http\Controllers\\'.$controller)) {
																$inv['location'] = '\App\Http\Controllers\\'.$controller;

																if(isset($uri[1])) {
																	$checkclass = new $inv['location'];
																	if (method_exists($checkclass, $uri[1])) {
															            $inv['action'] = $uri[1];
															            _checkerror($uri, 2, $inv);
															        } else {
															        	_checkerror($uri, 1, $inv);
															        }
																}
														    }
														} else if($uri[0] == 'lock') {
															$controller = 'lockController';
														    if (class_exists('\App\Http\Controllers\\'.$controller)) {
																$inv['location'] = '\App\Http\Controllers\\'.$controller;

																if(isset($uri[1])) {
																	$checkclass = new $inv['location'];
																	if (method_exists($checkclass, $uri[1])) {
															            $inv['action'] = $uri[1];
															            _checkerror($uri, 2, $inv);
															        } else {
															        	_checkerror($uri, 1, $inv);
															        }
																}
														    }
														} else {
															$controller = 'page'.$uri[0].'Controller';
														    if (class_exists('\App\Http\Controllers\Errors\\'.$controller)) {
																$inv['location'] = '\App\Http\Controllers\Errors\\'.$controller;
														    } else {
														    	$folderpath = '\App\Modules\\'.$uri[0];
																$folderexist = _folder_exist($folderpath);

																$checkfolder = true;
																if($folderexist) {
																	$controller = $uri[0].'Controller';
																    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller)) {
																		$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller;

																		if(isset($uri[1])) {
																			$checkclass = new $inv['location'];
																			if (method_exists($checkclass, $uri[1])) {
																	            $inv['action'] = $uri[1];
																	            _checkerror($uri, 2, $inv);
																	        } else {
																	        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
																				$inv['action'] = 'index';

																	        	$controller = $uri[1].'Controller';
																			    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller)) {
																					$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller;

																					if(isset($uri[2])) {
																						$checkclass = new $inv['location'];
																						if (method_exists($checkclass, $uri[2])) {
																				            $inv['action'] = $uri[2];
																				            _checkerror($uri, 3, $inv);
																				        } else {
																				        	$errorpage = false;
																				            foreach (array_slice($uri, 2) as $val) {
																							    if(substr_count($val, "_") < 1) {
																									$errorpage = true;
																									break;
																								}
																							}
																							if($errorpage) {
																								$controller = $uri[2].'Controller';
																							    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller)) {
																									$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller;

																									if(isset($uri[3])) {
																										$checkclass = new $inv['location'];
																										if (method_exists($checkclass, $uri[3])) {
																								            $inv['action'] = $uri[3];
																								            _checkerror($uri, 4, $inv);
																								        } else {
																								        	_checkerror($uri, 3, $inv);
																								        }
																									}
																							    }
																							}
																				        }
																					}
																			    } else {
																					if(isset($uri[2])) {
																						$checkclass = new $inv['location'];
																						if (method_exists($checkclass, $uri[2])) {
																				            $inv['action'] = $uri[2];
																				            _checkerror($uri, 3, $inv);
																				        } else {
																				        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
																							$inv['action'] = 'index';
																							
																				        	$errorpage = false;
																				            foreach (array_slice($uri, 2) as $val) {
																							    if(substr_count($val, "_") < 1) {
																									$errorpage = true;
																									break;
																								}
																							}
																							if($errorpage) {
																								$controller = $uri[2].'Controller';
																							    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller)) {
																									$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller;

																									if(isset($uri[3])) {
																										$checkclass = new $inv['location'];
																										if (method_exists($checkclass, $uri[3])) {
																								            $inv['action'] = $uri[3];
																								            _checkerror($uri, 4, $inv);
																								        } else {
																								        	_checkerror($uri, 3, $inv);
																								        }
																									}
																							    }
																							}
																				        }
																					}
																			    }
																	        }
																		}
																    }
																}
														    }
														}
													} else {
														if($uri[0] == 'errornie') {
															$folderpath = '\App\Modules\\'.$uri[0];
															$folderexist = _folder_exist($folderpath);

															if($folderexist) {
																$controller = $uri[0].'Controller';
															    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller)) {
																	$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller;

																	if(isset($uri[1])) {
																		$checkclass = new $inv['location'];
																		if (method_exists($checkclass, $uri[1])) {
																            $inv['action'] = $uri[1];
																            _checkerror($uri, 2, $inv);
																        } else {
																        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
																			$inv['action'] = 'index';

																        	$controller = $uri[1].'Controller';
																		    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller)) {
																				$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller;

																				if(isset($uri[2])) {
																					$checkclass = new $inv['location'];
																					if (method_exists($checkclass, $uri[2])) {
																			            $inv['action'] = $uri[2];
																			            _checkerror($uri, 3, $inv);
																			        } else {
																			        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
																						$inv['action'] = 'index';

																			        	$errorpage = false;
																			            foreach (array_slice($uri, 2) as $val) {
																						    if(substr_count($val, "_") < 1) {
																								$errorpage = true;
																								break;
																							}
																						}
																						if($errorpage) {
																							$controller = $uri[2].'Controller';
																						    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller)) {
																								$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller;

																								if(isset($uri[3])) {
																									$checkclass = new $inv['location'];
																									if (method_exists($checkclass, $uri[3])) {
																							            $inv['action'] = $uri[3];
																							            _checkerror($uri, 4, $inv);
																							        } else {
																							        	_checkerror($uri, 3, $inv);
																							        }
																								}
																						    }
																						}
																			        }
																				}
																		    } else {
																				if(isset($uri[2])) {
																					$checkclass = new $inv['location'];
																					if (method_exists($checkclass, $uri[2])) {
																			            $inv['action'] = $uri[2];
																			            _checkerror($uri, 3, $inv);
																			        } else {
																			        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
																						$inv['action'] = 'index';
																						
																			        	$errorpage = false;
																			            foreach (array_slice($uri, 2) as $val) {
																						    if(substr_count($val, "_") < 1) {
																								$errorpage = true;
																								break;
																							}
																						}
																						if($errorpage) {
																							$controller = $uri[2].'Controller';
																						    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller)) {
																								$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller;

																								if(isset($uri[3])) {
																									$checkclass = new $inv['location'];
																									if (method_exists($checkclass, $uri[3])) {
																							            $inv['action'] = $uri[3];
																							            _checkerror($uri, 4, $inv);
																							        } else {
																							        	_checkerror($uri, 3, $inv);
																							        }
																								}
																						    }
																						}
																			        }
																				}
																		    }
																        }
																	}
															    }
															}
														}
													}
												}
											} else {
												$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
												$inv['action'] = 'index';
											}										
										}
							        }
								}
						    }
					    }
					}
				}
			} else {
				$controller = $frontend.'Controller';
			    if (class_exists('\App\Modules\\'.$frontend.'\Http\Controllers\\'.$controller)) {
					$inv['location'] = '\App\Modules\\'.$frontend.'\Http\Controllers\\'.$controller;
			    }
			}

			if(!(isset($inv['config']['backend']['pagedefault']) && $inv['config']['backend']['pagedefault']) && $inv['location'] == '\App\Http\Controllers\defaultController') {
				$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
			}

			if(isset($inv['config']['fdevelopment']['status']) && $inv['config']['fdevelopment']['status'] && $inv['config']['frontend']['type'] == 1) $inv['location'] = '\App\Modules\\'.$frontend.'\Http\Controllers\developmentController';
		} else {
			if($uri != '/') {
				$uri = explode('/', $uri);
				if(!in_array($uri[0], ['api',$frontend,'errornie'])) {
					if($uri[0] == 'logout') {
						$controller = 'logoutController';
					    if (class_exists('\App\Http\Controllers\\'.$controller)) {
							$inv['location'] = '\App\Http\Controllers\\'.$controller;

							if(isset($uri[1])) {
								$checkclass = new $inv['location'];
								if (method_exists($checkclass, $uri[1])) {
						            $inv['action'] = $uri[1];
						            _checkerror($uri, 2, $inv);
						        } else {
						        	_checkerror($uri, 1, $inv);
						        }
							}
					    }
					} else if($uri[0] == 'default') {
						$controller = 'defaultController';
					    if (class_exists('\App\Http\Controllers\\'.$controller)) {
							$inv['location'] = '\App\Http\Controllers\\'.$controller;

							if(isset($uri[1])) {
								$checkclass = new $inv['location'];
								if (method_exists($checkclass, $uri[1])) {
						            $inv['action'] = $uri[1];
						            _checkerror($uri, 2, $inv);
						        } else {
						        	_checkerror($uri, 1, $inv);
						        }
							}
					    }
					} else if($uri[0] == 'profile') {
						$controller = 'profileController';
					    if (class_exists('\App\Http\Controllers\\'.$controller)) {
							$inv['location'] = '\App\Http\Controllers\\'.$controller;

							if(isset($uri[1])) {
								$checkclass = new $inv['location'];
								if (method_exists($checkclass, $uri[1])) {
						            $inv['action'] = $uri[1];
						            _checkerror($uri, 2, $inv);
						        } else {
						        	_checkerror($uri, 1, $inv);
						        }
							}
					    }
					} else if($uri[0] == 'lock') {
						$controller = 'lockController';
					    if (class_exists('\App\Http\Controllers\\'.$controller)) {
							$inv['location'] = '\App\Http\Controllers\\'.$controller;

							if(isset($uri[1])) {
								$checkclass = new $inv['location'];
								if (method_exists($checkclass, $uri[1])) {
						            $inv['action'] = $uri[1];
						            _checkerror($uri, 2, $inv);
						        } else {
						        	_checkerror($uri, 1, $inv);
						        }
							}
					    }
					} else {
						$controller = 'page'.$uri[0].'Controller';
					    if (class_exists('\App\Http\Controllers\Errors\\'.$controller)) {
							$inv['location'] = '\App\Http\Controllers\Errors\\'.$controller;
					    } else {
					    	$folderpath = '\App\Modules\\'.$uri[0];
							$folderexist = _folder_exist($folderpath);

							$checkfolder = true;
							if($folderexist) {
								$controller = $uri[0].'Controller';
							    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller)) {
									$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller;

									if(isset($uri[1])) {
										$checkclass = new $inv['location'];
										if (method_exists($checkclass, $uri[1])) {
								            $inv['action'] = $uri[1];
								            _checkerror($uri, 2, $inv);
								        } else {
								        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
											$inv['action'] = 'index';

								        	$controller = $uri[1].'Controller';
										    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller)) {
												$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller;

												if(isset($uri[2])) {
													$checkclass = new $inv['location'];
													if (method_exists($checkclass, $uri[2])) {
											            $inv['action'] = $uri[2];
											            _checkerror($uri, 3, $inv);
											        } else {
											        	$errorpage = false;
											            foreach (array_slice($uri, 2) as $val) {
														    if(substr_count($val, "_") < 1) {
																$errorpage = true;
																break;
															}
														}
														if($errorpage) {
															$controller = $uri[2].'Controller';
														    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller)) {
																$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller;

																if(isset($uri[3])) {
																	$checkclass = new $inv['location'];
																	if (method_exists($checkclass, $uri[3])) {
															            $inv['action'] = $uri[3];
															            _checkerror($uri, 4, $inv);
															        } else {
															        	_checkerror($uri, 3, $inv);
															        }
																}
														    }
														}
											        }
												}
										    } else {
												if(isset($uri[2])) {
													$checkclass = new $inv['location'];
													if (method_exists($checkclass, $uri[2])) {
											            $inv['action'] = $uri[2];
											            _checkerror($uri, 3, $inv);
											        } else {
											        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
														$inv['action'] = 'index';
														
											        	$errorpage = false;
											            foreach (array_slice($uri, 2) as $val) {
														    if(substr_count($val, "_") < 1) {
																$errorpage = true;
																break;
															}
														}
														if($errorpage) {
															$controller = $uri[2].'Controller';
														    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller)) {
																$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller;

																if(isset($uri[3])) {
																	$checkclass = new $inv['location'];
																	if (method_exists($checkclass, $uri[3])) {
															            $inv['action'] = $uri[3];
															            _checkerror($uri, 4, $inv);
															        } else {
															        	_checkerror($uri, 3, $inv);
															        }
																}
														    }
														}
											        }
												}
										    }
								        }
									}
							    }
							}
					    }
					}
				} else {
					if($uri[0] == 'errornie') {
						$folderpath = '\App\Modules\\'.$uri[0];
						$folderexist = _folder_exist($folderpath);

						if($folderexist) {
							$controller = $uri[0].'Controller';
						    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller)) {
								$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller;

								if(isset($uri[1])) {
									$checkclass = new $inv['location'];
									if (method_exists($checkclass, $uri[1])) {
							            $inv['action'] = $uri[1];
							            _checkerror($uri, 2, $inv);
							        } else {
							        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
										$inv['action'] = 'index';

							        	$controller = $uri[1].'Controller';
									    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller)) {
											$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$controller;

											if(isset($uri[2])) {
												$checkclass = new $inv['location'];
												if (method_exists($checkclass, $uri[2])) {
										            $inv['action'] = $uri[2];
										            _checkerror($uri, 3, $inv);
										        } else {
										        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
													$inv['action'] = 'index';

										        	$errorpage = false;
										            foreach (array_slice($uri, 2) as $val) {
													    if(substr_count($val, "_") < 1) {
															$errorpage = true;
															break;
														}
													}
													if($errorpage) {
														$controller = $uri[2].'Controller';
													    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller)) {
															$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller;

															if(isset($uri[3])) {
																$checkclass = new $inv['location'];
																if (method_exists($checkclass, $uri[3])) {
														            $inv['action'] = $uri[3];
														            _checkerror($uri, 4, $inv);
														        } else {
														        	_checkerror($uri, 3, $inv);
														        }
															}
													    }
													}
										        }
											}
									    } else {
											if(isset($uri[2])) {
												$checkclass = new $inv['location'];
												if (method_exists($checkclass, $uri[2])) {
										            $inv['action'] = $uri[2];
										            _checkerror($uri, 3, $inv);
										        } else {
										        	$inv['location'] = '\App\Http\Controllers\Errors\page404Controller';
													$inv['action'] = 'index';
													
										        	$errorpage = false;
										            foreach (array_slice($uri, 2) as $val) {
													    if(substr_count($val, "_") < 1) {
															$errorpage = true;
															break;
														}
													}
													if($errorpage) {
														$controller = $uri[2].'Controller';
													    if (class_exists('\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller)) {
															$inv['location'] = '\App\Modules\\'.$uri[0].'\Http\Controllers\\'.$uri[1].'\\'.$controller;

															if(isset($uri[3])) {
																$checkclass = new $inv['location'];
																if (method_exists($checkclass, $uri[3])) {
														            $inv['action'] = $uri[3];
														            _checkerror($uri, 4, $inv);
														        } else {
														        	_checkerror($uri, 3, $inv);
														        }
															}
													    }
													}
										        }
											}
									    }
							        }
								}
						    }
						}
					}
				}
			} else {
				$controller = 'loginController';
			    if (class_exists('\App\Http\Controllers\\'.$controller)) {
					$inv['location'] = '\App\Http\Controllers\\'.$controller;

					if(isset($uri[1])) {
						$checkclass = new $inv['location'];
						if (method_exists($checkclass, $uri[1])) {
				            $inv['action'] = $uri[1];
				            _checkerror($uri, 2, $inv);
				        } else {
				        	_checkerror($uri, 1, $inv);
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