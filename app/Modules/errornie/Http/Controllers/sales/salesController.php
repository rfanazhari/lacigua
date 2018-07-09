<?php

namespace App\Modules\errornie\Http\Controllers\sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class salesController extends Controller
{
	// Set header active
	public $header = [
		'menus'     => true, // True is show menu and false is not show.
		'check'		=> true, // Active all header function. If all true and this check false then header not show.
		'search'	=> true,
		'addnew'	=> false,
		'refresh'	=> true,
	];

	// Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc
	public $alias = [
		'dateLog'		=> 'logdate',
		'namaGroup'		=> 'groupname',
		'namaUser'		=> 'vusername',
		'pageLog'		=> 'logpage',
		'actionLog'		=> 'logaction',
		'descLog'		=> 'logdesc',
		'idfunction'	=> 'idUserLog',
	];
	
	// For show name and set width in page HTML
	// If you using alias name with "date", in search you can get two input date
	public $aliasform = [
		'titlepage'	=> ['Sales', true, true], // Set Title Page (if DB value from database), Title Form (true or false), Breadcrumb (true or false)
		'logdate'	=> ['Date LOG', true, 'width:190px;'],
		'groupname'	=> ['Group Name', true, 'width:140px;'],
		'vusername'	=> ['Username', true, 'width:120px;'],
		'logpage'	=> ['Page LOG', true, 'width:120px;'],
		'logaction'	=> ['Action LOG', true, 'width:120px;'],
		'logdesc'	=> ['Description LOG', true],
	];
	
	private $access = [
		'module' => ['errornie', 'sales', 'sales'],
		'function' => ['index', 'addnew', 'delete']
	];

    public function index()
    {
    	$url = $this->_accessdata($this, __FUNCTION__, $this->access);
    	if($url) return $this->_redirect($url);

    	return $this->views();
    }

    public function delete()
    {
    	$url = $this->_accessdata($this, __FUNCTION__, $this->access);
    	if($url) return $this->_redirect($url);

    	if(isset($this->inv['delete']) && count($this->inv['delete'])) {
			if($this->alias['idfunction']) {
				$field = $this->alias['idfunction'];
			} else {
				$field = 'permalink';
			}

			$this->_loaddbclass([ 'MasterUserLogBackup' ]);

			foreach($this->inv['delete'] as $val) {
				$MasterUserLogBackup = $this->MasterUserLogBackup->where([[$field,'=',$val,]])->first();
				if($MasterUserLogBackup) {
					$logdate			= $this->inv['flip']['logdate'];
					$date				= $this->_dateTimeForHTML($MasterUserLogBackup->$logdate, 'red');
					$MasterUserLogBackup->delete();
					if(end($this->inv['delete']) != $val) $br = "<br/>";
					else $br = "";
					$this->inv['messagesuccess'] .= "Delete $date Completed !$br";
				}
			}
		}

    	return $this->views();
    }

    private function views($views = ["defaultview"]) {
    	$this->_loaddbclass([ 'MasterUserLogBackup' ]);

    	$result = $this->MasterUserLogBackup->getmodel()->orderBy($this->inv['flip'][$this->inv['getorder']],$this->inv['getsort']);

    	if(isset($this->inv['getsearchby'])) {
    		$this->_dbquerysearch($result, $this->inv['flip']);
    	}
    	
    	$result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

    	if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
		else {
			for($i=0; $i<count($result['data']);$i++) {
				$result['data'][$i][$this->inv['flip']['logdate']] = $this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['logdate']], 'red');
			}
			$this->_setdatapaginate($result);
		}

		// $this->_debugvar($this->inv);
		return $this->_showview($views);
    }
}