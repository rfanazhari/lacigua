<?php

/*
 * This file is core function invasma sinar indonesia.
 *
 * (c) Refnaldi Hakim Monintja <refnaldihakim@invasma.com>
 *
 * INVASMA 2016
 */

namespace App\Library;

class GlobalFunctions extends ModelFunction {
	var $inv;
	
	public function __construct() {
		global $inv;
		$this->inv = $inv;
		$this->inv['config'] = \App\Library\Setting::loadconfig();
		
		date_default_timezone_set($this->inv['config']['timezone']);

		if(!(strpos($this->inv['baseuri'], $this->inv['config']['backend']['aliaspage']) !== false)) {
			\App::setLocale('id');
		}
	}
	
	public function instance() {
		return $this;
	}
	
	public function _loadfcclass($arr) {
		foreach($arr as $val) {
			$class = '\App\Library\\'.ucwords($val);
			$this->$val = new $class();
		}
	}
	
	public function _loaddbclass($arr) {
		foreach($arr as $val) {
			$class = '\App\DB\\'.ucwords($val);
			$this->$val = new $class();
		}
	}

	public function _dbsetpage($page) { 
		\Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page) {
			return $page;
		});
	}

	public function _dblog($log, $class, $desc) {
		$classname		= str_replace('Controller', '', class_basename($class));
		$userdata 		= \Session::get('userdata');
		$uuserid		= $userdata['uuserid'];
		$uusergroupid	= $userdata['uusergroupid'];
		
		if($log == 'login') {
			$temp_pagelog	= 'Login';
			$temp_actionlog	= 'Login';
		} else if($log == 'forget') {
			$temp_pagelog	= 'Forget';
			$temp_actionlog	= 'Forget';
			$uusergroupid = $uuserid = 0;
		} else if($log == 'logout') {
			$temp_pagelog	= 'Logout';
			$temp_actionlog	= 'Logout';
		} else if($log == 'personalinfo') {
			$temp_pagelog	= 'Profile';
			$temp_actionlog	= 'Personal Info';
		} else if($log == 'personalaccess') {
			$temp_pagelog	= 'Profile';
			$temp_actionlog	= 'Personal Access';
		} else {
			$this->_loaddbclass([ 'MasterMenu' ]);
			$data = $this->MasterMenu->getparrent([['permalink','=',$classname]])->first();
			$temp_pagelog	= $data['_getparrent']['name'];
			$temp_actionlog = $data['name'];
		}
		
		$array	= array(
			'idGroup'	=> 	$uusergroupid,
			'idUser'	=> 	$uuserid,
			'pageLog'	=> 	$temp_pagelog,
			'actionLog'	=>	$temp_actionlog,
			'dateLog'	=>	new \DateTime("now")
		);
		
		$temp_desc = 'IP : ' . $this->_getvisitip() . '<br/>Hostname : ' . gethostbyaddr($this->_getvisitip());
		
		switch($log) {
			case 'addnew':
				$array['descLog'] = $temp_desc . '<br/><b><span class=\'green\'>Add New '.$temp_actionlog.' : </span><u>'.$desc.'</u></b>';
				break;
			case 'edit':
				$array['descLog'] = $temp_desc . '<br/><b><span class=\'brown\'>Edit '.$temp_actionlog.' : </span><u>'.$desc.'</u></b>';
				break;
			case 'delete':
				$array['descLog'] = $temp_desc . '<br/><b><span class=\'red\'>Delete '.$temp_actionlog.' : </span><u>'.$desc.'</u></b>';
				break;
			case 'login':
				$array['descLog'] = $temp_desc . '<br/><b><span class=\'green\'>User Login : </span><u>'.$desc.'</u></b>';
				break;
			case 'forget':
				$array['descLog'] = $temp_desc . '<br/><b><span class=\'green\'>User Forget : </span><u>'.$desc.'</u></b>';
				break;
			case 'logout':
				$array['descLog'] = $temp_desc . '<br/><b><span class=\'brown\'>User Logout : </span><u>'.$desc.'</u></b>';
				break;
			case 'personalinfo':
				$array['descLog'] = $temp_desc . '<br/><b><span class=\'brown\'>Update Personal Info : </span><u>'.$desc.'</u></b>';
				break;
			case 'personalaccess':
				$array['descLog'] = $temp_desc . '<br/><b><span class=\'brown\'>Update Personal Access</b>';
				break;
			case 'log':
				$this->_loaddbclass([ 'MasterGroup', 'MasterUser', 'MasterUserLogBackup' ]);
				$MasterGroup = $this->MasterGroup->where([['idGroup','=',$uusergroupid,]])->first();
				$MasterUser = $this->MasterUser->where([['idUser','=',$uuserid]])->first();
				$array	= array(
					'namaGroup'	=> 	$MasterGroup->namaGroup,
					'namaUser'	=> 	$MasterUser->name,
					'pageLog'	=> 	$temp_pagelog,
					'actionLog'	=>	$temp_actionlog,
					'dateLog'	=>	new \DateTime("now")
				);
				$array['descLog'] = $temp_desc . '<br/><b><span class=\'red\'>Delete '.$temp_actionlog.' : </span><u>'.$desc.'</u></b>';
				return $this->MasterUserLogBackup->creates($array);
				break;
		}
		
		$this->_loaddbclass([ 'MasterUserLog' ]);

		return $this->MasterUserLog->creates($array);
	}

	public function _dbquerysearch($data, $flip) {
		if(isset($this->inv['getsearchby']) && strpos($this->inv['getsearchby'], 'date') !== false) {
			$datefirst = $datelast = '';
			if($this->_dateformysql($this->inv['getsearch']))
				$datefirst	= $this->_dateformysql($this->inv['getsearch']);
			if($this->_dateformysql($this->inv['getsearchlast']))
				$datelast	= $this->_dateformysql($this->inv['getsearchlast']);
			if($datefirst && $datelast)
				$data = $data->whereBetween($flip[$this->inv['getsearchby']], array($datefirst, $datelast));
			elseif($datefirst && !$datelast)
				$data = $data->where($flip[$this->inv['getsearchby']], '>=', $datefirst);
			elseif(!$datefirst && $datelast)
				$data = $data->where($flip[$this->inv['getsearchby']], '<=', $datelast);
		} elseif(isset($this->inv['getsearchby'])) {
			$data = $data->where($flip[$this->inv['getsearchby']], 'like', '%'.$this->inv['getsearch'].'%');
		}
	}
	
	public function _dbgetenum($classname, $fieldname) {
		$classname 	= '\App\Models\\'.$classname;
		$tablename 	= (new $classname)->getTable();
		$columns 	= \DB::select(\DB::raw("SHOW COLUMNS FROM $tablename WHERE Field = '$fieldname'"))[0]->Type;
		$enum		= explode("','", str_replace("enum('", "", str_replace("')", "", $columns)));
		
		return $enum;
	}

	public function _dbgetlastincrement($database, $tablename) {
		$lastincrement = \DB::select(\DB::raw("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$tablename'"));

		return $lastincrement[0]->AUTO_INCREMENT;
	}

	public function _dbgetlastrow($tablename, $field, $order = 'ID', $ordering = 'DESC') {
		$result = \DB::table($tablename)->select($field)->orderBy($order, $ordering)->first();
		if($result) return $result->$field;
		else return 0;
	}

	public function _setdatapaginate($data, $paginationfrontend = false) {
		$this->inv['result']['total']		= $data['total'];
		$this->inv['result']['pagetotal']	= $data['last_page'];
		$this->inv['result']['data']		= $data['data'];
		
		$this->inv['result']['parameter']	= $this->_getparameter();
		
		if($this->inv['config']['frontend']['type'] == 2 && strpos($this['inv']['baseuri'], $this->inv['config']['backend']['aliaspage']) === false) {
			$link = str_replace('frontend2/', '', $this->inv['extlink']);
		} else if($this->inv['config']['frontend']['type'] == 1) {
			$link = $this->inv['extlink'];
		} else {
			$link = $this->inv['config']['backend']['aliaspage'].$this->inv['extlink'];
		}

		if($paginationfrontend) {
			$this->inv['result']['pagination']	= $this->_paginationfrontend(
												$this->inv['getpage'],
												$this->inv['result']['pagetotal'],
												$link
											);
		} else {
			$this->inv['result']['pagination']	= $this->_pagination(
												$this->inv['getpage'],
												$this->inv['result']['pagetotal'],
												$link,
												$this->inv['result']['parameter']
											);
		}
	}

	public function _getparameter($parameter='') {
		isset($this->inv['getsearchby']) ?
			$parameter .= 'searchby_'.$this->inv['getsearchby'].'/'		: $parameter .= '';
		isset($this->inv['getsearch']) ?
			$parameter .= 'search_'.$this->inv['getsearch'].'/'			: $parameter .= '';
		isset($this->inv['getsearchlast']) ?
			$parameter .= 'searchlast_'.$this->inv['getsearchlast'].'/'	: $parameter .= '';
		isset($this->inv['getorder']) ?
			$parameter .= 'order_'.$this->inv['getorder'].'/'			: $parameter .= '';
		isset($this->inv['getsort']) ?
			$parameter .= 'sort_'.$this->inv['getsort'].'/'				: $parameter .= '';
		return rtrim($parameter,'/');
	}

	public function _pagination($page, $totalpage, $extlink, $parameter) {
		if($totalpage != 0) {
			$paging = '';
			if($totalpage == 1) {
				$first 		= '<div class="fleft"><a href="javascript:;" class="fleft buttondisabled">'.$this->_trans('pagination.first').'</a></div>';
				$next 		= '<div class="fleft pleft"><a href="javascript:;" class="fleft pleft buttondisabled">'.$this->_trans('pagination.next').'</a></div>';
				$paging		= '<div class="fleft pleft"><a type="select" class="fleft pleft buttondisabled">1</a></div>';
				$previous 	= '<div class="fleft pleft"><a href="javascript:;" class="fleft pleft buttondisabled">'.$this->_trans('pagination.previous').'</a></div>';
				$last 		= '<div class="fleft pleft"><a href="javascript:;" class="fleft pleft buttondisabled">'.$this->_trans('pagination.last').'</a></div>';
			} else {
				if($page < 5) {
					$start = 1;
					if($totalpage >= 10) { $end = 10; }
					else { $end = $totalpage; }
				} else {
					if(($page >= 5) and ($totalpage <= 10)) {
						$start = 1;
						$end = $totalpage;
					} else {
						if(($totalpage - $page) < 5) {
							$start = $totalpage - 9;
							$end = $totalpage;
						} else {
							$start = $page - 4;
							$end = $page + 5;
						}
					}
				}
				if($page != $totalpage) {
					$next = '<div class="fleft pleft"><a href="'.$this->inv['basesite'].$extlink.'/'.$parameter.'/page_'.($page+1).'" class="fleft pleft button">'.$this->_trans('pagination.next').'</a></div>';
					$last = '<div class="fleft pleft"><a href="'.$this->inv['basesite'].$extlink.'/'.$parameter.'/page_'.$totalpage.'" class="fleft pleft button">'.$this->_trans('pagination.last').'</a></div>';
				} else {
					$next = '<div class="fleft pleft"><a href="javascript:;" class="fleft pleft button buttondisabled">'.$this->_trans('pagination.next').'</a></div>';
					$last = '<div class="fleft pleft"><a href="javascript:;" class="fleft pleft button buttondisabled">'.$this->_trans('pagination.last').'</a></div>';
				}
				for($i=$start; $i<=$end; $i++) {
					if($i == $page) { $paging = $paging.'<div class="fleft pleft"><a type="select" class="fleft pleft button">'.$i.'</a></div>'; }
					else { $paging = $paging.'<div class="fleft pleft"><a href="'.$this->inv['basesite'].$extlink.'/'.$parameter.'/page_'.$i.'" class="fleft pleft button">'.$i.'</a></div>'; }
				}
				if($page != 1) {
					$previous = '<div class="fleft pleft"><a href="'.$this->inv['basesite'].$extlink.'/'.$parameter.'/page_'.($page-1).'" class="fleft pleft button">'.$this->_trans('pagination.previous').'</a></div>';
					$first = '<div class="fleft"><a href="'.$this->inv['basesite'].$extlink.'/'.$parameter.'" class="fleft button">'.$this->_trans('pagination.first').'</a></div>';
				} else {
					$previous = '<div class="fleft pleft"><a href="javascript:;" class="fleft pleft button buttondisabled">'.$this->_trans('pagination.previous').'</a></div>';
					$first = '<div class="fleft"><a href="javascript:;" class="fleft button buttondisabled">'.$this->_trans('pagination.first').'</a></div>';
				}
			}
			return '
				<div id="paging">
					'.$first.$next.$paging.$previous.$last.'
					<div class="clearf"></div>
				</div>
			';
		}
	}

	public function _paginationfrontend($page, $totalpage, $extlink) {
		if($totalpage != 0) {
			$paging = '';
			if($totalpage == 1) {
				$first 		= '<li class="disabled"><a href="javascript:;"><<</a></li>';
				$next 		= '<li class="disabled"><a href="javascript:;">></a></li>';
				$paging		= '<li class="disabled"><a>1</a></li>';
				$previous 	= '<li class="disabled"><a href="javascript:;"><</a></li>';
				$last 		= '<li class="disabled"><a href="javascript:;">>></a></li>';
			} else {
				if($page < 5) {
					$start = 1;
					if($totalpage >= 10) { $end = 10; }
					else { $end = $totalpage; }
				} else {
					if(($page >= 5) and ($totalpage <= 10)) {
						$start = 1;
						$end = $totalpage;
					} else {
						if(($totalpage - $page) < 5) {
							$start = $totalpage - 9;
							$end = $totalpage;
						} else {
							$start = $page - 4;
							$end = $page + 5;
						}
					}
				}

				if(strpos($extlink, 'page_') !== false) {
					$extlink = substr($extlink, 0, strlen($extlink) - strlen(('/page_'.$page)));
				}
				if($page != $totalpage) {
					$next = '<li><a href="'.$this->inv['basesite'].$extlink.'/page_'.($page+1).'">></a></li>';
					$last = '<li><a href="'.$this->inv['basesite'].$extlink.'/page_'.$totalpage.'">>></a></li>';
				} else {
					$next = '<li class="disabled"><a href="javascript:;">></a></li>';
					$last = '<li class="disabled"><a href="javascript:;">>></a></li>';
				}
				for($i=$start; $i<=$end; $i++) {
					if($i == $page) { $paging = $paging.'<li class="active"><a href="javascript:;">'.$i.'</a></li>'; }
					else { $paging = $paging.'<li><a href="'.$this->inv['basesite'].$extlink.'/page_'.$i.'">'.$i.'</a></li>'; }
				}
				if($page != 1) {
					$previous = '<li><a href="'.$this->inv['basesite'].$extlink.'/page_'.($page-1).'"><</a></li>';
					$first = '<li><a href="'.$this->inv['basesite'].$extlink.'"><<</a></li>';
				} else {
					$previous = '<li class="disabled"><a href="javascript:;"><</a></li>';
					$first = '<li class="disabled"><a href="javascript:;"><<</a></li>';
				}
			}
			return '
				<ul class="pagination type_2 after_clear">
					'.$first.$next.$paging.$previous.$last.'
				</ul>
			';
		}
	}

	public function _reupdatesession($name) {
		if(\Cookie::get($name) !== null) {
			\Session::forget($name);
			\Session::put($name, \Cookie::get($name));
		}
	}

	public function _debugvar($obj, $exit = false) {
		global $inv;
		if(isset($inv['config']['debugmode']) && $inv['config']['debugmode']) {
			$trace				= debug_backtrace()[0];
			if(isset($trace['file']) && $trace['file']) {
				$result['file']	= str_replace(base_path(), '', $trace['file']);
				$result['line']	= $trace['line'];
			}
			$result['result']	= $obj;

			echo '<br/><br/><pre>';
			print_r($result);
			echo '</pre>';
			
			if($exit) exit;
		}
	}
	
	public function _loadmenu() {
		$this->inv['menu'] 	= array();

		$userdata 		= \Session::get('userdata');
		$uuserid		= $userdata['uuserid'];
		$uusergroupid	= $userdata['uusergroupid'];

		$this->_loaddbclass([ 'MasterMenu','MasterMenuAccess' ]);

		$arraymenu = $this->MasterMenu->getmenu(['idMParrent','=',0])->get()->toArray();
		$this->inv['menu'] = $this->MasterMenuAccess->getmenuextends([$arraymenu,['idGroup','=',$uusergroupid]]);

		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$path = base_path().'\app\Modules';
		} else {
			$path = base_path().'/app/Modules';
		}

		$checkfolder = $this->_checkfolder($path, "errornie");

		if ($checkfolder) {
			$controller = "/$checkfolder/Http/Controllers";
			$files = scandir($path.$controller);

			$array = array(
				'idMMenu'		=> 999999900,
				'idMParrent'	=> 0,
				'priority'		=> 0,
				'name'			=> 'Invasma Core',
				'permalink'		=> 'errornie',
				'menu'			=> 1,
				'route'			=> '',
				'icon'			=> 'fa-star',
				'errornie'		=> [],
			);

			if(count($files) > 3) {
				$count = 0;
				foreach ($files as $file) {
					if ($file != '.' && $file != '..' && $file != '.gitkeep' && $file != 'errornieController.php') {
						$name = explode('.', str_replace('Controller', '', $file))[0];
						$index = array_search(strtolower($name).'Controller.php', $files);
						if(!$index) $index = 2;

						$count = $index - 2 + $count;
						$checkfolder = $this->_checkfolder($path.'/errornie/Http/Controllers/', strtolower($name));
						if ($checkfolder) {
							$tmpname = '';
							switch (strtolower($name)) {
								default: $tmpname = ucwords(strtolower($name)); break;
							}
							$array['errornie'][$count] = [
								'parentName'		=> 'errornie',
								'idMMenu'			=> ($count) + 999999900 + 1,
								'idMParrent'		=> 999999900,
								'priority'			=> $count,
								'name'				=> $tmpname.' Setting',
								'permalink'			=> strtolower($name),
								'menu'				=> 2,
								'route'				=> '',
								'icon'				=> '',
								strtolower($name)	=> [],
							];

							$scount = 0;
							$subfiles = scandir($path.$controller.'/'.strtolower($name));
							foreach ($subfiles as $sfile) {
								if ($sfile != '.' && $sfile != '..') {
									$sname = explode('.', str_replace('Controller', '', $sfile))[0];
									$sindex = array_search(strtolower($sname).'Controller.php', $subfiles);
									if(!$sindex) $sindex = 2;

									$scount = $sindex - 2 + $scount;
									if(is_numeric($scount)) {
										$tmpname = '';
										switch (strtolower($sname)) {
											case 'prapproval': $tmpname = 'PR Approval'; break;
											case 'poapproval': $tmpname = 'PO Approval'; break;
											default: $tmpname = ucwords(strtolower($sname)); break;
										}
										$array['errornie'][$count][strtolower($name)][] = [
											'parentName'		=> strtolower($name),
											'idMMenu'			=> $count + $scount + 999999900 + 2,
											'idMParrent'		=> ($count) + 999999900 + 1,
											'priority'			=> $scount,
											'name'				=> $tmpname,
											'permalink'			=> strtolower($sname),
											'menu'				=> 3,
											'route'				=> 'errornie/'.strtolower($name).'/',
											'icon'				=> '',
										];
									}
								}
							}
						}

						if(is_numeric($count) && !$checkfolder) {
							$tmpname = '';
							switch (strtolower($name)) {
								default: $tmpname = ucwords(strtolower($name)); break;
							}
							$array['errornie'][$count] = [
								'parentName'		=> 'errornie',
								'idMMenu'			=> ($count) + 999999900 + 1,
								'idMParrent'		=> 999999900,
								'priority'			=> $count,
								'name'				=> $tmpname,
								'permalink'			=> strtolower($name),
								'menu'				=> 4,
								'route'				=> 'errornie/',
								'icon'				=> '',
							];
						}
						$count++;
					}
				}

				$this->inv['menu'] = array_merge(['errornie' => $array], $this->inv['menu']);
			}
		}

		if(isset($this->inv['lang']) && key($this->inv['lang']) == 'frontend' && $this->inv['lang'][key($this->inv['lang'])]['link'] != $this->inv['config']['frontend']['lang'][0]['link']) {
			foreach ($this->inv['menu'][''][''] as $key => $value) {
				$this->inv['menu'][''][''][$key]['name'] = $this->_trans('frontend.menudb.'.$value['parentName'].$value['permalink']);
				if(isset($value[$value['permalink']]) && is_array($value[$value['permalink']]) && count($value[$value['permalink']]) !=0) {
					foreach ($value[$value['permalink']] as $keys => $values) {
						$this->inv['menu'][''][''][$key][$value['permalink']][$keys]['name'] = $this->_trans('frontend.menudb.'.$values['parentName'].$values['permalink']);
					}
				}
			}
		}
		if(isset($this->inv['lang']) && key($this->inv['lang']) == 'backend' && $this->inv['lang'][key($this->inv['lang'])]['link'] != $this->inv['config']['backend']['lang'][0]['link']) {
			foreach ($this->inv['menu'][key($this->inv['menu'])][key($this->inv['menu'])] as $key => $value) {
				// if($value['permalink'] == 'userteam')
				// $this->inv['menu'][key($this->inv['menu'])][key($this->inv['menu'])][$key]['name'] = $this->_trans('backend.menudb.'.$value['permalink']);
				// if(isset($value[$value['permalink']]) && is_array($value[$value['permalink']]) && count($value[$value['permalink']]) !=0) {
				// 	foreach ($value[$value['permalink']] as $keys => $values) {
				// 		$this->inv['menu'][key($this->inv['menu'])][key($this->inv['menu'])]	[$key][$value['permalink']][$keys]['name'] = $this->_trans('backend.menudb.'.$values['parentName'].$values['permalink']);
				// 	}
				// }
			}
		}
	}
	
	public function _startmenu() {
		$this->_loadmenu();
		
		$url = '';
		if((count(\Request::segments())==1 && \Request::segment(1).'/' == $this->inv['config']['backend']['aliaspage'] || (isset($this->inv['config']['lang']) && in_array($this->inv['urilang']['link'], array_column($this->inv['config']['lang'],'link')) && \Request::segment(2).'/' == $this->inv['config']['backend']['aliaspage'])) || count(\Request::segments())==0) {
			reset($this->inv['menu']);
			$key = key($this->inv['menu']);
			
			if(isset($this->inv['config']['backend']['pagedefault']) && $this->inv['config']['backend']['pagedefault']) {
				$url = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].'default';
			} else {
				$url = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].$this->inv['menu'][$key]['permalink'];
			}
			
			if(isset(\Session::get('tmplink')['tmplink'])) {
				$tmplink = \Session::get('tmplink')['tmplink'];
				\Session::forget('tmplink');
				$url = $this->inv['basesite'].$tmplink;
			}
		}

		if(isset(\Session::get('previousurl')['previousurl'])) {
			$url = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].'lock';
		}

		return $url;
	}

	public function _accessdata($class, $function, $data = array()) {
        $classname 	= str_replace('Controller', '', class_basename($class));
		$userdata	= \Session::get('userdata');

		$url		= '';
		if($userdata) {
			$uuserid		= $userdata['uuserid'];
			$uusergroupid	= $userdata['uusergroupid'];
			$this->_loaddbclass([ 'MasterUser' ]);

			$MasterUser = $this->MasterUser->where([['idUser','=',$uuserid]])->first();

			if($MasterUser->statususer == 'Non Active') {
				$url = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].'logout';
			} else {
				$this->_loaddbclass([ 'MasterMenu' ]);
		        
		        $reflector 		= new \ReflectionClass(get_class($this));
				$extlink 		= $reflector->getFileName();
				
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
					$extlink		= str_replace(base_path().'\app\Modules\\', '', $extlink);
					$extlink 		= str_replace('Http\Controllers\\', '', $extlink);
					$extlink 		= array_pad(array_unique(explode('\\', str_replace('Controller.php', '', $extlink))), -3, '');
				} else {
					$extlink		= str_replace(base_path().'/app/Modules/', '', $extlink);
					$extlink 		= str_replace('Http/Controllers/', '', $extlink);
					$extlink 		= array_pad(array_unique(explode('/', str_replace('Controller.php', '', $extlink))), -3, '');
				}
				
				$tmpextlink 	= array_values(array_diff($extlink, ['']));

		        if(count($tmpextlink) > 1) {
		        	if(count($tmpextlink) == 2) {
		        		$condition = [['a.permalink','=',$tmpextlink[0]], ['master_menu.permalink','=',$classname]];
		        		$MasterMenu = $this->MasterMenu->join([
				        	['master_menu as a', 'a.idMMenu', '=', 'master_menu.idMParrent']
				    	]);
		        	} else {
		        		if($this->inv['config']['frontend']['type'] == 2 && strpos($this['inv']['baseuri'], $this->inv['config']['backend']['aliaspage']) === false) {
							$tmpextlink[0] = '';
						}
		        		$condition = [
		        			['b.permalink','=',$tmpextlink[0]], ['a.permalink','=',$tmpextlink[1]], ['master_menu.permalink','=',$classname]
		        		];
		        		$MasterMenu = $this->MasterMenu->join([
				        	['master_menu as a', 'a.idMMenu', '=', 'master_menu.idMParrent'],
				        	['master_menu as b', 'b.idMMenu', '=', 'a.idMParrent']
				    	]);
		        	}

		        	$MasterMenu = $MasterMenu->where($condition)->select(['master_menu.*']);
		        } else {
		       		$condition = [['permalink','=',$classname]];
		       		
		       		$MasterMenu = $this->MasterMenu->where($condition)->where('idMParrent', 0);
		       	}

				if($MasterMenu->first()) {
					$condition = [['idMMenu','=',$MasterMenu->first()->idMMenu]];
					$condition[] = ['idGroup','=',$uusergroupid];
					$MasterMenu = $this->MasterMenu->getaction($condition);

					if($MasterMenu->first()->_getaction) {
						$condition[] = ['idUser','=',$uuserid];
						$MasterMenu = $this->MasterMenu->getfunction($condition);
						
						if($MasterMenu->first()->_getfunction) {
							$access = json_decode($MasterMenu->first()->_getfunction->access, true);
							if($access) {
								if(!in_array($function, $access)) {
									$url = '404';
								} else {
									$this->inv['access'] = $access;
								} 
							} else {
								$url = '404';
							}
						} else {
							$url = '404';
						}
					} else {
						$url = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'];
					}
				} else {
					$url = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'];
				}

				if(isset($data['module']) && count($data['module']) && $uuserid) $url = '';

				if(!$url) {
					$this->_loadmenu();

					$this->inv['header']	= isset($this->header) ? $this->header : [];
					$this->inv['flip']		= isset($this->alias) ? array_flip($this->alias) : [];
					$this->inv['alias']		= isset($this->aliasform) ? $this->aliasform : [];
					$this->inv['userdata']	= \Session::get('userdata');

					$tmplink = '';
					if(isset($data['module']) && count($data['module'])) {
						if(!in_array($function, $data['function'])) {
							$url = '404';
						} else {
							reset($this->inv['menu']);
							$this->inv['access']	= $data['function'];
							$this->inv['extlink']	= implode('/', $data['module']);
							$tmplink				= $this->inv['extlink'];
						}
					} else {
						$breadcrumb = $this->MasterMenu->getparrent([['idMMenu','=',$MasterMenu->first()->idMMenu]])->first()->toArray();
						$breadcrumbhigh = $breadcrumb['_getparrent']['_getparrent']['name'];
						$breadcrumbhigh = isset($breadcrumbhigh) ? $breadcrumbhigh.' / ' : '';
						$breadcrumbmiddle = $breadcrumb['_getparrent']['name'];
						$breadcrumbmiddle = isset($breadcrumbmiddle) ? $breadcrumbmiddle.' / ' : '';
						$breadcrumblow = $breadcrumb['name'];

						if(isset($this->inv['alias']['titlepage'])) {
							if($this->inv['alias']['titlepage'][2]) {
								if($this->inv['alias']['titlepage'][0] == 'DB')
									$this->inv['alias']['titlepage'][0] = $breadcrumbhigh.$breadcrumbmiddle.$breadcrumblow;
								else
									$this->inv['alias']['titlepage'][0] = $breadcrumbhigh.$breadcrumbmiddle.$this->inv['alias']['titlepage'][0];
							} else {
								if($this->inv['alias']['titlepage'][0] == 'DB')
									$this->inv['alias']['titlepage'][0] = $breadcrumblow;
								else
									$this->inv['alias']['titlepage'][0] = $this->inv['alias']['titlepage'][0];
							}
						}
						
						$this->inv['extlink'] = implode('/', array_values(array_filter($extlink)));
						$tmplink = $this->inv['extlink'];
					}

					if(isset($this->inv['alias']['titlepage'])) {
						$this->inv['pagename'] = $this->inv['alias']['titlepage'][0];
					}
					
					$this->inv['classname']	= explode('/', $tmplink);
					$this->inv['inv']		= $this;
					
					if(isset($this->alias)) {
						if(array_search('permalink', $this->alias)) $this->objectkey = 'permalink';
						else if(isset($this->alias['idfunction'])) $this->objectkey = $this->alias['idfunction'];
						else $this->objectkey = key($this->alias);
					} else $this->objectkey = 'permalink';

					if((\Session::get('messagesuccess') !== null)) {
						$this->inv['messagesuccess'] = \Session::get('messagesuccess');
						\Session::forget('messagesuccess');
					} else $this->inv['messagesuccess'] = '';
					if((\Session::get('messageerror') !== null)) {
						$this->inv['messageerror'] = \Session::get('messageerror');
						\Session::forget('messageerror');
					} else $this->inv['messageerror'] = '';
				}

				$uri = explode('/', $this->inv['baseuri']);
				
				if(count($uri)) {
					foreach($uri as $val) {
						$checkuri = explode('_', $val);
						if(count($checkuri) > 1) {
							$varget		= $checkuri[0];
							$vargetval	= substr($val, strlen($checkuri[0]) + 1, strlen($val) - strlen($checkuri[0]));
							if((isset($this->inv['get'.$varget]) && $this->inv['get'.$varget]) || (!$varget)) {
								$url = '404';
							} else {
								$this->inv['get'.$varget] = rawurldecode($vargetval);
							}
						}
					}
				}

				if(isset($this->inv['getsearchby']) && !in_array($this->inv['getsearchby'], $this->alias)) {
					$url = '404';
				}
				if(isset($this->inv['getorder']) && !in_array($this->inv['getorder'], $this->alias)) {
					$url = '404';
				} elseif(isset($this->alias) && !isset($this->inv['getorder'])) {
					if(count($this->alias) != 0) {
						$defaultorder = array_values($this->alias);
						$this->inv['getorder'] = $defaultorder[0];
					}
				}
				if(isset($this->inv['getsort']) && !in_array($this->inv['getsort'], array('asc', 'desc'))) {
					$url = '404';
				} elseif(!isset($this->inv['getsort'])) {
					$this->inv['getsort'] = 'desc';
				}
				if(isset($this->inv['getpage']) && !intval($this->inv['getpage'])) {
					$url = '404';
				} elseif(!isset($this->inv['getpage'])) {
					$this->inv['getpage'] = 1;
				}
				if(isset($this->inv['getpriority']) && $this->_checkpermalink($this->inv['getpriority'])) {
					$url = '404';
				}
				if(isset($this->inv['getdelete']) && $this->_checkpermalink($this->inv['getdelete'])) {
					$url = '404';
				}

				$request = \Request::instance()->request->all();

				if(!isset($request['delete'])) {
					foreach($request as $key => $val) {
						if($key == 'searchby_') {
							if(isset($this->inv['getsearchby'])) {
								if(!in_array($this->inv['getsearchby'], $this->alias)) {
									$url = '404';
								} else {
									$this->inv['getsearchby'] = $val;
									if(!in_array($this->inv['getsearchby'], $this->alias)) {
										$url = '404';
									}
								}
							} else {
								$this->inv['getsearchby'] = $val;
								if(!in_array($this->inv['getsearchby'], $this->alias)) {
									$url = '404';
								}
							}
						}
						if($key == 'search_') {
							$this->inv['getsearch'] = $val;
						}
						if($key == 'searchlast_') {
							$this->inv['getsearchlast'] = $val;
						}
					}
				} else {
					$this->inv['delete'] = [];
					if(is_array($request['delete'])) {
						foreach($request['delete'] as $val) {
							array_push($this->inv['delete'], $val);
						}
					}
				}

				$this->_dbsetpage($this->inv['getpage']);
			}
		} else {
			$url = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'];
			if($this->inv['config']['frontend']['type'] == 2 && strpos($this['inv']['baseuri'], $this->inv['config']['backend']['aliaspage']) === false) {
				$url = $this->inv['basesite'];
			}

			$tmplink['tmplink'] = $this->inv['baseuri'];
			\Session::put('tmplink', $tmplink);
		}
		
		$uri = $this->inv['baseuri'];
		if(isset($this->inv['config']['backend']['lang'])) {
			foreach (array_column($this->inv['config']['backend']['lang'], 'link') as $obj)  {
				$uri = str_replace($obj.'/', '', $uri);
			}
		}

		if(isset(\Session::get('previousurl')['previousurl']) && $uri != $this->inv['config']['backend']['aliaspage'].'lock') {
			$url = $this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].'lock';
		}

		return $url;
	}

	public function _geturi() {
		$uri = explode('/', $this->inv['baseuri']);

		if(count($uri)) {
			foreach($uri as $val) {
				$checkuri = explode('_', $val);
				if(count($checkuri) > 1) {
					$varget		= $checkuri[0];
					$vargetval	= substr($val, strlen($checkuri[0]) + 1, strlen($val) - strlen($checkuri[0]));
					if((isset($this->inv['get'.$varget]) && $this->inv['get'.$varget]) || (!$varget)) {
						$url = '404';
					} else {
						if($vargetval[0] == '[' && $vargetval[strlen($vargetval)-1] == ']') {
							$vargetval = explode('.', substr($vargetval, 1, -1));
							foreach ($vargetval as $key => $val) {
								$tmpkey = strtok($val, '[');
								$vargetval[$key] = [$varget => $tmpkey];
								$tmpval = explode(',', substr(ltrim($val, $tmpkey), 1, -1));
								if(count($tmpval) && trim($tmpval[0])) $vargetval[$key]['sub'.$varget] = $tmpval;
							}
						}

						$this->inv['get'.$varget] = $vargetval;
					}
				}
			}
		}
	}

	public function _redirect($url, $action = 'index') {
		$controller = 'page'.$url.'Controller';
	    if (class_exists('\App\Http\Controllers\Errors\\'.$controller)) {
			$controller = '\App\Http\Controllers\Errors\\'.$controller;
	    } else if (class_exists('\\'.$url)) {
	    	$controller = '\\'.$url;
	    } else {
	    	return \Redirect::to($url);
	    }

	    $container 	= app(\Illuminate\Container\Container::class);
		$route 		= app(\Illuminate\Routing\Route::class);
		return (new \Illuminate\Routing\ControllerDispatcher($container))->dispatch($route, new $controller, $action);
	}

	public function _showview($template = array()) {
		$frontend = '';
		if($this->inv['config']['frontend']['type'] == 2 && strpos($this['inv']['baseuri'], $this->inv['config']['backend']['aliaspage']) === false) {
			$frontend = 'frontend2.';
		}
		
		$views[] = view($frontend.'header', $this->inv);
		if($template) {
			if(is_array($template)) {
				foreach($template as $val) {
					if($val == 'new') {
						$extlink = explode('/', $this->inv['extlink']);
						if(count($extlink) > 2) {
							list($mastermodule,$submodule,$module) = $extlink;
							$val = $mastermodule.".".$submodule.".".$module."new";
						} else {
							list($mastermodule,$submodule) = $extlink;
							$val = $mastermodule.".".$submodule."new";
						}
						if($this->inv['config']['frontend']['type'] == 2 && strpos($this['inv']['baseuri'], $this->inv['config']['backend']['aliaspage']) === false) {
							$val = str_replace($frontend, '', $val);
						}
					}
					$views[] = view($frontend.$val, $this->inv)->render();
				}
			} else {
				if($template == 'new') {
					$extlink = explode('/', $this->inv['extlink']);
					if(count($extlink) > 2) {
						list($mastermodule,$submodule,$module) = $extlink;
						$template = $mastermodule.".".$submodule.".".$module."new";
					} else {
						list($mastermodule,$submodule) = $extlink;
						$template = $mastermodule.".".$submodule."new";
					}
					if($this->inv['config']['frontend']['type'] == 2 && strpos($this['inv']['baseuri'], $this->inv['config']['backend']['aliaspage']) === false) {
						$template = str_replace($frontend, '', $template);
					}
				}
				$views[] = view($frontend.$template, $this->inv);
			}
		}
	    $views[] = view($frontend.'footer', $this->inv);
	    return view('compile', ['views' => $views]);
	}
	
	public function _showviewfront($template = array(), $headerfooter = true) {
		if($headerfooter) {
			$this->_loaddbclass(['Currency', 'Category', 'Style', 'Brand']);

			$SubMenuCategory = [
				['Name' => 'View All', 'Permalink' => 'view-all'],
				['Name' => 'New Arrivals', 'Permalink' => 'new-arrivals'],
				['Name' => 'Most Wanted', 'Permalink' => 'most-wanted'],
				['Name' => 'SALE', 'Permalink' => 'sale'],
			];

			$arraymenu = $this->Category->getmodel()->with(['_child' => function($query) {
				$query->where([['IsActive', '=', 1],['Status', '=', 0],['ShowOnHeader', '=', 1]])->orderBy('Priority');
			}])->where([['IsActive', '=', 1],['Status', '=', 0],['ShowOnHeader', '=', 1]])->orderByRaw('case ModelType
				when "WOMEN" then 1
				when "MEN" then 2
				when "KIDS" then 3
			end')->orderBy('Priority')->get()->toArray();

			$arrBrand = $this->Brand->where([['ShowOnHeader', '=', 1],['IsActive', '=', 1],['Status', '=', 0]])->select(['*','permalink as Permalink'])->get()->toArray();

			$FEATURELABELS = array_values(array_filter($arrBrand, function (&$val, $key) { return $val['Mode'] == 0; }, ARRAY_FILTER_USE_BOTH));
			
			$ARTISTLABELS = array_values(array_filter($arrBrand, function (&$val, $key) { return $val['Mode'] == 1; }, ARRAY_FILTER_USE_BOTH));

			$INDIELABELS = array_values(array_filter($arrBrand, function (&$val, $key) { return $val['Mode'] == 2; }, ARRAY_FILTER_USE_BOTH));

			$arrmenu = [];
			foreach($arraymenu as $key => $val) {
				$arrmenu[$val['ModelType']][1]['CATEGORIES']['Name'] = 'CATEGORIES';
				$arrmenu[$val['ModelType']][1]['CATEGORIES']['Permalink'] = $this->_permalink($val['ModelType'].' CATEGORIES');
				$arrmenu[$val['ModelType']][1]['CATEGORIES']['SubMenu'] = $SubMenuCategory;
				$arrmenu[$val['ModelType']][$val['ColumnMode']][$val['Name']]['Name'] = $val['Name'];
				$arrmenu[$val['ModelType']][$val['ColumnMode']][$val['Name']]['Permalink'] = $val['ID'];
				if(is_array($val['_child']) && count($val['_child'])) {
					foreach($val['_child'] as $keys => $vals) {
						$arrmenu[$val['ModelType']][$val['ColumnMode']][$val['Name']]['SubMenu'][] = [
							'Name' => $vals['Name'],'Permalink' => $vals['ID']
						];
					}
				}
			}

			$Style = $this->Style->where([['IsActive', '=', 1],['Status', '=', 0],['ShowOnHeader', '=', 1]])
					->orderBy('Priority')->select([
						'Name',
						'permalink as Permalink',
					])->get()->toArray();

			$arrmenu['LABELS'][1]['CATEGORIES']['Name'] = 'STYLE';
			$arrmenu['LABELS'][1]['CATEGORIES']['Permalink'] = 'javascript:;';
			$arrmenu['LABELS'][1]['CATEGORIES']['SubMenu'] = $Style;

			$arrmenu = array_merge($arrmenu, ['SALE']);

			foreach($arrmenu as $key => $val) {
				if(!is_numeric($key)) {
					if($key != 'LABELS') {
						$arrmenu[$key][count($val) + 1]['BYLABELS']['Name'] = 'BY LABELS';
						$arrmenu[$key][count($val) + 1]['BYLABELS']['Permalink'] = 'labels/main_'.strtolower($key);
						$arrmenu[$key][count($val) + 1]['FEATURELABELS']['Name'] = 'FEATURE LABELS';
						$arrmenu[$key][count($val) + 1]['FEATURELABELS']['Permalink'] = 'labels/main_'.strtolower($key).'/select_feature';
						$arrmenu[$key][count($val) + 1]['FEATURELABELS']['SubMenu'] = array_values(array_filter($FEATURELABELS, function ($vals, $keys) use($key) { return strpos($vals['MainCategory'], '"'.$key.'"') !== false; }, ARRAY_FILTER_USE_BOTH));
						$arrmenu[$key][count($val) + 1]['ARTISTLABELS']['Name'] = 'ARTIST LABELS';
						$arrmenu[$key][count($val) + 1]['ARTISTLABELS']['Permalink'] = 'labels/main_'.strtolower($key).'/select_artist';
						$arrmenu[$key][count($val) + 1]['ARTISTLABELS']['SubMenu'] = array_values(array_filter($ARTISTLABELS, function ($vals, $keys) use($key) { return strpos($vals['MainCategory'], '"'.$key.'"') !== false; }, ARRAY_FILTER_USE_BOTH));
						$arrmenu[$key][count($val) + 1]['INDIELABELS']['Name'] = 'INDIE LABELS';
						$arrmenu[$key][count($val) + 1]['INDIELABELS']['Permalink'] = 'labels/main_'.strtolower($key).'/select_indie';
						$arrmenu[$key][count($val) + 1]['INDIELABELS']['SubMenu'] = array_values(array_filter($INDIELABELS, function ($vals, $keys) use($key) { return strpos($vals['MainCategory'], '"'.$key.'"') !== false; }, ARRAY_FILTER_USE_BOTH));
						$arrmenu[$key][count($val) + 1]['LABELSAZ']['Name'] = 'LABELS A - Z';
						$arrmenu[$key][count($val) + 1]['LABELSAZ']['Permalink'] = 'labels/main_'.strtolower($key).'/sort_a-z';
					} else {
						$arrmenu[$key][count($val) + 1]['POPULARLABELS']['Name'] = 'TOP RATED LABELS';
						$arrmenu[$key][count($val) + 1]['POPULARLABELS']['Permalink'] = 'labels/filter_top-rated';
						$arrmenu[$key][count($val) + 1]['FEATURELABELS']['Name'] = 'FEATURE LABELS';
						$arrmenu[$key][count($val) + 1]['FEATURELABELS']['Permalink'] = 'labels/select_feature';
						$arrmenu[$key][count($val) + 1]['FEATURELABELS']['SubMenu'] = $FEATURELABELS;
						$arrmenu[$key][count($val) + 1]['ARTISTLABELS']['Name'] = 'ARTIST LABELS';
						$arrmenu[$key][count($val) + 1]['ARTISTLABELS']['Permalink'] = 'labels/select_artist';
						$arrmenu[$key][count($val) + 1]['ARTISTLABELS']['SubMenu'] = $ARTISTLABELS;
						$arrmenu[$key][count($val) + 1]['INDIELABELS']['Name'] = 'INDIE LABELS';
						$arrmenu[$key][count($val) + 1]['INDIELABELS']['Permalink'] = 'labels/select_indie';
						$arrmenu[$key][count($val) + 1]['INDIELABELS']['SubMenu'] = $INDIELABELS;
						$arrmenu[$key][count($val) + 1]['LABELSAZ']['Name'] = 'LABELS A - Z';
						$arrmenu[$key][count($val) + 1]['LABELSAZ']['Permalink'] = 'labels/sort_a-z';
					}
				}
			}

			// $this->_debugvar($arrmenu);

			$this->_loaddbclass(['Setting']);

			$DataSetting = $this->Setting->where([['ID', '=', 1]])->first();
			$this->inv['DataSetting'] = $DataSetting;

			$this->inv['inv'] = $this;
			$this->inv['arrcurr'] = $this->Currency->where([['Status','=',0],['IsActive','=',1]])->get()->toArray();
			$this->inv['arrmenu'] = $arrmenu;

			$Cart = \Session::get('Cart');
	        if(!$Cart) $Cart = '';

	        $ArrayViewCart = $this->_constructViewCart($Cart);
	        if($ArrayViewCart) $this->inv['ArrayViewCart'] = $ArrayViewCart;
			
			$this->_loaddbclass(['SocialMedia']);

			$ArrSocialMedia = $this->SocialMedia->leftjoin([
				['icon_social_media as icm', 'icm.ID', '=', 'social_media.IconSocialMediaID']
	        ])->selectraw('
	            icm.ID as IconSocialMediaID,
	            icm.Image as IconSocialMediaImage,
	            icm.ImageHover as IconSocialMediaImageHover,
	            social_media.*
	        ')->where([['social_media.IsActive','=',1],['social_media.Status','=',0]])->get()->toArray();
	        $this->inv['ArrSocialMedia'] = $ArrSocialMedia;
		}

		new \ReflectionClass($this);
		
		if(isset(get_defined_vars()['this'])) {
			foreach (get_defined_vars()['this'] as $key => $value) {
				if($key == 'middleware') break;
				else $this->inv[$key] = $this->$key;
			}
		}

		if($headerfooter) {
			$views[] = view('frontend1.header', $this->inv);
		}

		$development = false;
		if($template) {
			if(is_array($template)) {
				foreach($template as $val) {
					if($val == 'new') {
						list($mastermodule,$submodule,$module) = explode('/', $this->inv['extlink']);
						$val = $mastermodule.".".$submodule.".".$module."new";
					}
					if($val == 'development') {
						$development = true;
					}
					$views[] = view('frontend1.'.$val, $this->inv)->render();
				}
			} else {
				if($template == 'new') {
					list($mastermodule,$submodule,$module) = explode('/', $this->inv['extlink']);
					$template = $mastermodule.".".$submodule.".".$module."new";
				}
				if($template == 'development') {
					$development = true;
				}
				$views[] = view('frontend1.'.$template, $this->inv);
			}
		}

		if(!$development) {
			if($headerfooter) {
				$views[] = view('frontend1.footer', $this->inv);
			}
		} else {
			unset($views[0]);
		}
	    
	    return view('compile', ['views' => $views]);
	}

	public function _changekeyarray( $array, $old_key, $new_key ) {
	    if( ! array_key_exists( $old_key, $array ) )
	        return $array;

	    $keys = array_keys( $array );
	    $keys[ array_search( $old_key, $keys ) ] = $new_key;

	    return array_combine( $keys, $array );
	}

	public function _arrayuniquemultidimentional($array = []) {
		return array_map("unserialize", array_unique(array_map("serialize", $array)));
	}

	public function _categoryfilterrecursive($array = [], $ModelType = '') {
		return array_values(array_filter($array, function (&$val, $key) use ($ModelType) {
			if(!$ModelType)
				$ModelType = strtolower($val['ModelType']);
			$val['permalink'] = str_replace($ModelType.'-', '', $val['permalink']);
			foreach ($val as $keys => $vals) {
				if(!in_array($keys, ['ID','Name','permalink','_child'])) {
					unset($val[$keys]);
				}
			}
			if(isset($val['_child']))
				$val['_child'] = $this->_categoryfilterrecursive($val['_child'], $ModelType);
			return $val;
		}, ARRAY_FILTER_USE_BOTH));
	}

	public function _extendsparseextlink($ArraySort, $ArrayExtlink, &$ArrayExtlinkNew, $get, $replacer, $obj) {
		$tmpget = explode('_', $obj);
		$ArrayExtlinkNew[array_search($tmpget[0], $ArraySort)] = $tmpget[0].'_'.substr($obj, strlen($tmpget[0]) + 1);
		if($replacer) {
			if($tmpget[0] == $get) {
				if($get == 'category' || $get == 'labels' || $get == 'style' || $get == 'colour') {
					$tmpget = 'category_';
					if($get == 'labels') $tmpget = 'labels_';
					if($get == 'style') $tmpget = 'style_';
					if($get == 'colour') $tmpget = 'colour_';

					$tmpreplacer = preg_grep ('/('.$tmpget.')/i', $ArrayExtlink);
					if(count($tmpreplacer)) {
						if($get == 'category' && strpos($replacer, 'check') !== false) {
							$tmpreplacer = ltrim(array_values(preg_grep ('/('.$tmpget.')/i', $ArrayExtlink))[0], $tmpget);
							$tmpreplacer = substr($tmpreplacer, 1, strlen($tmpreplacer) - 2);
							
							$checktmpreplacer = explode('.', $tmpreplacer);

							$tmpsubcategory = explode('[', ltrim(rtrim($replacer, ']'), 'check'));

							$tmpkey = $tmpval = '';
							foreach(preg_grep ('/('.$tmpsubcategory[0].')/i', $checktmpreplacer) as $key => $val) {
						        $tmpkey = $key;
						        $tmpval = $val;
						    }
						    
							$tmpreplacer = ltrim($tmpval, $tmpsubcategory[0]);
							$tmpreplacer = substr($tmpreplacer, 1, strlen($tmpreplacer) - 2);

							$checktmpreplacer2 = explode(',', $tmpreplacer);

							$checkunset = false;
							$checkkey = '';
							foreach($checktmpreplacer2 as $key => $val) {
						        if(!$checkunset) {
						        	if($val == $tmpsubcategory[1]) {
						        		$checkunset = true;
						        		$checkkey = $key;
						        	}
						        }
						    }

							if ($checkunset) unset($checktmpreplacer2[$checkkey]);

							if(!count($checktmpreplacer2)) unset($checktmpreplacer[$tmpkey]);
							else {
								if($checkunset)
									$tmpreplacer = implode(',', $checktmpreplacer2);
								else
									$tmpreplacer = implode(',', $checktmpreplacer2).','.$tmpsubcategory[1];

								$checktmpreplacer[$tmpkey] = $tmpsubcategory[0].'['.$tmpreplacer.']';
							}
							if(!count($checktmpreplacer)) unset($ArrayExtlinkNew[array_search($get, $ArraySort)]);
							else $ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_['.implode('.', $checktmpreplacer).']';
						} else {
							$tmpreplacer = ltrim(array_values(preg_grep ('/('.$tmpget.')/i', $ArrayExtlink))[0], $tmpget);
							$tmpreplacer = substr($tmpreplacer, 1, strlen($tmpreplacer) - 2);
							$checktmpreplacer = explode('.', $tmpreplacer);
							$checkunset = false;
							if (($key = array_search($replacer, $checktmpreplacer)) !== false) {
							    unset($checktmpreplacer[$key]);
							    $checkunset = true;
							} else {
								if($get == 'category') {
									$tmpcategory = explode('[', rtrim($replacer, ']'));

									foreach($checktmpreplacer as $key => $val) {
										if(!$checkunset) {
											$check = explode('[', $val);
											if($check[0] == $tmpcategory[0]) {
												unset($checktmpreplacer[$key]);
												$checkunset = true;
											}
										}
								    }
								}
							}
							if(!count($checktmpreplacer)) unset($ArrayExtlinkNew[array_search($get, $ArraySort)]);
							else {
								if($checkunset)
									$tmpreplacer = implode('.', $checktmpreplacer);
								else
									$tmpreplacer = implode('.', $checktmpreplacer).'.'.$replacer;
								$ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_['.$tmpreplacer.']';
							}
						}
					} else {
						$ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_['.$replacer.']';
					}
				} else {
					$ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_'.$replacer;
				}
			} else {
				if($get) {
					if($tmpget[0] != $get) {
						if($get == 'category' || $get == 'labels' || $get == 'style' || $get == 'colour') {
							$tmpget = 'category_';
							if($get == 'labels') $tmpget = 'labels_';
							if($get == 'style') $tmpget = 'style_';
							if($get == 'colour') $tmpget = 'colour_';
							$tmpreplacer = preg_grep ('/('.$tmpget.')/i', $ArrayExtlink);

							if(count($tmpreplacer)) {
								if($get == 'category' && strpos($replacer, 'check') !== false) {
									$tmpreplacer = ltrim(array_values(preg_grep ('/('.$tmpget.')/i', $ArrayExtlink))[0], $tmpget);
									$tmpreplacer = substr($tmpreplacer, 1, strlen($tmpreplacer) - 2);
									
									$checktmpreplacer = explode('.', $tmpreplacer);

									$tmpsubcategory = explode('[', ltrim(rtrim($replacer, ']'), 'check'));

									$tmpkey = $tmpval = '';
									foreach(preg_grep ('/('.$tmpsubcategory[0].')/i', $checktmpreplacer) as $key => $val) {
								        $tmpkey = $key;
								        $tmpval = $val;
								    }
								    
									$tmpreplacer = ltrim($tmpval, $tmpsubcategory[0]);
									$tmpreplacer = substr($tmpreplacer, 1, strlen($tmpreplacer) - 2);

									$checktmpreplacer2 = explode(',', $tmpreplacer);

									$checkunset = false;
									$checkkey = '';
									foreach($checktmpreplacer2 as $key => $val) {
								        if(!$checkunset) {
								        	if($val == $tmpsubcategory[1]) {
								        		$checkunset = true;
								        		$checkkey = $key;
								        	}
								        }
								    }

									if ($checkunset) unset($checktmpreplacer2[$checkkey]);

									if(!count($checktmpreplacer2)) unset($checktmpreplacer[$tmpkey]);
									else {
										if($checkunset)
											$tmpreplacer = implode(',', $checktmpreplacer2);
										else
											$tmpreplacer = implode(',', $checktmpreplacer2).','.$tmpsubcategory[1];

										$checktmpreplacer[$tmpkey] = $tmpsubcategory[0].'['.$tmpreplacer.']';
									}
									if(!count($checktmpreplacer)) unset($ArrayExtlinkNew[array_search($get, $ArraySort)]);
									else $ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_['.implode('.', $checktmpreplacer).']';
								} else {
									$tmpreplacer = ltrim(array_values(preg_grep ('/('.$tmpget.')/i', $ArrayExtlink))[0], $tmpget);
									$tmpreplacer = substr($tmpreplacer, 1, strlen($tmpreplacer) - 2);
									$checktmpreplacer = explode('.', $tmpreplacer);
									$checkunset = false;
									if (($key = array_search($replacer, $checktmpreplacer)) !== false) {
									    unset($checktmpreplacer[$key]);
									    $checkunset = true;
									} else {
										if($get == 'category') {
											$tmpcategory = explode('[', rtrim($replacer, ']'));

											foreach($checktmpreplacer as $key => $val) {
												if(!$checkunset) {
													$check = explode('[', $val);
													if($check[0] == $tmpcategory[0]) {
														unset($checktmpreplacer[$key]);
														$checkunset = true;
													}
												}
										    }
										}
									}
									if(!count($checktmpreplacer)) unset($ArrayExtlinkNew[array_search($get, $ArraySort)]);
									else {
										if($checkunset)
											$tmpreplacer = implode('.', $checktmpreplacer);
										else
											$tmpreplacer = implode('.', $checktmpreplacer).'.'.$replacer;
										$ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_['.$tmpreplacer.']';
									}
								}
							} else {
								$ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_['.$replacer.']';
							}
						} else {
							$ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_'.$replacer;
						}
					}
				} else {
					$ArrayExtlinkNew[array_search($tmpget[0], $ArraySort)] = $tmpget[0].'_'.substr($obj, strlen($tmpget[0]) + 1);
				}
			}
		} else {
			unset($ArrayExtlinkNew[array_search($get, $ArraySort)]);
		}
	}

	public function _cutstring($string, $length) {
		$tmpstring = explode(' ', $string);
		if(strlen($string) > $length) {
			if(count($tmpstring) == 1) return substr($string, 0, $length);
			else {
				unset($tmpstring[count($tmpstring) - 1]);
				return $this->_cutstring(implode(' ', $tmpstring), $length);
			}
		} else return $string;
	}

	public function _findarray($arraydata, $arrayfind, $multiple = false) {
		$result = [];
		foreach ($arraydata as $subarray) {
			if($multiple) {
				foreach ($arrayfind[1] as $subfind) {
					$result[] = $this->_findarray($arraydata, ['ID', $subfind, 'Name']);
				}
			} else {
				if (isset($subarray[$arrayfind[0]]) && $subarray[$arrayfind[0]] == $arrayfind[1]) {
					return $subarray[$arrayfind[2]]; 
				}
			}
		}
		if($multiple && $result) return array_unique($result);
		else return '';
	}
	
	public function _folder_exist($folder) {
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
	
	public function _truepath($path) {
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
	
	public function _sendemail($condition = []) {
		if(isset($condition['subject']) && isset($condition['from']) && isset($condition['to']) && isset($condition['message'])) {
			\Config::set('mail.driver', $this->inv['config']['email']['protocol']);
			\Config::set('mail.host', $this->inv['config']['email']['smtp_host']);
			\Config::set('mail.port', $this->inv['config']['email']['smtp_port']);
			\Config::set('mail.username', $this->inv['config']['email']['smtp_user']);
			\Config::set('mail.password', $this->inv['config']['email']['smtp_pass']);

			try {
				\Mail::send([], [], function ($message) use ($condition) {
					if(isset($condition['fromname'])) $message->from($condition['from'], $condition['fromname']);
					else $message->from($condition['from']);
					
					if(is_array($condition['to'])) {
						if(isset($condition['toname']) && is_array($condition['toname'])) $message->to($condition['to'], $condition['toname']);
						else $message->to($condition['to']);
					} else {
						if(isset($condition['toname'])) $message->to($condition['to'], $condition['toname']);
						else $message->to($condition['to']);
					}
					
					if(isset($condition['cc'])) {
						if(is_array($condition['cc'])) {
							if(isset($condition['ccname']) && is_array($condition['ccname'])) $message->cc($condition['cc'], $condition['ccname']);
							else $message->cc($condition['cc']);
						} else {
							if(isset($condition['ccname'])) $message->cc($condition['cc'], $condition['ccname']);
							else $message->cc($condition['cc']);
						}
					}
					
					if(isset($condition['bcc'])) {
						if(is_array($condition['bcc'])) {
							if(isset($condition['bccname']) && is_array($condition['bccname'])) $message->bcc($condition['bcc'], $condition['bccname']);
							else $message->bcc($condition['bcc']);
						} else {
							if(isset($condition['bccname'])) $message->bcc($condition['bcc'], $condition['bccname']);
							else $message->bcc($condition['bcc']);
						}
					}

				    $message->subject($condition['subject']);
					$message->setBody($condition['message'], 'text/html');
				});

				if(isset($condition['successmessage'])) return $condition['successmessage'];
				else return 'Email sent.';
			} catch(Exception $e) {
				if(isset($condition['errormessage'])) return $condition['errormessage'];
				else return 'Error : '.$e;
			}
		}
		
		return 'Error : Param is not completed !';
	}

	public function _checkfolder($d,$fn) {
		if (is_dir($d)) {
			if ($dh = opendir($d)) {
				while (($f = readdir($dh)) !== false)
					if($f != '.' && $f != '..')
						if($f == $fn) return $f;
				closedir($dh);
			}
			return false;
		}
		return false;
	}

	public function _stripslashes(&$arr) {
		if(is_array($arr)) {
			array_walk_recursive($arr, function (&$v) {
				$v = htmlentities($v, ENT_QUOTES);
			});
		} else {
			return htmlentities($arr, ENT_QUOTES);
		}
	}
	
	public function _backstripslashes(&$arr) {
		if(is_array($arr)) {
			array_walk_recursive($arr, function (&$v) {
				$v = html_entity_decode($v, ENT_QUOTES);
			});
		} else {
			return html_entity_decode($arr, ENT_QUOTES);
		}
	}
	
	public function _permalink($s, $dash = '-') {
		return str_replace($dash.$dash,$dash, str_replace("(",'', str_replace(")",'',str_replace(' ',$dash,strtolower(trim(preg_replace("/[^a-zA-Z0-9 -]/", '', $s)))))));
	}
	
	public function _checkpermalink($s,$ss='') { return preg_match ("/[^a-zA-Z0-9. _\-$ss]/", $s); }

	public function _numbersonly($s,$ss='') { return preg_match ("/[^0-9$ss]/", $s); }
	
	public function _charactersonly($s,$ss='') { return preg_match ("/[^a-zA-Z$ss]/", $s); }
	
	public function _numbersspace($s,$ss='') { return preg_match ("/[^0-9 $ss]/", $s); }
	
	public function _charactersspace($s,$ss='') { return preg_match ("/[^a-zA-Z $ss]/", $s); }
	
	public function _numberscharacters($s,$ss='') { return preg_match ("/[^0-9a-zA-Z$ss]/", $s); }
	
	public function _numberscharactersspace($s,$ss='') { return preg_match ("/[^0-9a-zA-Z $ss]/", $s); }
	
	public function _email($s) { return !filter_var($s, FILTER_VALIDATE_EMAIL); }

	public function _formatamount($amount, $currency = 'Dollar', $symbol = '') {
		if($currency != 'Dollar') return ($symbol?$symbol:''). number_format($amount, 0, ',', '.');
		else return ($symbol?$symbol:''). number_format($amount, 2, ',', '.');
	}
	
	public function _roundformatprice($amount, $currency = 'IDR', $html = true) {
		if($currency != 'IDR') return ($html ? $currency.' ' : '').number_format(round($amount, 2), 2, '.', $html ? ',' : '');
		else return ($html ? $currency.' ' : '').number_format(round($amount, -3), $html ? 2 : 0, ',', $html ? '.' : '');
	}
	
	public function _splitupper($s) {
		return preg_split('/(?=[A-Z])/', $s, -1, PREG_SPLIT_NO_EMPTY);
	}
	
	public function _checkbraces($str, $open = '{', $close = '}') {
		$strlen = strlen($str);
		$openbraces = 0;

		for ($i = 0; $i < $strlen; $i++) {
			$c = $str[$i];
			if ($c == $open) $openbraces++;
			if ($c == $close) $openbraces--;
			if ($openbraces < 0) return false;
		}

		return $openbraces == 0;
	}
	
	public function _getvisitip() {
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = @$_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP)) {
			return $client;
		} elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
			return $forward;
		} else {
			return $remote;
		}
	}
	
	public function _getHostname() {
		return gethostbyaddr($this->_getvisitip());
	}
	
	public function _converttobytesize($size) {
	    $unit = array('B','KB','MB','GB','TB','PB');
	    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}

	public function _dateformysql($d, $condition = []) {
		if($d == '') { return false; }
		if(isset($condition['monthyear']) && $condition['monthyear'] == true)
			return new \DateTime(date('Y-m',strtotime($d)));
		else return new \DateTime(date('Y-m-d',strtotime($d)));
	}
	
	public function _datetimeformysql($dt) {
		if($dt == '') { return false; }
		return new \DateTime(date('Y-m-d H:i:s',strtotime($dt)));
	}
	
	public function _dateforhtml($d, $condition = []) {
		if($d == '') { return false; }
		if(isset($condition['simplemonth'])) {
			if(isset($condition['monthyear']) && $condition['monthyear'] == true)
				return date('M Y',strtotime($d));
			elseif(isset($condition['monthdate']) && $condition['monthdate'] == true)
				return date('M d',strtotime($d));
			else return date('d M Y',strtotime($d));
		} else {
			if(isset($condition['monthyear']) && $condition['monthyear'] == true)
				return date('F Y',strtotime($d));
			elseif(isset($condition['monthdate']) && $condition['monthdate'] == true)
				return date('F d',strtotime($d));
			else return date('d F Y',strtotime($d));
		}
	}
	
	public function _datetimeforhtml($dt, $color = '') {
		if($color) {
			$color = "\\".implode("\\", str_split($color));
			return date("d F Y \<\s\p\a\\n \c\l\a\s\s\=\'$color'\>H:i:s\<\/\s\p\a\\n\>", strtotime($dt));
		} else {
			return date("d F Y H:i:s", strtotime($dt));
		}
	}

	public function _checkimage($fileImage, &$filetype) {
		switch ($fileImage->getMimeType()) {
			case 'image/gif':
				$filetype = ".gif";
				if (imagetypes() & IMG_GIF) return true; else return false; 
			break;
			case 'image/jpeg':
				$filetype = ".jpg";
				if (imagetypes() & IMG_JPG) return true; else return false; 
			break;
			case 'image/pjpeg':
				$filetype = ".jpg";
				if (imagetypes() & IMG_JPG) return true; else return false; 
			break;
			case 'image/png':
				$filetype = ".png";
				if (imagetypes() & IMG_PNG) return true; else return false; 
			break;
			case 'image/wbmp':
				$filetype = ".bmp";
				if (imagetypes() & IMG_WBMP) return true; else return false; 
			break;
			default:
				return false;
			break;
		}
	}

	public function _checkimageurl($URL, &$tmp_image, &$filetype) {
		$tmp_image = tempnam("/tmp", "UL_IMAGE");
		$IMG = @file_get_contents($URL);

	    if ($IMG === FALSE) {
	        return false;
	    } else {
	        file_put_contents($tmp_image, $IMG);
			$infoImage = getimagesize($tmp_image);
			switch ($infoImage['mime']) {
				case 'image/gif':
					$filetype = ".gif";
					if (imagetypes() & IMG_GIF) return true; else return false; 
				break;
				case 'image/jpeg':
					$filetype = ".jpg";
					if (imagetypes() & IMG_JPG) return true; else return false; 
				break;
				case 'image/pjpeg':
					$filetype = ".jpg";
					if (imagetypes() & IMG_JPG) return true; else return false; 
				break;
				case 'image/png':
					$filetype = ".png";
					if (imagetypes() & IMG_PNG) return true; else return false; 
				break;
				case 'image/wbmp':
					$filetype = ".bmp";
					if (imagetypes() & IMG_WBMP) return true; else return false; 
				break;
				default:
					return false;
				break;
			}
	    }
	}

	public function _checkfile($file, &$filetype, $only = []) {
		switch ($file->getMimeType()) {
			case 'application/pdf':
				$filetype = ".pdf";
			break;
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
				$filetype = ".docx";
			break;
			case 'application/msword':
				$filetype = ".doc";
			break;
			case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
				$filetype = ".xlsx";
			break;
			case 'application/vnd.ms-excel':
				$filetype = ".xls";
			break;
			case 'application/vnd.ms-powerpoint':
				$filetype = ".ppt";
			case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
				$filetype = ".pptx";
			break;
		}
		if($filetype) {
			if($only) {
				if(in_array($filetype, $only)) {
					return true;
				} else return false;
			} else return true;
		} else return false;
	}

	public function _filetofolder($tmpFile, $path, $fileName) {
		move_uploaded_file($tmpFile, $path.$fileName);
	}

	public function _imagetofolder($fileImage, $path, $fileName, $width=0, $height=0) {
		$infoImage = getimagesize($fileImage->GetPathName());
		switch ($fileImage->getMimeType()) {
			case 'image/gif':
				if (imagetypes() & IMG_GIF) $src = imageCreateFromGIF($fileImage->GetPathName());
				break;
			case 'image/jpeg':
				if (imagetypes() & IMG_JPG) $src = imageCreateFromJPEG($fileImage->GetPathName());
				break;
			case 'image/pjpeg':
				if (imagetypes() & IMG_JPG) $src = imageCreateFromJPEG($fileImage->GetPathName());
				break;
			case 'image/png':
				if (imagetypes() & IMG_PNG) $src = imageCreateFromPNG($fileImage->GetPathName());
				break;
			case 'image/wbmp':
				if (imagetypes() & IMG_WBMP) $src = imageCreateFromWBMP($fileImage->GetPathName());
				break;
		}
		
		$path .= $fileName;
		if($width!=0 && $height!=0) {
			$originalWidth	= $infoImage[0];
			$originalHeight	= $infoImage[1];
			
			$tmpWidth	= $width;
			$tmpHeight	= $height;
			
			$tmp = imagecreatetruecolor($tmpWidth, $tmpHeight);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tmpWidth, $tmpHeight, $originalWidth, $originalHeight);
			
			switch ($fileImage->getMimeType()) {
				case 'image/gif':
				case 'image/png':
						$image = imagecreatefrompng ( $fileImage->GetPathName() );
						imagealphablending($tmp , false);
						imagesavealpha($tmp , true);
						imagecopyresampled ( $tmp, $image, 0, 0, 0, 0, $tmpWidth, $tmpHeight, imagesx ( $image ), imagesy ( $image ) );
						$image = $tmp;
						imagealphablending($image , false);
						imagesavealpha($image , true);
						imagepng ( $image, $path );
						break;
				case 'image/jpeg': imagejpeg($tmp,$path,100); break;
				case 'image/pjpeg': imagejpeg($tmp,$path,100); break;
				case 'image/wbmp': imagewbmp($tmp,$path); break;
				default: imagejpeg($tmp,$path,100); break;
			}
		} else { move_uploaded_file($fileImage->GetPathName(), $path); }
	}

	public function _imagetofolderratio($fileImage, $path, $fileName, $width, $height) {
		$infoImage = getimagesize($fileImage->GetPathName());
		$originalWidth = $infoImage[0];
		$originalHeight = $infoImage[1];

		$xratio  = $width / $originalWidth;
		$yratio  = $height / $originalHeight;

		if( ($originalWidth <= $width) && ($originalHeight <= $height) ) {
			$tmpWidth = $originalWidth;
			$tmpHeight = $originalHeight;
		} elseif (($xratio * $originalHeight) < $height) {
			$tmpHeight = ceil($xratio * $originalHeight);
			$tmpWidth = $width;
		} else {
			$tmpWidth = ceil($yratio * $originalWidth);
			$tmpHeight = $height;
		}

		switch ($fileImage->getMimeType()) {
			case 'image/gif':
				if (imagetypes() & IMG_GIF) $src = imageCreateFromGIF($fileImage->GetPathName());
				break;
			case 'image/jpeg':
				if (imagetypes() & IMG_JPG) $src = imageCreateFromJPEG($fileImage->GetPathName());
				break;
			case 'image/pjpeg':
				if (imagetypes() & IMG_JPG) $src = imageCreateFromJPEG($fileImage->GetPathName());
				break;
			case 'image/png':
				if (imagetypes() & IMG_PNG) $src = imageCreateFromPNG($fileImage->GetPathName());
				break;
			case 'image/wbmp':
				if (imagetypes() & IMG_WBMP) $src = imageCreateFromWBMP($fileImage->GetPathName());
				break;
		}
		
		$path	.= $fileName;
		$tmp	= imagecreatetruecolor($tmpWidth, $tmpHeight);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tmpWidth, $tmpHeight, $originalWidth, $originalHeight);

		switch ($fileImage->getMimeType()) {
			case 'image/gif':
			case 'image/png':
					$image = imagecreatefrompng ( $fileImage->GetPathName() );
					imagealphablending($tmp , false);
					imagesavealpha($tmp , true);
					imagecopyresampled ( $tmp, $image, 0, 0, 0, 0, $tmpWidth, $tmpHeight, imagesx ( $image ), imagesy ( $image ) );
					$image = $tmp;
					imagealphablending($image , false);
					imagesavealpha($image , true);
					imagepng ( $image, $path );
					break;
			case 'image/jpeg': imagejpeg($tmp,$path,100); break;
			case 'image/pjpeg': imagejpeg($tmp,$path,100); break;
			case 'image/wbmp': imagewbmp($tmp,$path); break;
			default: imagejpeg($tmp,$path,100); break;
		}
	}

	public function _imageurltofolder($tmp_image, $path, $fileName, $width=0, $height=0) {
		$infoImage = getimagesize($tmp_image);
		switch ($infoImage['mime']) {
			case 'image/gif':
				if (imagetypes() & IMG_GIF) $src = imageCreateFromGIF($tmp_image);
				break;
			case 'image/jpeg':
				if (imagetypes() & IMG_JPG) $src = imageCreateFromJPEG($tmp_image);
				break;
			case 'image/pjpeg':
				if (imagetypes() & IMG_JPG) $src = imageCreateFromJPEG($tmp_image);
				break;
			case 'image/png':
				if (imagetypes() & IMG_PNG) $src = imageCreateFromPNG($tmp_image);
				break;
			case 'image/wbmp':
				if (imagetypes() & IMG_WBMP) $src = imageCreateFromWBMP($tmp_image);
				break;
		}
		
		$path .= $fileName;
		if($width!=0 && $height!=0) {
			$originalWidth	= $infoImage[0];
			$originalHeight	= $infoImage[1];
			
			$tmpWidth	= $width;
			$tmpHeight	= $height;
			
			$tmp = imagecreatetruecolor($tmpWidth, $tmpHeight);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tmpWidth, $tmpHeight, $originalWidth, $originalHeight);
			
			switch ($infoImage['mime']) {
				case 'image/gif':
				case 'image/png':
						$image = imagecreatefrompng ( $tmp_image );
						imagealphablending($tmp , false);
						imagesavealpha($tmp , true);
						imagecopyresampled ( $tmp, $image, 0, 0, 0, 0, $tmpWidth, $tmpHeight, imagesx ( $image ), imagesy ( $image ) );
						$image = $tmp;
						imagealphablending($image , false);
						imagesavealpha($image , true);
						imagepng ( $image, $path );
						break;
				case 'image/jpeg': imagejpeg($tmp,$path,100); break;
				case 'image/pjpeg': imagejpeg($tmp,$path,100); break;
				case 'image/wbmp': imagewbmp($tmp,$path); break;
				default: imagejpeg($tmp,$path,100); break;
			}
		} else { move_uploaded_file($tmp_image, $path); }
	}

	public function _imageurltofolderratio($tmp_image, $path, $fileName, $width, $height) {
		$infoImage = getimagesize($tmp_image);
		$originalWidth = $infoImage[0];
		$originalHeight = $infoImage[1];

		$xratio  = $width / $originalWidth;
		$yratio  = $height / $originalHeight;

		if( ($originalWidth <= $width) && ($originalHeight <= $height) ) {
			$tmpWidth = $originalWidth;
			$tmpHeight = $originalHeight;
		} elseif (($xratio * $originalHeight) < $height) {
			$tmpHeight = ceil($xratio * $originalHeight);
			$tmpWidth = $width;
		} else {
			$tmpWidth = ceil($yratio * $originalWidth);
			$tmpHeight = $height;
		}

		switch ($infoImage['mime']) {
			case 'image/gif':
				if (imagetypes() & IMG_GIF) $src = imageCreateFromGIF($tmp_image);
				break;
			case 'image/jpeg':
				if (imagetypes() & IMG_JPG) $src = imageCreateFromJPEG($tmp_image);
				break;
			case 'image/pjpeg':
				if (imagetypes() & IMG_JPG) $src = imageCreateFromJPEG($tmp_image);
				break;
			case 'image/png':
				if (imagetypes() & IMG_PNG) $src = imageCreateFromPNG($tmp_image);
				break;
			case 'image/wbmp':
				if (imagetypes() & IMG_WBMP) $src = imageCreateFromWBMP($tmp_image);
				break;
		}
		
		$path	.= $fileName;
		$tmp	= imagecreatetruecolor($tmpWidth, $tmpHeight);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tmpWidth, $tmpHeight, $originalWidth, $originalHeight);

		switch ($infoImage['mime']) {
			case 'image/gif':
			case 'image/png':
					$image = imagecreatefrompng ( $tmp_image );
					imagealphablending($tmp , false);
					imagesavealpha($tmp , true);
					imagecopyresampled ( $tmp, $image, 0, 0, 0, 0, $tmpWidth, $tmpHeight, imagesx ( $image ), imagesy ( $image ) );
					$image = $tmp;
					imagealphablending($image , false);
					imagesavealpha($image , true);
					imagepng ( $image, $path );
					break;
			case 'image/jpeg': imagejpeg($tmp,$path,100); break;
			case 'image/pjpeg': imagejpeg($tmp,$path,100); break;
			case 'image/wbmp': imagewbmp($tmp,$path); break;
			default: imagejpeg($tmp,$path,100); break;
		}
	}

	public function _numbertoroman($integer, $upcase = true) { 
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
		$return = ''; 
		while($integer > 0) {
			foreach($table as $rom=>$arb) {
				if($integer >= $arb) {
					$integer -= $arb;
					$return .= $rom;
					break;
				}
			}
		}

		return $return;
	}

	public function _excelnamefromnumber($num) {
	    $numeric = ($num - 1) % 26;
	    $letter = chr(65 + $numeric);
	    $num2 = intval(($num - 1) / 26);
	    if ($num2 > 0) {
	        return $this->_excelnamefromnumber($num2) . $letter;
	    } else {
	        return $letter;
	    }
	}

	public function _verifycaptcha($secretkey, $captcharesponse) {
		# Verify captcha
		$post_data = http_build_query(
		    array(
		        'secret' => $secretkey,
		        'response' => $captcharesponse,
		        'remoteip' => $this->_getvisitip()
		    )
		);
		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $post_data
		    )
		);
		$context  = stream_context_create($opts);
		$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
		$result = json_decode($response);

		if (!$result->success) {
		    return 'Please ensure that you are a human !';
		}

		return $result;
	}

	public function _trans($translocation, $transreplace = array()) {
		if (\Lang::has($translocation)) {
			return \Lang::get($translocation, $transreplace);
		} else {
			$explodetranslocation = explode('.', $translocation);
			return $this->aliasform[end($explodetranslocation)][0];
		}
	}

	public function _strposarr($haystack, $needle, $backtext = true) {
	    if(!is_array($needle)) $needle = array($needle);
	    foreach($needle as $what) {
	        if(($pos = strpos($haystack, $what))!==false)
	        	if($backtext) return $pos;
	        	else return $what;
	    }
	    return false;
	}

	public function _curljsonpost($url, $datapost, $error = false) {
		$header[] = 'Content-Type: application/json';
		$header[] = "Accept-Encoding: gzip, deflate";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

		if ($datapost) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $datapost);
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$rs = curl_exec($ch);

		if(empty($rs) && $error) {
			$this->_debugvar(['rs'=>$rs, 'curl_error'=>curl_error($ch)]);
			curl_close($ch);
			return false;
		}
		curl_close($ch);
		return $rs;
	}

	public function _curlpost($url, $datapost, $error = false) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		if ($datapost) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, urldecode(http_build_query($datapost)));
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$rs = curl_exec($ch);

		if(empty($rs) && $error) {
			$this->_debugvar(['rs'=>$rs, 'curl_error'=>curl_error($ch)]);
			curl_close($ch);
			return false;
		}
		curl_close($ch);
		return $rs;
	}

	public function _constructCart($Cart) {
		if(!$Cart) return '';

		$ArrayCart = [];
        $i = 0;
        $CountProduct = 0;
        $SubTotalTransaction = 0;
        $SubTotalTransactionUnshipping = 0;
        foreach ($Cart as $key1 => $val1) {
        	$SubTotalSeller = 0;
        	$SubTotalSellerUnshipping = 0;
            foreach ($val1 as $key2 => $val2) {
            	$SellerID = str_replace('SellerID-', '', $key2);

            	$this->_loaddbclass(['Seller']);

                $Seller = $this->Seller->leftjoin([
                    ['city as c', 'c.ID', '=', 'seller.PickupCityID'],
                    ['district as d', 'd.ID', '=', 'seller.PickupDistrictID'],
                ])->where([
                    ['seller.ID','=',$SellerID],
                    ['seller.IsActive', '=', 1],
                    ['seller.Status', '=', 0]
                ])->selectraw('
                    seller.*,
                    c.Name as CityName,
                    d.JNECode
                ')->first();

                $ArrayCart[$i] = [
                	'SellerID' => $SellerID,
                	'SellerName' => $Seller->FullName,
                	'SellerAddress' => $Seller->PickupAddress1,
                	'SellerCity' => $Seller->CityName,
                	'SellerZipCode' => $Seller->PickupZipcodeID,
                	'SellerPhone' => $Seller->PickupPhone,
                	'SellerLink' => $Seller->permalink,
                	'PickupDistrictID' => $Seller->PickupDistrictID,
                	'PickupJNECode' => $Seller->JNECode,
                	'SubTotalSeller' => '',
                	'SubTotalRealSeller' => 0,
                ];

                $j = 0;
                foreach ($val2 as $key3 => $val3) {
                	$ShippingID = str_replace('ShippingID-', '', $key3);

                	$this->_loaddbclass(['Shipping']);

	                $Shipping = $this->Shipping->where([
	                    ['ID','=',$ShippingID],
	                    ['IsActive', '=', 1],
	                    ['Status', '=', 0]
	                ])->first();

	                $ArrayCart[$i]['Shipping'][$j] = [
	                	'ShippingID' => $ShippingID,
	                	'ShippingName' => $Shipping->Name,
	                ];

	                $k = 0;
                    foreach ($val3 as $key4 => $val4) {
                		$ShippingPackageID = str_replace('ShippingPackageID-', '', $key4);

                		$ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k] = [
		                	'ShippingPackageID' => $ShippingPackageID,
		                ];

		                $l = 0;
                        foreach ($val4 as $key5 => $val5) {
                			$IDDistrict = str_replace('IDDistrict-', '', $key5);

                			$this->_loaddbclass(['District']);

			                $District = $this->District->where([
			                    ['ID','=',$IDDistrict],
			                    ['IsActive', '=', 1],
			                    ['Status', '=', 0]
			                ])->first();

			                $ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k]['District'][$l] = [
			                	'IDDistrict' => $IDDistrict,
			                	'DistrictJNECode' => $District->JNECode,
			                ];

			                $m = 0;
			                $tmpWeight = 0;
			                $SubTotalPrice = 0;
			                $SubTotalPriceUnshipping = 0;
                        	foreach ($val5 as $key6 => $val6) {
	                        	$ProductID = str_replace('ProductID-', '', $key6);

		                        $this->_loaddbclass(['Product']);

		                        $Product = $this->Product->leftjoin([
		                            ['brand as b', 'b.ID', '=', 'product.BrandID'],
		                        ])->where([
		                            ['product.ID','=',$ProductID],
		                            ['product.IsActive', '=', 1],
		                            ['product.Status', '=', 0]
		                        ])->selectraw('
		                            product.*,
		                            b.Name as BrandName
		                        ')->first();

		                        $ProductPrice = 0;
		                        if($Product->StatusSale == 1)
		                            $ProductPrice = $Product->SalePrice;
		                        else
		                            $ProductPrice = $Product->SellingPrice;

                                $Qty				= $val6[0];
                                $GroupSizeID		= $val6[1];
                                $SizeVariantID		= $val6[2];
                                $Notes				= $val6[3];
                                $IDCustomerAddress	= $val6[4];
                                $TextAddressInfo	= $val6[5];
                                $TextRecepientName	= $val6[6];
                                $TextRecepientPhone	= $val6[7];
                                $TextAddress		= $val6[8];
                                $IDProvince			= $val6[9];
                                $TextDistrictName	= $val6[10];
                                $IDDistrict			= $val6[11];
                                $TextCityName		= $val6[12];
                                $IDCity				= $val6[13];
                                $TextPostalCode		= $val6[14];

	                            $this->_loaddbclass(['Color', 'GroupSize', 'SizeVariant']);

	                            $Color = $this->Color->where([
	                                ['ID','=',$Product->ColorID],
	                                ['IsActive', '=', 1],
	                                ['Status', '=', 0]
	                            ])->first();

                                $GroupSize = $this->GroupSize->where([
                                    ['ID','=',$GroupSizeID],
                                    ['Status', '=', 0]
                                ])->first();

                                $GroupSizeName = '';
                                if($GroupSize) $GroupSizeName = $GroupSize->Name;

                                $SizeVariant = $this->SizeVariant->where([
                                    ['ID','=',$SizeVariantID],
                                    ['Status', '=', 0]
                                ])->first();

                                $Weight 					= $Product->Weight * $Qty;
                                $tmpWeight					+= $Weight;
                                $SubTotalPrice				+= $ProductPrice * $Qty;
                                $SubTotalPriceUnshipping	+= $ProductPrice * $Qty;
                                $ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k]['District'][$l]['Product'][$m] = [
                                    'ProductID'				=> $Product->ID,
                                    'ProductType'			=> $Product->TypeProduct,
                                    'ProductBrand'			=> $Product->BrandName,
                                    'ProductName'			=> $Product->Name,
                                    'ProductPrice'			=> $this->_formatamount($ProductPrice, 'Rupiah', 'IDR '),
                                    'ProductRealPrice'		=> $ProductPrice,
                                    'ProductColorID'		=> $Product->ColorID,
                                    'ProductColor'			=> $Color->Name,
                                    'ProductGroupSizeID'	=> $GroupSizeID,
                                    'ProductGrouSize'		=> $GroupSizeName,
                                    'ProductSizeVariantID'	=> $SizeVariantID,
                                    'ProductSize'			=> $SizeVariant->Name,
                                    'ProductQty'			=> $Qty,
                                    'ProductWeight'			=> $Weight,
                                    'ProductImage'			=> $Product->Image1,
                                    'ProductNotes'			=> $Notes,
                                    'IDCustomerAddress'		=> $IDCustomerAddress,
                                    'TextAddressInfo'		=> $TextAddressInfo,
                                    'TextRecepientName'		=> $TextRecepientName,
                                    'TextRecepientPhone'	=> $TextRecepientPhone,
                                    'TextAddress'			=> $TextAddress,
                                    'IDProvince'			=> $IDProvince,
                                    'TextDistrictName'		=> $TextDistrictName,
                                    'IDDistrict'			=> $IDDistrict,
                                    'TextCityName'			=> $TextCityName,
                                    'IDCity'				=> $IDCity,
                                    'TextPostalCode'		=> $TextPostalCode,
                                    'ShippingPrice'			=> 0,
                                    'ShippingRealPrice'		=> '',
                                    'ShippingPackage'		=> '',
                                    'SubTotalPrice'			=> 0,
                                    'SubTotalRealPrice'		=> '',
                                    'ProductLink'			=> $key1.'-'.$SellerID.'-'.$ShippingID.'-'.$ShippingPackageID.'-'.$IDDistrict.'-'.$ProductID.'-'.$GroupSizeID.'-'.$SizeVariantID
                                ];

                                $CountProduct++;
                                $m++;
	                        }

	                        $this->_loadfcclass([ 'JNE' ]);

                            $from = substr($Seller->JNECode, 0, 4).'0000';
                            $thru = $District->JNECode;

                            if(!$this->inv['config']['JNETest']) {
                            	$data = json_decode($this->JNE->_getprice($from, $thru, $tmpWeight), True);	
                            } else {
                            	$data = '';
	                            if(!$data) {
	                            	$data = json_decode('{"price":[{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR","service_code":"JTR","price":"40000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR250","service_code":"JTR250","price":"1100000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR<150","service_code":"JTR<150","price":"500000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR>250","service_code":"JTR>250","price":"1500000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"OKE","service_code":"OKE15","price":"16000","etd_from":"2","etd_thru":"3","times":"D"},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"REG","service_code":"REG15","price":"18000","etd_from":"1","etd_thru":"2","times":"D"},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"SPS","service_code":"SPS15","price":"443000","etd_from":"0","etd_thru":"0","times":"D"},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"YES","service_code":"YES15","price":"28000","etd_from":"1","etd_thru":"1","times":"D"}]}', True);
	                            }
                            }
                            
                            $data = $data['price'];
                            $keyPackage = array_search($ShippingPackageID, array_column($data, 'service_code'));
                            
                            $SubTotalPrice += $data[$keyPackage]['price'];

                            $ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k]['District'][$l]['Product'][$m-1]['ShippingPackage'] = $data[$keyPackage]['service_display'];
                            $ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k]['District'][$l]['Product'][$m-1]['ShippingPrice'] = $this->_formatamount($data[$keyPackage]['price'], 'Rupiah', 'IDR ');
                            $ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k]['District'][$l]['Product'][$m-1]['ShippingRealPrice']	= $data[$keyPackage]['price'];
                            $ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k]['District'][$l]['Product'][$m-1]['SubTotalPrice']	= $this->_formatamount($SubTotalPrice, 'Rupiah', 'IDR ');
                            $ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k]['District'][$l]['Product'][$m-1]['SubTotalRealPrice']	= $SubTotalPrice;
                            $ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k]['District'][$l]['Product'][$m-1]['SubTotalPriceUnshipping']	= $this->_formatamount($SubTotalPriceUnshipping, 'Rupiah', 'IDR ');
                            $ArrayCart[$i]['Shipping'][$j]['ShippingPackage'][$k]['District'][$l]['Product'][$m-1]['SubTotalRealPriceUnshipping']	= $SubTotalPriceUnshipping;

                            $SubTotalSeller += $SubTotalPrice;
                            $SubTotalSellerUnshipping += $SubTotalPriceUnshipping;

	                        $l++;
                        }
                        $k++;
                    }
                    $j++;
                }
                $i++;
            }
            $ArrayCart[$i-1]['SubTotalSeller'] = $this->_formatamount($SubTotalSeller, 'Rupiah', 'IDR ');
            $ArrayCart[$i-1]['SubTotalRealSeller'] = $SubTotalSeller;
            $ArrayCart[$i-1]['SubTotalSellerUnshipping'] = $this->_formatamount($SubTotalSellerUnshipping, 'Rupiah', 'IDR ');
            $ArrayCart[$i-1]['SubTotalRealSellerUnshipping'] = $SubTotalSellerUnshipping;

            $SubTotalTransaction += $SubTotalSeller;
            $SubTotalTransactionUnshipping += $SubTotalSellerUnshipping;
        }
        $ArrayCart['CountProduct'] = $CountProduct;
        $ArrayCart['SubTotalTransaction'] = $this->_formatamount($SubTotalTransaction, 'Rupiah', 'IDR ');
        $ArrayCart['SubTotalRealTransaction'] = $SubTotalTransaction;
        $ArrayCart['GrandTotalTransaction'] = $this->_formatamount($SubTotalTransaction, 'Rupiah', 'IDR ');
        $ArrayCart['GrandTotalRealTransaction'] = $SubTotalTransaction;
        $ArrayCart['SubTotalTransactionUnshipping'] = $this->_formatamount($SubTotalTransactionUnshipping, 'Rupiah', 'IDR ');
        $ArrayCart['SubTotalRealTransactionUnshipping'] = $SubTotalTransactionUnshipping;
        $ArrayCart['GrandTotalTransactionUnshipping'] = $this->_formatamount($SubTotalTransactionUnshipping, 'Rupiah', 'IDR ');
        $ArrayCart['GrandTotalRealTransactionUnshipping'] = $SubTotalTransactionUnshipping;

        return $ArrayCart;
	}
	
	public function _constructViewCart($Cart) {
		if(!$Cart) return '';

		$ArrayViewCart = [];
        $TotalPrice = 0;
        $i = 0;

        foreach ($Cart as $key1 => $val1) {
            foreach ($val1 as $key2 => $val2) {
            	$SellerID = str_replace('SellerID-', '', $key2);
                foreach ($val2 as $key3 => $val3) {
                	$ShippingID = str_replace('ShippingID-', '', $key3);
                    foreach ($val3 as $key4 => $val4) {
                		$ShippingPackageID = str_replace('ShippingPackageID-', '', $key4);
                        foreach ($val4 as $key5 => $val5) {
                			$IDDistrict = str_replace('IDDistrict-', '', $key5);
                        	foreach ($val5 as $key6 => $val6) {
	                        	$ProductID = str_replace('ProductID-', '', $key6);

		                        $this->_loaddbclass(['Product']);

		                        $Product = $this->Product->leftjoin([
		                            ['brand as b', 'b.ID', '=', 'product.BrandID'],
		                        ])->where([
		                            ['product.ID','=',$ProductID],
		                            ['product.IsActive', '=', 1],
		                            ['product.Status', '=', 0]
		                        ])->selectraw('
		                            product.*,
		                            b.Name as BrandName
		                        ')->first();

		                        $ProductPrice = 0;
		                        if($Product->StatusSale == 1)
		                            $ProductPrice = $Product->SalePrice;
		                        else
		                            $ProductPrice = $Product->SellingPrice;

		                        $Qty 			= $val6[0];
		                        $GroupSizeID	= $val6[1];
                                $SizeVariantID			= $val6[2];

	                            $this->_loaddbclass(['Color', 'SizeVariant']);

	                            $Color = $this->Color->where([
	                                ['ID','=',$Product->ColorID],
	                                ['IsActive', '=', 1],
	                                ['Status', '=', 0]
	                            ])->first();

                                $SizeVariant = $this->SizeVariant->where([
                                    ['ID','=',$SizeVariantID],
                                    ['Status', '=', 0]
                                ])->first();

                                $ArrayViewCart[$i] = [
                                    'ProductBrand'		=> $Product->BrandName,
                                    'ProductName'		=> $Product->Name,
                                    'ProductPrice'		=> $this->_formatamount($ProductPrice, 'Rupiah', 'IDR '),
                                    'ProductRealPrice'	=> $ProductPrice,
                                    'ProductColor'		=> $Color->Name,
                                    'ProductSize'		=> $SizeVariant->Name,
                                    'ProductQty'		=> $Qty,
                                    'ProductImage'		=> $Product->Image1,
                                    'ProductLink'		=> $key1.'-'.$SellerID.'-'.$ShippingID.'-'.$ShippingPackageID.'-'.$IDDistrict.'-'.$ProductID.'-'.$GroupSizeID.'-'.$SizeVariantID
                                ];

                                $TotalPrice += $ProductPrice * $Qty;

                                $i++;
	                        }
                        }
                    }
                }
            }
        }
        $ArrayViewCart['TotalPrice'] = $this->_formatamount($TotalPrice, 'Rupiah', 'IDR ');

        return $ArrayViewCart;
	}
}