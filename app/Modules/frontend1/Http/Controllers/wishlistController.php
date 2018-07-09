<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class wishlistController extends Controller
{
	// $this->_debugvar();
	public function ajaxpost()
    {
    	if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'RemoveWishlist' :
                	$ID = $request['ID'];

            		if(!$ID) {
            			$data['error'][] = 'Please contact admin';
                    } else {
                    	$this->_loaddbclass(['CustomerProductWishlist']);

                    	$CustomerProductWishlist = $this->CustomerProductWishlist->where([['ID', '=', $ID],['StatusWishlist', '=', 1]])->first();
                    	if($CustomerProductWishlist) {
                    		$CustomerProductWishlist->update(['StatusWishlist' => 0]);
							$return = 'OK';
							$data = $ID;
                    	} else {
                        	$data['error'][] = 'Please contact admin';
                        }
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
            }
        }
    }

	public function index()
	{
		$this->_geturi();

		if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

		$this->_loaddbclass([ 'Customer' ]);

		$CustomerData = $this->Customer->where([['ID','=',\Session::get('customerdata')['ccustomerid']]])->first();
		$this->inv['CustomerData'] = $CustomerData;
		
		$LastLogin = date("l, d F Y | h:m:s", strtotime($CustomerData->LastLogin));
		$this->inv['LastLogin'] = $LastLogin;

		$this->_loaddbclass([ 'CustomerProductWishlist' ]);

		$CustomerProductWishlist = $this->CustomerProductWishlist->leftjoin([
			['product as p', 'p.ID', '=', 'customer_product_wishlist.ProductID'],
			['brand as b', 'b.ID', '=', 'p.BrandID'],
            ['size_variant as sv', 'sv.ID', '=', 'customer_product_wishlist.SizeVariantID'],
            ['size_link as sl', 'sl.SizeVariantID', '=', 'customer_product_wishlist.SizeVariantID'],
		])->leftJoin('product_detail_size_variant as pds', function($join) { 
            $join->on('pds.ProductID', '=', 'customer_product_wishlist.ProductID')
            	->on('pds.GroupSizeID', '=', 'p.GroupSizeID')
            	->on('pds.SizeVariantID', '=', 'sl.SizeVariantIDLink'); 
        })->selectraw('
            b.Name as BrandName,
            sv.Name as SizeName,
            pds.Qty as ProductQty,
            p.*,
            customer_product_wishlist.*
        ')->where([['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],['StatusWishlist', '=', 1]])->get();
		$this->inv['CustomerProductWishlist'] = $CustomerProductWishlist;

        $this->_loaddbclass([ 'Product' ]);

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
            // ['b.Mode', '=', 0],
            ['sr.IsActive', '=', 1],
            ['sr.Status', '=', 0],
            ['sr.SellerFetured', '=', 1],
            ['pdzv.ProductID', '!=', ''],
            ['pdzv.Status', '=', 0],
        ])->groupBy('pl.ProductLinkGroup')->selectraw('product.*')->limit(5)->get();
        $this->inv['ArrayProduct'] = $ArrayProduct;

		return $this->_showviewfront(['wishlist']);
	}
}