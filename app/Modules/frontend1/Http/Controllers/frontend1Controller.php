<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class frontend1Controller extends Controller
{
	public function index()
	{
		$this->_geturi();
		
		$this->_loaddbclass(['SlidingBanner','Brand','Style','Product']);

		$SlidingBanner = $this->SlidingBanner->where([
			['IsActive', '=', 1],
			['Status', '=', 0],
		])->where(function($query) {
        	$query->where(function($query) {
        		$query->whereraw('BannerEnd >= NOW()');
            })->orwhere(function($query) {
            	$query->whereraw('BannerStart = "0000-00-00 00:00:00"')
            	->orwhereraw('BannerEnd = "0000-00-00 00:00:00"');
            });
        });
        $SlidingBanner = $SlidingBanner->get()->toArray();
		$this->inv['SlidingBanner'] = $SlidingBanner;
		
		$arrBrand = $this->Brand->where([['ShowOnHeader', '=', 1],['IsActive', '=', 1],['Status', '=', 0]])->get()->toArray();

		$arrFeatured = array_values(array_filter($arrBrand, function ($val, $key) { return $val['Mode'] == 0; }, ARRAY_FILTER_USE_BOTH));
		$this->inv['arrFeatured'] = $arrFeatured;

		$arrArtist = array_values(array_filter($arrBrand, function ($val, $key) { return $val['Mode'] == 1; }, ARRAY_FILTER_USE_BOTH));
		$this->inv['arrArtist'] = $arrArtist;

		$arrIndie = array_values(array_filter($arrBrand, function ($val, $key) { return $val['Mode'] == 2; }, ARRAY_FILTER_USE_BOTH));
		$this->inv['arrIndie'] = $arrIndie;
		
		$arrStyle = $this->Style->where([['ShowOnHeader', '=', 1],['IsActive', '=', 1],['Status', '=', 0]])->get()->toArray();
		$this->inv['arrStyle'] = $arrStyle;
		
		$arrProductNew = $this->Product->leftjoin([
			['product_detail_size_variant as pdzv', 'pdzv.ProductID', '=', 'product.ID']
		])->where([['StatusNew', '=', 1],['IsActive', '=', 1],['product.Status', '=', 0],['pdzv.Status', '=', 0],['pdzv.ProductID', '!=', ''],['pdzv.Status', '=', 0]])->groupBy('product.ID')->take(5)->get();
		$this->inv['arrProductNew'] = $arrProductNew;

		$arrProductMost = $this->Product->leftjoin([
			['product_detail_size_variant as pdzv', 'pdzv.ProductID', '=', 'product.ID']
		])->where([['IsActive', '=', 1],['product.Status', '=', 0],['pdzv.Status', '=', 0],['pdzv.ProductID', '!=', ''],['pdzv.Status', '=', 0]])->groupBy('product.ID')->orderBy('Popularity')->take(5)->get();
		$this->inv['arrProductMost'] = $arrProductMost;

		$arrProductBack = $this->Product->leftjoin([
			['product_detail_size_variant as pdzv', 'pdzv.ProductID', '=', 'product.ID']
		])->where([['IsActive', '=', 1],['product.Status', '=', 0],['pdzv.Status', '=', 0],['pdzv.ProductID', '!=', ''],['pdzv.UpdatedDate', '!=', ''],['pdzv.Status', '=', 0]])->groupBy('product.ID')->take(5)->get();
		$this->inv['arrProductBack'] = $arrProductBack;

		return $this->_showviewfront(['home']);
	}
}