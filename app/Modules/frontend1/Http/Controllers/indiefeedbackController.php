<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class indiefeedbackController extends Controller
{
	public function index()
	{
		$this->_geturi();

		if(isset($this->inv['getid'])) {
			$this->_loaddbclass([ 'Brand','BrandSocialMedia','Category','Style','Color' ]);

			$Brand = $this->Brand->where([['IsActive', '=', 1],['Status', '=', 0],['permalink', '=', $this->inv['getid']]])->first();
			if($Brand) {
				$this->inv['Brand'] = $Brand;

				$BrandSocialMedia = $this->BrandSocialMedia->where([['IsActive', '=', 1],['Status', '=', 0],['BrandID', '=', $Brand->ID]])->get();
				$this->inv['BrandSocialMedia'] = $BrandSocialMedia;

				$ArrayFindCategory = [
					['IsActive', '=', 1],
					['Status', '=', 0]
				];

				if(isset($this->inv['getmain']))
					$ArrayFindCategory = array_merge($ArrayFindCategory, ['ModelType' => strtoupper($this->inv['getmain'])]);
				
				$ArrayCategory = $this->Category->getmodel()->with(['_child' => function($query) {
					$query->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Priority');
				}])->where($ArrayFindCategory)->orderByRaw('case ModelType
					when "WOMEN" then 1
					when "MEN" then 2
					when "KIDS" then 3
				end')->orderBy('Priority')->get();
				$this->inv['ArrayCategory'] = $this->_arrayuniquemultidimentional($this->_categoryfilterrecursive($ArrayCategory->toArray()));

				$ArrayStyle = $this->Style->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Priority')->get();
				$this->inv['ArrayStyle'] = $ArrayStyle;

				$ArrayColor = $this->Color->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('ID')->get();
				$this->inv['ArrayColor'] = $ArrayColor;

				$this->inv['controller'] = 'indie';
				return $this->_showviewfront(['unfeaturefeedback']);
			}
			
		}

		return $this->_redirect('404');
	}
}