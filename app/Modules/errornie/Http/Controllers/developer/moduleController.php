<?php

namespace App\Modules\errornie\Http\Controllers\developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class moduleController extends Controller
{
	// Set header active
	public $header = [
		'menus'     => true, // True is show menu and false is not show.
		'check'		=> true, // Active all header function. If all true and this check false then header not show.
		'search'	=> false,
		'addnew'	=> true,
		'refresh'	=> true,
	];

	// Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc
	public $alias = [
		'name'		=> 'name',
	];
	
	// For show name and set width in page HTML
	// If you using alias name with "date", in search you can get two input date
	public $aliasform = [
		'titlepage'	=> ['Module', true, true], // Set Title Page (if DB value from database), Title Form (true or false), Breadcrumb (true or false)
		'name'		=> array('Module Name', true),
	];
	
	private $access = [
		'module' => ['errornie', 'developer', 'module'],
		'function' => ['index', 'addnew', 'priority', 'delete']
	];

    public function index()
    {
    	$url = $this->_accessdata($this, __FUNCTION__, $this->access);
    	if($url) return $this->_redirect($url);

    	return $this->views();
    }
    
    public function addnew()
    {
    	$url = $this->_accessdata($this, __FUNCTION__, $this->access);
    	if($url) return $this->_redirect($url);

    	$idheadmenu = $headmenu = $errorheadmenu = $independent = $errorindependent = $name = $errorname = $icon = $desc_en = $errordesc_en = $desc_id = $errordesc_id = '';

		$request = \Request::instance()->request->all();

        if (isset($request['addnew'])) {
        	$this->_loaddbclass([ 'MasterMenu' ]);

        	$headmenu = $request['headmenu'];
			if($this->_checkpermalink($headmenu)) { $this->_redirect('404'); }
			if($headmenu) {
				$tmpheadmenu = explode('-', $headmenu);
				$headmenu = $tmpheadmenu[0];
				$idheadmenu = $tmpheadmenu[1];
			}

			$name = $request['name'];
			if(empty($name)) { $errorname = 'Silahkan masukkan Menu Name !'; }
			else if($this->_numberscharactersspace($name)) { $errorname = 'Format Menu Name diperbolehkan a-Z, spasi !'; }
			
			if($idheadmenu)
				$MasterMenu = $this->MasterMenu->where([['idMMenu','=',$idheadmenu],['permalink','=',$this->_permalink($name, '')]]);
			else $MasterMenu = $this->MasterMenu->where([['permalink','=',$this->_permalink($name, '')]]);
			$MasterMenu = $MasterMenu->first();
			
			if($MasterMenu) {
				if(isset($request['addnew']) && ($MasterMenu->permalink == $this->_permalink($name, '')) && !$MasterMenu->idMParrent) {
					if(!$errorname) {
						$errorname = 'Menu Name is already used !!!';
					}
				}
			}
			
			if(isset($request['independent'])) { $independent = $request['independent']; }
			else { $independent = ''; }

			if($independent) {
				if($headmenu) {
					$MasterMenu = $this->MasterMenu->where([['permalink','=',$headmenu]])->first();
					if($MasterMenu) {
						if(!$MasterMenu->idMParrent) {
							// $errorindependent = 'Independent Menu hanya dapat di buat pada menu level pertama !';
						}
					}
				} else {
					$errorindependent = 'Independent Menu hanya dapat di buat pada menu level pertama !';
				}
			}
			
			$icon = $request['icon'];
			$desc_en = $request['desc_en'];
			if(empty($desc_en)) { $errordesc_en = 'Silahkan masukkan Description EN !'; }
			$desc_id = $request['desc_id'];

			if(!$this->inv['messageerror'] && !$errorheadmenu && !$errorname && !$errorindependent && !$errordesc_en && !$errordesc_id) {
				if(isset($request['addnew'])) {
					$permalink	= $this->_permalink($name, '');
					$arrtemp	= array();
					if($headmenu) {
						$headmenurecord = $this->MasterMenu->where([
							['idMMenu','=',$idheadmenu],['permalink','=',$headmenu]
						])->first();
						$idMParrent		= $headmenurecord->idMMenu;
						
						if($headmenurecord->idMParrent == 0) {
							if($independent) {
								$route 	= $headmenurecord->permalink.'/';
								$menu 	= 4;
							} else {
								$route	= '';
								$menu 	= 2;
							}
						} else {
							$getfirstlevel = $this->MasterMenu->where([
								['idMMenu','=',$headmenurecord->idMParrent]
							])->first();

							$route	= $getfirstlevel->permalink.'/'.$headmenurecord->permalink.'/';
							$menu 	= 3;
						}
					} else {
						$idMParrent	= 0;
						$route 		= '';
						$menu 		= 1;
					}
					
					$parrent = $this->MasterMenu->where([['idMParrent','=',$idMParrent]])->orderBy('priority','DESC')->first();

					if($parrent) $priority = $parrent->priority;
					else $priority = 0;
					
					$array	= array(
						'idMParrent'	=> $idMParrent,
						'priority'		=> $priority + 1,
						'name'			=> $name,
						'permalink'		=> $permalink,
						'menu'			=> $menu,
						'route'			=> $route,
						'icon'			=> $icon,
						'desc_en'		=> $desc_en,
						'desc_id'		=> $desc_id,
					);

					$this->MasterMenu->creates($array);

					\Session::put('messagesuccess', "Saving $name Completed !");
				}

				return $this->_redirect(get_class());
			}
        }

    	$this->inv['headmenu']			= $headmenu;
    	$this->inv['errorheadmenu']		= $errorheadmenu;
    	$this->inv['independent']		= $independent;
    	$this->inv['errorindependent']	= $errorindependent;
    	$this->inv['name']				= $name;
    	$this->inv['errorname']			= $errorname;
    	$this->inv['desc_en']			= $desc_en;
    	$this->inv['errordesc_en']		= $errordesc_en;
    	$this->inv['desc_id']			= $desc_id;
    	$this->inv['errordesc_id']		= $errordesc_id;
    	$this->inv['icon']				= $icon;
    	
    	$listmenu = $this->MasterMenu->getmenu(['idMParrent','=',0])->get()->toArray();
    	$this->inv['result']['data'] = $this->MasterMenu->getmenuextends([$listmenu]);
    	
		$ListIcon = new \App\Library\ListIcon();
		$this->inv['arrsocialmediaicon'] = $ListIcon->_geticon();

        return $this->_showview(["errornie.module.modulenew"]);
    }

    public function priority()
    {
    	$url = $this->_accessdata($this, __FUNCTION__, $this->access);
    	if($url) return $this->_redirect($url);
    	
    	if(isset($this->inv['getset'])) {
    		list($function, $id) = explode('.', $this->inv['getset']);

    		$this->_loaddbclass([ 'MasterMenu' ]);

    		$MasterMenuold = $this->MasterMenu->where([['idMMenu','=',$id]])->first();

    		if($MasterMenuold) {
    			$idMParrent = $MasterMenuold->idMParrent;
    			$priorityold = $MasterMenuold->priority;

    			if($function=='up') {
					$MasterMenunew = $this->MasterMenu->where([
						['idMParrent','=',$idMParrent],
						['priority','<',$priorityold]
					])->orderBy('priority', 'DESC');
				} else {
					$MasterMenunew = $this->MasterMenu->where([
						['idMParrent','=',$idMParrent],
						['priority','>',$priorityold]
					])->orderBy('priority', 'ASC');
				}

				$MasterMenunew = $MasterMenunew->first();

    			if($MasterMenunew) {
    				$prioritynew = $MasterMenunew->priority;

    				$array = array( 'priority' => $priorityold );
					$MasterMenunew->update($array);
					$array = array( 'priority' => $prioritynew );
					$MasterMenuold->update($array);
	    		}
    		}
    	}

    	return $this->views();
    }
    
    private function loopdelete($MasterMenu, &$idMMenu) {
    	foreach ($MasterMenu as $key => $value) {
    		$idMMenu[] = $value['idMMenu'];
			$this->inv['messagesuccess'] .= "Delete ".$value['name']." Completed !<br/>";
			if(is_array($value['_child']) && count($value['_child']) > 0) {
    			$this->loopdelete($value['_child'], $idMMenu);
    		}
		}
    }

    public function delete()
    {
    	$url = $this->_accessdata($this, __FUNCTION__, $this->access);
    	if($url) return $this->_redirect($url);

    	if(isset($this->inv['getid'])) {
    		$this->_loaddbclass([ 'MasterMenu', 'MasterUserAccess', 'MasterMenuAccess' ]);

    		$MasterMenu = $this->MasterMenu->getmodel()->with(['_child' => function($query) {
				$query->with(['_child']);
			}])->where('idMMenu','=',$this->inv['getid']);

    		if($MasterMenu->get()) {
    			$idMMenu = [];
    			$this->loopdelete($MasterMenu->get()->toArray(), $idMMenu);
    			$this->inv['messagesuccess'] = rtrim($this->inv['messagesuccess'], '<br/>');
    			
    			$MasterMenu = $this->MasterMenu->getmodel()->whereIn('idMMenu',$idMMenu);
    			if($MasterMenu) $MasterMenu->delete();

    			$MasterMenuAccess = $this->MasterMenuAccess->getmodel()->whereIn('idMMenu',$idMMenu);
    			if($MasterMenuAccess) $MasterMenuAccess->delete();

    			$MasterUserAccess = $this->MasterUserAccess->getmodel()->whereIn('idMMenu',$idMMenu);
    			if($MasterUserAccess) $MasterUserAccess->delete();
    		}
    	}

    	return $this->views();
    }

    private function views($views = ["errornie.module.modulelist"]) {
    	$this->_loaddbclass([ 'MasterMenu' ]);
    	
    	$listmenu = $this->MasterMenu->getmenu(['idMParrent','=',0])->get()->toArray();
    	$this->inv['result']['data'] = $this->MasterMenu->getmenuextends([$listmenu]);
    	
    	if(!count($this->inv['result']['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');

    	// $this->_debugvar($this->inv['result']['data']);

    	return $this->_showview($views);
    }
}