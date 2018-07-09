<?php

namespace App\Modules\dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class dashboardController extends Controller
{
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage' => ['DB', false, true], // Set Title Page (if DB value from database), Title Form (true or false), Breadcrumb (true or false)
    ];
    
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
    ];
    
    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);
        
        // $this->_debugvar($this->inv);
        
        return $this->_showview(["defaultpage"]);
    }
}