<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class careersController extends Controller
{
	public function index()
	{
		$this->_geturi();

		$this->_loaddbclass([ 'CareerDivision' ]);

        $ArrCareerDivision = $this->CareerDivision->leftjoin([
        	['career as c', 'c.CareerDivisionID', '=', 'career_division.ID']
        ])->selectraw('
        	career_division.*
        ')->where([
        	['c.IsActive','=',1],
        	['c.Status','=',0],
        	['career_division.IsActive','=',1],
        	['career_division.Status','=',0],
        	['c.ClosedDate','>=',new \Datetime('now')],
       	])->groupBy('career_division.ID')->get();
       	$this->inv['ArrCareerDivision'] = $ArrCareerDivision;

       	$ArrCareer = [];
       	if(isset($this->inv['getdetail'])) {
       		$this->_loaddbclass([ 'Career' ]);

	        $ArrCareer = $this->Career->leftjoin([
	        	['career_division as cd', 'career.CareerDivisionID', '=', 'cd.ID']
	        ])->selectraw('
	        	career.*
	        ')->where([
	        	['cd.permalink','=',$this->inv['getdetail']],
	        	['career.IsActive','=',1],
	        	['career.Status','=',0],
	        	['career.ClosedDate','>=',new \Datetime('now')]
	       	])->get();
       	}
   		$this->inv['ArrCareer'] = $ArrCareer;

		return $this->_showviewfront(['careers']);
	}
}