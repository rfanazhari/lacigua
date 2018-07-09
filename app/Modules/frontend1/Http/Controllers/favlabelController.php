<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class favlabelController extends Controller
{
	// $this->_debugvar();
	public function ajaxpost()
    {
    	if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'RemoveFavLabel' :
                	$ID = $request['ID'];

            		if(!$ID) {
            			$data['error'][] = 'Please contact admin';
                    } else {
                    	$this->_loaddbclass(['CustomerFavoriteBrand']);

                    	$CustomerFavoriteBrand = $this->CustomerFavoriteBrand->where([['ID', '=', $ID],['StatusFavorite', '=', 1]])->first();
                    	if($CustomerFavoriteBrand) {
                    		$CustomerFavoriteBrand->update(['StatusFavorite' => 0]);
							$return = 'OK';
							$data = $ID;
                    	} else {
                        	$data['error'][] = 'Please contact admin';
                        }
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'AddFavLabel' :
                	$ID = $request['ID'];
                	if(!\Session::get('customerdata')) {
                		die(json_encode(['response' => 'Silahkan Daftar atau Login terlebih dahulu !'], JSON_FORCE_OBJECT));
                	} else {
                		$this->_loaddbclass(['CustomerFavoriteBrand']);

                		$CustomerFavoriteBrand = $this->CustomerFavoriteBrand->where([
                			['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],
                			['BrandID', '=', $ID],
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
								'BrandID' => $ID,
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

	public function index()
	{
		$this->_geturi();

		if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

		$this->_loaddbclass([ 'Customer' ]);

		$CustomerData = $this->Customer->where([['ID','=',\Session::get('customerdata')['ccustomerid']]])->first();
		$this->inv['CustomerData'] = $CustomerData;
		
		$LastLogin = date("l, d F Y | h:m:s", strtotime($CustomerData->LastLogin));
		$this->inv['LastLogin'] = $LastLogin;

		$this->_loaddbclass([ 'CustomerFavoriteBrand' ]);

		$CustomerFavoriteBrand = $this->CustomerFavoriteBrand->leftjoin([
			['brand as b', 'b.ID', '=', 'customer_favorite_brand.BrandID'],
		])->selectraw('
            b.Name as BrandName,
            b.Icon as BrandIcon,
            b.Mode as BrandMode,
            b.permalink as BrandPermalink,
            customer_favorite_brand.*
        ')->where([['CustomerID', '=', \Session::get('customerdata')['ccustomerid']],['StatusFavorite', '=', 1]])->get();
		$this->inv['CustomerFavoriteBrand'] = $CustomerFavoriteBrand;

		$arraymode = [
            0 => 'feature',
            1 => 'artist',
            2 => 'indie'
        ];
        $this->inv['arraymode'] = $arraymode;

		$this->_loaddbclass([ 'Brand' ]);

        $FeaturedBrand = $this->Brand->where([['Mode', '=', 0],['IsActive', '=', 1],['Status', '=', 0]])->get();
		$this->inv['FeaturedBrand'] = $FeaturedBrand;

		return $this->_showviewfront(['favlabel']);
	}
}