<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class defaultController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => false, // True is show menu and false is not show.
        'check'     => false, // Active all header function. If all true and this check false then header not show.
        'search'    => false,
        'addnew'    => false,
        'refresh'   => false,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc
    public $alias = [];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['Default Page', false, true], // Set Title Page (if DB value from database), Title Form (true or false), Breadcrumb (true or false)
    ];
    
	private $access = [
		'module' => [''],
		'function' => ['index', 'ajaxpost']
	];

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__, $this->access);
        if($url) return $this->_redirect($url);

        return $this->views();
    }
    
    private function views($views = ["default"]) {
        $this->_loaddbclass([ 'MasterMenu' ]);
        
        $listmenu = $this->MasterMenu->getmenu(['idMParrent','=',0])->get()->toArray();
        $this->inv['result']['data'] = $this->MasterMenu->getmenuextends([$listmenu]);
        
        if(!count($this->inv['result']['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');

        // $this->_debugvar($this->inv['result']['data']);

        return $this->_showview($views);
    }
}