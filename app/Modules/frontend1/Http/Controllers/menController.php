<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class menController extends Controller
{
	var $ModelType = 'MEN';
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
		$ArraySort = ['','','select','category','labels','style','colour','price','sort','view','page'];
		$ArrayExtlink = explode('/', $extlink);
		$ArrayExtlinkNew[0] = $ArrayExtlink[0];
		$ArrayExtlinkNew[1] = $ArrayExtlink[1];
		if(count($ArrayExtlink) > 2) {
			$i = 0;
			foreach ($ArrayExtlink as $obj) {
				if($i > 1) {
					$this->_extendsparseextlink($ArraySort, $ArrayExtlink, $ArrayExtlinkNew, $get, $replacer, $obj);
				}
				$i++;
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

		$this->extlink = strtolower($this->ModelType).'/detail';
		if(isset($this->inv['getselect'])) $this->extlink .= '/select_'.$this->inv['getselect'];
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
		$this->_geturi();

		$this->_loaddbclass([ 'Category', 'MainCategoryBanner' ]);

		$MainCategoryBanner = [];
		foreach($this->MainCategoryBanner->where([['IsActive', '=', 1],['Status', '=', 0],['ModelType', '=', $this->ModelType]])->get() as $key => $val) {
			$MainCategoryBanner[$val->BannerType][] = [
				'BrandID' => $val->BrandID,
				'Banner' => $val->Banner,
				'BannerURL' => $val->BannerURL,
				'Title' => $val->Title,
				'Note' => $val->Note,
				'BgColorNote' => $val->BgColorNote,
				'BannerStart' => $val->BannerStart,
				'BannerEnd' => $val->BannerEnd,
				'ShowTime' => $val->ShowTime,
			];
		}

		$this->inv['MainCategoryBanner'] = $MainCategoryBanner;

		$Category = [];
		$i = 0;
		foreach($this->Category->getmodel()->with(['_child' => function($query) {
			$query->where([['IsActive', '=', 1],['Status', '=', 0],['ShowOnHeader', '=', 1]])->orderBy('Priority');
		}])->where([['IsActive', '=', 1],['Status', '=', 0],['ShowOnHeader', '=', 1],['ModelType', '=', $this->ModelType]])
		->orderBy('Favorite')->take(4)->get()->toArray() as $key => $val) {
			$Category[$i] = [
				'ID' => $val['ID'],
				'Name' => $val['Name'],
				'CategoryImage' => $val['CategoryImage'],
				'permalink' => $val['permalink'],
			];
			if(is_array($val['_child']) && count($val['_child'])) {
				foreach($val['_child'] as $keys => $vals) {
					$Category[$i]['_child'][] = [
						'ID' => $vals['ID'],
						'Name' => $vals['Name'],
						'permalink' => $vals['permalink'],
					];
				}
			}
			$i++;
		}

		$this->inv['Category'] = $Category;
		$this->inv['ModelType'] = $this->ModelType;
		
		return $this->_showviewfront(['maincategory']);
	}

	public function detail()
	{
		$this->extlink();
        $this->inv['extlink'] = $this->extlink;

		$sortalias = [
			'popularity' => ['Popularity','DESC'],
			'just-in' => ['ID','DESC'],
			'low-high' => ['SellingPrice','ASC'],
			'high-low' => ['SellingPrice','DESC'],
			'sale' => ['StatusSale','DESC'],
			'most-wanted' => ['MostWanted','DESC'],
		];

		if(!isset($this->inv['getprice'])) $this->inv['getprice'] = '0-10000';
		if(!isset($this->inv['getsort'])) $this->inv['getsort'] = 'popularity';
		if(!isset($this->inv['getview'])) $this->inv['getview'] = 16;
		if(!isset($this->inv['getpage'])) $this->inv['getpage'] = 1;

		$this->_loaddbclass([ 'Setting', 'Category', 'Brand', 'Style', 'Color', 'Product' ]);

		$Setting = $this->Setting->where([['ID', '=', 1]])->first();
		$this->inv['Setting'] = $Setting;
		
		$ArrayCategorySubHeader = $this->Category->getmodel()->with(['_child' => function($query) {
			$query->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Priority');
		}])->where([['ModelType', '=', $this->ModelType],['ShowOnSubHeader', '=', 1],['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Priority')->get();
		$this->inv['ArrayCategorySubHeader'] = $ArrayCategorySubHeader;

		$ArrayCategory = $this->Category->getmodel()->with(['_child' => function($query) {
			$query->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Priority');
		}])->where([['IsActive', '=', 1],['Status', '=', 0],['ModelType', '=', $this->ModelType]])->orderBy('Priority')->get();
		$this->inv['ArrayCategory'] = $this->_arrayuniquemultidimentional($this->_categoryfilterrecursive($ArrayCategory->toArray()));

		if(isset($this->inv['getfind'])) {
			$tmpfind = array_column($this->inv['getfind'], 'find');
			array_walk($tmpfind, function (&$v) { $v = strtolower($this->ModelType).'-'.$v; });
			$Category = $this->Category->getmodel()->whereIn('permalink', $tmpfind)->orderBy('Priority')->get();
			$this->inv['Category'] = $Category;
		}

		$ArrayBrand = $this->Brand->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('Name')->get();
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
			'sale' => 'SALE',
		];
		$this->inv['ArraySort'] = $ArraySort;

		$ArrayShow = [ 16,32,48 ];
		$this->inv['ArrayShow'] = $ArrayShow;

		$ArrayProduct = $this->Product->leftjoin([
			['brand as b', 'b.ID', '=', 'product.BrandID'],
			['seller as sr', 'sr.ID', '=', 'b.SellerID'],
			['product_detail_style as pds', 'pds.ProductID', '=', 'product.ID'],
			['style as s', 's.ID', '=', 'pds.StyleID'],
			['colors as c', 'c.ID', '=', 'product.ColorID'],
			['product_detail_size_variant as pdzv', 'pdzv.ProductID', '=', 'product.ID'],
			['product_link as pl', 'pl.ProductID', '=', 'product.ID'],
		])->where([
			['product.IsActive', '=', 1],
			['product.Status', '=', 0],
			['b.IsActive', '=', 1],
			['b.Status', '=', 0],
			['sr.IsActive', '=', 1],
			['sr.Status', '=', 0],
			['pdzv.ProductID', '!=', ''],
			['pdzv.Status', '=', 0],
		]);

		$ArrayProduct = $ArrayProduct->where('ModelType', '=', $this->ModelType);

		if(isset($this->inv['getselect']))
			$ArrayProduct = $ArrayProduct->where('StatusNew', '=', 1);
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
			$ArrayProduct = $ArrayProduct->whereIn('c.permalink', $this->inv['getcolour']);
		if(isset($this->inv['getprice'])) {
			$ArrayProduct = $ArrayProduct->where(function($query) {
				$query->where(function($query) {
					$tmpgetprice = explode('-', $this->inv['getprice']);
					$query->where('SellingPrice', '>=', $tmpgetprice[0] * 1000)->where('SellingPrice', '<=', $tmpgetprice[1] * 1000);
				})->orwhere(function($query) {
					$tmpgetprice = explode('-', $this->inv['getprice']);
					$query->where('SalePrice', '>=', $tmpgetprice[0] * 1000)->where('SalePrice', '<=', $tmpgetprice[1] * 1000);
				});
			});
		}
		if(isset($this->inv['getsort']))
			$ArrayProduct = $ArrayProduct->orderBy($sortalias[$this->inv['getsort']][0], $sortalias[$this->inv['getsort']][1]);
		$ArrayProduct = $ArrayProduct->groupBy('pl.ProductLinkGroup')->selectraw('product.*');
		// $this->_debugvar($ArrayProduct->toSql());
		$ArrayProduct = $ArrayProduct->paginate($this->inv['getview'])->toArray();

		if(!count($ArrayProduct['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            $this->_setdatapaginate($ArrayProduct, true);
        }

		return $this->_showviewfront(['catalog']);
	}
}