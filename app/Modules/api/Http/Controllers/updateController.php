<?php

namespace App\Modules\api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class updateController extends Controller
{
    // $this->_debugvar();
    public function index()
    {
        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'DeliveryTransaction' :
                    $ID = $request['ID'];

            		if(!$ID) {
            			$data['error'][] = 'Please contact admin';
                    } else {
                    	$this->_loaddbclass(['OrderTransactionSeller','OrderTransaction','OrderTransactionDetail']);

                    	$OrderTransactionSeller = $this->OrderTransactionSeller->where([['TransactionSellerCode', '=', $ID],['StatusShipment', '=', 2]])->first();
                    	if($OrderTransactionSeller) {
                    		$UpdatedDate = new \DateTime('now');
                    		$OrderTransactionSeller->update([
                    			'StatusShipment' => 3,
                    			'UpdatedDate' => $UpdatedDate,
                    			'UpdatedBy' => 0
                    		]);

                    		$OrderTransactionDetail = $this->OrderTransactionDetail->leftjoin([
	                            ['product as p', 'p.ID', '=', 'order_transaction_detail.ProductID'],
	                            ['brand as b', 'b.ID', '=', 'p.BrandID'],
	                        ])->selectraw('
	                            p.NameShow as ProductName,
	                            p.Image1 as ProductImage,
	                            b.Name as BrandName,
	                            order_transaction_detail.*
	                        ')->where([
	                            ['order_transaction_detail.TransactionCode', '=', $OrderTransactionSeller->TransactionCode],
	                            ['order_transaction_detail.SellerID', '=', $OrderTransactionSeller->SellerID],
	                            ['order_transaction_detail.ShippingID', '=', $OrderTransactionSeller->ShippingID],
	                            ['order_transaction_detail.ShippingPackageID', '=', $OrderTransactionSeller->ShippingPackageID],
	                            ['order_transaction_detail.IDDistrict', '=', $OrderTransactionSeller->IDDistrict],
	                        ])->get();

	                        if($OrderTransactionDetail) $OrderTransactionDetail = $OrderTransactionDetail->toArray();
	                        else  $OrderTransactionDetail = [];

							$return = 'OK';
							$data = [
								'date' => $UpdatedDate->format('Y-m-d H:i'),
								'status' => 'Delivered',
								'OrderTransactionDetail' => $OrderTransactionDetail,
							];

							$tmpOrderTransactionSeller = $this->OrderTransactionSeller->where([['TransactionCode', '=', $OrderTransactionSeller->TransactionCode],['StatusShipment', '!=', 3]])->first();
							if(!$tmpOrderTransactionSeller) {
								$OrderTransaction = $this->OrderTransaction->where([['TransactionCode', '=', $OrderTransactionSeller->TransactionCode],['StatusOrder', '=', 1]])->first();
								if($OrderTransaction) {
									$OrderTransaction->update([
		                    			'StatusOrder' => 2,
		                    			'UpdatedDate' => $UpdatedDate,
		                    			'UpdatedBy' => 0
		                    		]);

		                    		$data['TransactionCode'] = $OrderTransaction->TransactionCode;
								}
							}
                    	} else {
                        	$data['error'][] = 'Please contact admin';
                        }
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'FeedbackResponse' :
                    $feedbackresult = $request['feedbackresult'];

            		if(!$feedbackresult) {
            			$data['error'][] = 'Please contact admin';
                    } else {
                    	$feedbackresult = json_decode($feedbackresult, JSON_FORCE_OBJECT);

                    	$this->_loaddbclass(['OrderTransactionDetail']);

                    	foreach ($feedbackresult as $key => $value) {
                    		$OrderTransactionDetail = $this->OrderTransactionDetail->where([['ID', '=', $value['ID']]])->first();
                    		if($OrderTransactionDetail) {
                    			$OrderTransactionDetail->update([
	                    			'FeedbackAccuration' => $value['Accuration'],
	                    			'FeedbackQuality' => $value['Quality'],
	                    			'FeedbackService' => $value['Service'],
	                    			'FeedbackDate' => new \DateTime('now')
	                    		]);
                    		}
                    	}

						$return = 'OK';
                    	$data = '';
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
            }
        } else die(json_encode(['response' => 'error'], JSON_FORCE_OBJECT));
    }
}
