<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class saleController extends Controller
{
	var $exlink = '';

	public function ajaxpost()
    {
        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'pricerange' :
                	$extlink = $request['extlink'];
                	$pricerange = str_replace(' ', '', $request['pricerange']);
                	if($pricerange == '0-10000') $pricerange = '';
	                return $this->parseextlink($extlink, 'price', $pricerange);
                break;
            }
        }
    }

	public function parseextlink($extlink, $get, $replacer) {
		$ArraySort = ['','main','category','labels','style','colour','price','sort','view','page'];
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
			if($get == 'main' && $replacer) {
				unset($ArrayExtlinkNew[array_search('category', $ArraySort)]);
				unset($ArrayExtlinkNew[array_search('labels', $ArraySort)]);
			}
			if($get == 'sort' && $replacer == 'popularity') {
				unset($ArrayExtlinkNew[array_search('sort', $ArraySort)]);
			}
			if($get == 'view' && $replacer == '16') {
				unset($ArrayExtlinkNew[array_search('view', $ArraySort)]);
			}
		} else if($get && $replacer) {
			if($get == 'category' || $get == 'labels' || $get == 'style' || $get == 'colour') {
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

		$getcategory = '';
		if(isset($this->inv['getcategory'])) {
			$getcategory .= '/category_[';
			foreach ($this->inv['getcategory'] as $key => $val) {
				$getcategory .= $val['category'];
				if(isset($val['subcategory'])) {
					$getcategory .= '[';
					foreach ($val['subcategory'] as $vals) {
						$getcategory .= $vals.',';
					}
					$getcategory = rtrim($getcategory, ',');
					$getcategory .= '].';
				} else $getcategory .= '.';
			}
			$getcategory = rtrim($getcategory, '.');
			$getcategory .= ']';
		}

		$getlabels = '';
		if(isset($this->inv['getlabels'])) {
			$getlabels .= '/labels_[';
			foreach ($this->inv['getlabels'] as $key => $val) {
				$getlabels .= $val['labels'].'.';
			}
			$getlabels = rtrim($getlabels, '.');
			$getlabels .= ']';
		}

		$getstyle = '';
		if(isset($this->inv['getstyle'])) {
			$getstyle .= '/style_[';
			foreach ($this->inv['getstyle'] as $key => $val) {
				$getstyle .= $val['style'].'.';
			}
			$getstyle = rtrim($getstyle, '.');
			$getstyle .= ']';
		}

		$getcolour = '';
		if(isset($this->inv['getcolour'])) {
			$getcolour .= '/colour_[';
			foreach ($this->inv['getcolour'] as $key => $val) {
				$getcolour .= $val['colour'].'.';
			}
			$getcolour = rtrim($getcolour, '.');
			$getcolour .= ']';
		}

		$this->extlink = 'sale';
		if(isset($this->inv['getmain'])) $this->extlink .= '/main_'.$this->inv['getmain'];
		if(isset($this->inv['getcategory'])) $this->extlink .= $getcategory;
		if(isset($this->inv['getlabels'])) $this->extlink .= $getlabels;
		if(isset($this->inv['getstyle'])) $this->extlink .= $getstyle;
		if(isset($this->inv['getcolour'])) $this->extlink .= $getcolour;
		if(isset($this->inv['getprice'])) $this->extlink .= '/price_'.$this->inv['getprice'];
		if(isset($this->inv['getsort'])) $this->extlink .= '/sort_'.$this->inv['getsort'];
		if(isset($this->inv['getview'])) $this->extlink .= '/view_'.$this->inv['getview'];
		if(isset($this->inv['getpage'])) $this->extlink .= '/page_'.$this->inv['getpage'];
	}

	public function index()
	{
		$this->extlink();
        $this->inv['extlink'] = $this->extlink;

		$sortalias = [
			'popularity' => ['Popularity','DESC'],
			'just-in' => ['ID','DESC'],
			'low-high' => ['SalePrice','ASC'],
			'high-low' => ['SalePrice','DESC'],
		];

		if(!isset($this->inv['getprice'])) $this->inv['getprice'] = '0-10000';
		if(!isset($this->inv['getsort'])) $this->inv['getsort'] = 'popularity';
		if(!isset($this->inv['getview'])) $this->inv['getview'] = 16;
		if(!isset($this->inv['getpage'])) $this->inv['getpage'] = 1;

		$this->_loaddbclass([ 'SaleBanner','Category','Brand','Style','Color','Product' ]);

		$SaleBanner = $this->SaleBanner->where([['IsActive', '=', 1],['Status', '=', 0]])->get()->toArray();
		$this->inv['SaleBanner'] = $SaleBanner;

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

		$MainCategory = "";
		if(isset($this->inv['getmain'])) $MainCategory = '"'.strtoupper($this->inv['getmain']).'"';

		$ArrayBrand = $this->Brand->where([['IsActive', '=', 1],['Status', '=', 0]]);
		$ArrayBrand = $ArrayBrand->where('MainCategory', 'like', '%'.$MainCategory.'%');
		$ArrayBrand = $ArrayBrand->get();
		$this->inv['ArrayBrand'] = $ArrayBrand;

		$ArrayStyle = $this->Style->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Priority')->get();
		$this->inv['ArrayStyle'] = $ArrayStyle;

		$ArrayColor = $this->Color->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('ID')->get();
		$this->inv['ArrayColor'] = $ArrayColor;

		$ArraySort = [
			'popularity' => 'POPULARITY',
			'just-in' => 'JUST IN',
			'low-high' => 'LOW - HIGH',
			'high-low' => 'HIGH - LOW',
		];
		$this->inv['ArraySort'] = $ArraySort;

		$ArrayShow = [ 16,32,48 ];
		$this->inv['ArrayShow'] = $ArrayShow;

		$ArrayProduct = $this->Product->leftjoin([
			['brand as b', 'b.ID', '=', 'product.BrandID'],
			['product_detail_style as pds', 'pds.ID', '=', 'product.ID'],
			['style as s', 'pds.StyleID', '=', 's.ID'],
			['colors as c', 'c.ID', '=', 'product.ColorID'],
			['product_link as pl', 'pl.ProductID', '=', 'product.ID'],
		])->where([['StatusSale', '=', 1],['product.IsActive', '=', 1],['product.Status', '=', 0]]);

		if(isset($this->inv['getmain']))
			$ArrayProduct = $ArrayProduct->where('ModelType', '=', strtoupper($this->inv['getmain']));
		if(isset($this->inv['getcategory'])) {
			$category = array_column($this->inv['getcategory'], 'category');
			$subcategory = array_column($this->inv['getcategory'], 'subcategory');
			$ArrayProduct = $ArrayProduct->whereIn('CategoryID', $category);
			if($subcategory) {
				$subcategory = array_values(array_unique(call_user_func_array('array_merge', $subcategory)));
				$ArrayProduct = $ArrayProduct->whereIn('SubCategoryID', $subcategory);
			}
		}
		if(isset($this->inv['getlabels']))
			$ArrayProduct = $ArrayProduct->whereIn('b.permalink', $this->inv['getlabels']);
		if(isset($this->inv['getstyle']))
			$ArrayProduct = $ArrayProduct->whereIn('s.permalink', $this->inv['getstyle']);
		if(isset($this->inv['getcolour']))
			$ArrayProduct = $ArrayProduct->where('c.permalink', '=', $this->inv['getcolour']);
		if(isset($this->inv['getprice'])) {
			$ArrayProduct = $ArrayProduct->where(function($query) {
				$tmpgetprice = explode('-', $this->inv['getprice']);
				$query->where('SalePrice', '>=', $tmpgetprice[0] * 1000)->where('SalePrice', '<=', $tmpgetprice[1] * 1000);
			});
		}
		if(isset($this->inv['getsort']))
			$ArrayProduct = $ArrayProduct->orderBy($sortalias[$this->inv['getsort']][0], $sortalias[$this->inv['getsort']][1]);
		$ArrayProduct = $ArrayProduct->groupBy('pl.ProductLinkGroup')->select(['product.*']);
		$ArrayProduct = $ArrayProduct->paginate($this->inv['getview'])->toArray();

		if(!count($ArrayProduct['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            $this->_setdatapaginate($ArrayProduct, true);
        }

		return $this->_showviewfront(['sale']);
	}
}