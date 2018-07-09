<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class artistController extends Controller
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
                case 'setfavorite' :
                	$ID = $request['ID'];
                	if(!\Session::get('customerdata')) {
                		die(json_encode(['response' => 'Silahkan Daftar atau Login terlebih dahulu !'], JSON_FORCE_OBJECT));
                	} else {
                		$this->_loaddbclass(['Brand','CustomerFavoriteBrand']);

                		$Brand = $this->Brand->where([['permalink', '=', $ID]])->first();

                		$CustomerFavoriteBrand = $this->CustomerFavoriteBrand->where([
                			['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
                			['BrandID', '=', $Brand->ID],
                		])->first();

                		$return = '';
                		if($CustomerFavoriteBrand) {
                			if($CustomerFavoriteBrand->StatusFavorite == 1) {
								$CustomerFavoriteBrand->update([
									'StatusFavorite' => 0,
									'CreatedDate' => new \DateTime("now")
	                			]);
	                			$return = 'CANCEL';
                			} else {
                				$CustomerFavoriteBrand->update([
									'StatusFavorite' => 1,
									'CreatedDate' => new \DateTime("now")
	                			]);
	                			$return = 'OK';
                			}
                		} else {
                			$this->CustomerFavoriteBrand->creates([
                				'CustomerID' => \Session::get('customerdata')['ccustomerid'],
								'BrandID' => $Brand->ID,
								'StatusFavorite' => 1,
								'CreatedDate' => new \DateTime("now")
                			]);
                			$return = 'OK';
                		}

                		die(json_encode(['response' => $return], JSON_FORCE_OBJECT));
                	}
                break;
            }
        }
    }

	public function parseextlink($extlink, $get, $replacer) {
		$ArraySort = ['','','main','category','style','colour','price','view','page'];
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
			if($get == 'main' && $replacer) {
				unset($ArrayExtlinkNew[array_search('category', $ArraySort)]);
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

		if(isset($this->inv['getid'])) {
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

			$this->extlink = 'artist/id_'.$this->inv['getid'];
			if(isset($this->inv['getmain'])) $this->extlink .= '/main_'.$this->inv['getmain'];
			if(isset($this->inv['getcategory'])) $this->extlink .= $getcategory;
			if(isset($this->inv['getstyle'])) $this->extlink .= $getstyle;
			if(isset($this->inv['getcolour'])) $this->extlink .= $getcolour;
			if(isset($this->inv['getprice'])) $this->extlink .= '/price_'.$this->inv['getprice'];
			if(isset($this->inv['getview'])) $this->extlink .= '/view_'.$this->inv['getview'];
			if(isset($this->inv['getpage'])) $this->extlink .= '/page_'.$this->inv['getpage'];
		} else return $this->_redirect('404');
	}

	public function index()
	{
		$this->extlink();
        $this->inv['extlink'] = $this->extlink;

		if(!isset($this->inv['getprice'])) $this->inv['getprice'] = '0-10000';
		if(!isset($this->inv['getview'])) $this->inv['getview'] = 16;
		if(!isset($this->inv['getpage'])) $this->inv['getpage'] = 1;

		$this->_loaddbclass([ 'Brand','CustomerFavoriteBrand','BrandSocialMedia','Category','Style','Color','Product' ]);

		$Brand = $this->Brand->where([['IsActive', '=', 1],['Status', '=', 0],['permalink', '=', $this->inv['getid']]])->first();
		if($Brand) {
			$this->inv['Brand'] = $Brand;

			$CustomerFavoriteBrand = $this->CustomerFavoriteBrand->where([
    			['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
    			['BrandID', '=', $Brand->ID],
    		])->first();
			$this->inv['CustomerFavoriteBrand'] = $CustomerFavoriteBrand;

			$BrandSocialMedia = $this->BrandSocialMedia->leftjoin([
				['icon_social_media as icm', 'icm.ID', '=', 'brand_social_media.IconSocialMediaID']
	        ])->selectraw('
	            icm.ID as IconSocialMediaID,
	            icm.Image as IconSocialMediaImage,
	            icm.ImageHover as IconSocialMediaImageHover,
	            brand_social_media.*
	        ')->where([['brand_social_media.IsActive','=',1],['brand_social_media.Status','=',0]])->get()->toArray();
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

			$ArrayShow = [ 16,32,48 ];
			$this->inv['ArrayShow'] = $ArrayShow;

			$ArrayProductNew = $this->Product->leftjoin([
				['brand as b', 'b.ID', '=', 'product.BrandID'],
				['seller as sr', 'sr.ID', '=', 'b.SellerID'],
				['product_detail_style as pds', 'pds.ProductID', '=', 'product.ID'],
				['style as s', 's.ID', '=', 'pds.StyleID'],
				['colors as c', 'c.ID', '=', 'product.ColorID'],
				['product_detail_size_variant as pdzv', 'pdzv.ProductID', '=', 'product.ID'],
				['product_link as pl', 'pl.ProductID', '=', 'product.ID'],
			])->where([
				['product.BrandID', '=', $Brand->ID],
				['product.IsActive', '=', 1],
				['product.Status', '=', 0],
				['b.IsActive', '=', 1],
				['b.Status', '=', 0],
				['sr.IsActive', '=', 1],
				['sr.Status', '=', 0],
				['pdzv.ProductID', '!=', ''],
				['pdzv.Status', '=', 0],
			]);
			$ArrayProductNew = $ArrayProductNew->where('StatusNew', '=', 1);
			$ArrayProductNew = $ArrayProductNew->groupBy('product.ID')->selectraw('product.*');
			$ArrayProductNew = $ArrayProductNew->take(4)->get()->toArray();
			$this->inv['ArrayProductNew'] = $ArrayProductNew;

			$ArrayProduct = $this->Product->leftjoin([
				['brand as b', 'b.ID', '=', 'product.BrandID'],
				['seller as sr', 'sr.ID', '=', 'b.SellerID'],
				['product_detail_style as pds', 'pds.ProductID', '=', 'product.ID'],
				['style as s', 's.ID', '=', 'pds.StyleID'],
				['colors as c', 'c.ID', '=', 'product.ColorID'],
				['product_detail_size_variant as pdzv', 'pdzv.ProductID', '=', 'product.ID'],
				['product_link as pl', 'pl.ProductID', '=', 'product.ID'],
			])->where([
				['product.BrandID', '=', $Brand->ID],
				['product.IsActive', '=', 1],
				['product.Status', '=', 0],
				['b.IsActive', '=', 1],
				['b.Status', '=', 0],
				['sr.IsActive', '=', 1],
				['sr.Status', '=', 0],
				['pdzv.ProductID', '!=', ''],
				['pdzv.Status', '=', 0],
			]);

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
			$ArrayProduct = $ArrayProduct->groupBy('pl.ProductLinkGroup')->selectraw('product.*');
			// $this->_debugvar($ArrayProduct->toSql());
			$ArrayProduct = $ArrayProduct->paginate($this->inv['getview'])->toArray();

			if(!count($ArrayProduct['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
	        else {
	            $this->_setdatapaginate($ArrayProduct, true);
	        }

			$this->inv['controller'] = 'artist';
			return $this->_showviewfront(['unfeature']);
		}
	}
}