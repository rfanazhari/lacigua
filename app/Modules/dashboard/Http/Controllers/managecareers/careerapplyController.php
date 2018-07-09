<?php

namespace App\Modules\dashboard\Http\Controllers\managecareers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class careerapplyController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => true,
        'refresh'   => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'CareerApplyID',
        'CareerID' => 'CareerID',
        'CareerName' => 'CareerName',
        'Note' => 'Note',
        'CVFile' => 'CVFile',
        'PortfolioFile' => 'PortfolioFile',
        'CreatedDate' => 'CreatedDate',
        'idfunction' => 'ID',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'CareerApplyID' => ['Career Apply ID'],
        'CareerID' => ['Career ID'],
        'CareerName' => ['Position', true],
        'Note' => ['Note', true],
        'CVFile' => ['CV File', true],
        'PortfolioFile' => ['Portfolio File', true],
        'CreatedDate' => ['Created Date', true],
    ];

    var $objectkey = '', $CareerApplyID = '', $errorCareerApplyID = '', $CareerID = '', $errorCareerID = '', $Note = '', $errorNote = '', $CVFile = '', $errorCVFile = '', $PortfolioFile = '', $errorPortfolioFile = '', $CreatedDate = '', $errorCreatedDate = '';    
    var $pathfile = '/resources/assets/backend/file/cvportfolio/';

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->views();
    }
    
    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'CareerApply' ]);

        $result = $this->CareerApply->leftjoin([
            ['career as c', 'c.ID', '=', 'career_apply.CareerID']
        ])->selectraw('
            c.Position as CareerName,
            career_apply.*
        ')->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $result['data'][$i][$this->inv['flip']['CreatedDate']] = $this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['CreatedDate']], 'red');
                $result['data'][$i][$this->inv['flip']['CVFile']] = '<a href="'.$this->inv['basesite'].str_replace('/resources/', '', $this->pathfile).$result['data'][$i][$this->inv['flip']['CVFile']].'" class="badge badge-roundless badge-success">'.$result['data'][$i][$this->inv['flip']['CVFile']].'</a>';
                $result['data'][$i][$this->inv['flip']['PortfolioFile']] = '<a href="'.$this->inv['basesite'].str_replace('/resources/', '', $this->pathfile).$result['data'][$i][$this->inv['flip']['PortfolioFile']].'" class="badge badge-roundless badge-warning">'.$result['data'][$i][$this->inv['flip']['PortfolioFile']].'</a>';
            }
            $this->_setdatapaginate($result);
        }
    
        return $this->_showview($views);
    }
}