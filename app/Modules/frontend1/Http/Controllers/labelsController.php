<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class labelsController extends Controller
{
	var $exlink = '';

	public function parseextlink($extlink, $get, $replacer) {
		$ArraySort = ['','select','filter','main','style','sort','view','page'];
		$ArrayExtlink = explode('/', $extlink);
		$ArrayExtlinkNew[0] = $ArrayExtlink[0];
		if(count($ArrayExtlink) > 1) {
			$i = 0;
			foreach ($ArrayExtlink as $obj) {
				if($i > 0) {
					$this->_extendsparseextlink($ArraySort, $ArrayExtlink, $ArrayExtlinkNew, $get, $replacer, $obj);
				}
				$i++;
			}
			if($get == 'sort' && $replacer == 'just-in') {
				unset($ArrayExtlinkNew[array_search('sort', $ArraySort)]);
			}
			if($get == 'view' && $replacer == '16') {
				unset($ArrayExtlinkNew[array_search('view', $ArraySort)]);
			}
		} else if($get && $replacer) {
			if($get == 'category' || $get == 'labels' || $get == 'style') {
				$ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_['.$replacer.']';
			} else {
				$ArrayExtlinkNew[array_search($get, $ArraySort)] = $get.'_'.$replacer;
			}
		}

		ksort($ArrayExtlinkNew);
		$ArrayExtlinkNew = array_values($ArrayExtlinkNew);

		return implode('/', $ArrayExtlinkNew);
	}

	private function extlink() {
		$this->_geturi();

		$getstyle = '';
		if(isset($this->inv['getstyle'])) {
			$getstyle .= '/style_[';
			foreach ($this->inv['getstyle'] as $key => $val) {
				$getstyle .= $val['style'].'.';
			}
			$getstyle = rtrim($getstyle, '.');
			$getstyle .= ']';
		}

		$this->extlink = 'labels';
		if(isset($this->inv['getselect'])) $this->extlink .= '/select_'.$this->inv['getselect'];
		if(isset($this->inv['getfilter'])) $this->extlink .= '/filter_'.$this->inv['getfilter'];
		if(isset($this->inv['getmain'])) $this->extlink .= '/main_'.$this->inv['getmain'];
		if(isset($this->inv['getstyle'])) $this->extlink .= $getstyle;
		if(isset($this->inv['getsort'])) $this->extlink .= '/sort_'.$this->inv['getsort'];
		if(isset($this->inv['getview'])) $this->extlink .= '/view_'.$this->inv['getview'];
		if(isset($this->inv['getpage'])) $this->extlink .= '/page_'.$this->inv['getpage'];
	}

	public function index()
	{
		$this->extlink();
        $this->inv['extlink'] = $this->extlink;

		$selectalias = [
			'feature' => 0,
			'artist' => 1,
			'indie' => 2,
		];

		$sortalias = [
			'just-in' => ['brand.ID','DESC'],
			'mosty-favorite' => ['Favorite','DESC'],
			'a-z' => ['Name','ASC'],
			'z-a' => ['Name','DESC'],
		];

		if(!isset($this->inv['getview'])) $this->inv['getview'] = 16;
		if(!isset($this->inv['getsort'])) $this->inv['getsort'] = 'just-in';
		if(!isset($this->inv['getpage'])) $this->inv['getpage'] = 1;

		$this->_loaddbclass([ 'Setting','Brand','Style' ]);

		$Setting = $this->Setting->where([['ID', '=', 1]])->first();
		$this->inv['Setting'] = $Setting;
		
		$this->_dbsetpage($this->inv['getpage']);

		$MainCategory = "";
		if(isset($this->inv['getmain'])) $MainCategory = '"'.strtoupper($this->inv['getmain']).'"';
		
		$ArrayBrand = $this->Brand->leftjoin([
			['brand_detail_style as bds', 'bds.BrandID', '=', 'brand.ID'],
			['style as s', 'bds.StyleID', '=', 's.ID']
		])->where([['brand.IsActive', '=', 1],['brand.Status', '=', 0]]);
		$ArrayBrand = $ArrayBrand->where('MainCategory', 'like', '%'.$MainCategory.'%');
		if(isset($this->inv['getselect']))
			$ArrayBrand = $ArrayBrand->where('Mode', '=', $selectalias[$this->inv['getselect']]);
		if(isset($this->inv['getstyle']))
			$ArrayBrand = $ArrayBrand->whereIn('s.permalink', $this->inv['getstyle']);
		$ArrayBrand = $ArrayBrand->orderBy($sortalias[$this->inv['getsort']][0], $sortalias[$this->inv['getsort']][1]);
		$ArrayBrand = $ArrayBrand->groupBy('brand.ID')->select(['brand.*']);
		$ArrayBrand = $ArrayBrand->paginate($this->inv['getview'])->toArray();

		if(!count($ArrayBrand['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            $this->_setdatapaginate($ArrayBrand, true);
        }

		$ArrayStyle = $this->Style->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Priority')->get();
		$this->inv['ArrayStyle'] = $ArrayStyle;

		$ArraySort = [
			'just-in' => 'JUST IN',
			'mosty-favorite' => 'MOSTY FAVORITE',
			'a-z' => 'A - Z',
			'z-a' => 'Z - A',
		];
		$this->inv['ArraySort'] = $ArraySort;

		$ArrayShow = [ 16,32,48 ];
		$this->inv['ArrayShow'] = $ArrayShow;

		return $this->_showviewfront(['labels']);
	}
}