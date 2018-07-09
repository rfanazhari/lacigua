<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class processingController extends Controller
{
	public function index()
	{
        // $this->_debugvar();
        $request = \Request::instance()->request->all();
        if(!isset($request['submit'])) return $this->_redirect('404');
        
        $Cart = \Session::get('Cart');
        if(!$Cart) return $this->_redirect('404');
        $InitialCart = \Session::get('InitialCart');
        if(!isset($InitialCart['CustomerID'])) return $this->_redirect('404');
        $Cart = $this->_constructCart($Cart);

        $TransactionCode = 'TRLG' . date('ymdhis');

		list($Type, $PaymentMethod) = explode('-', $request['PaymentMethod']);
        
        $this->_loaddbclass(['PaymentType', 'OrderTransaction', 'OrderTransactionDetail']);

        $PaymentType = $this->PaymentType->where([['ID', '=', $PaymentMethod]])->first();
        $ArrayTransaction = array(
            'TransactionCode' => $TransactionCode,
            'CustomerID' => $InitialCart['CustomerID'],
            'CurrencyCode' => 'IDR',
            'GrandTotal' => $Cart['GrandTotalRealTransaction'],
            'Type' => $Type,
            'PaymentTypeID' => $PaymentMethod,
            'PaymentTypeName' => $PaymentType->Name,
            'PaymentTypeImage' => $PaymentType->Image,
            'StatusOrder' => '0',
            'StatusPaid' => '0',
            'CreatedDate' => new \DateTime("now"),
            'CreatedBy' => 0,
        );

        if(isset($InitialCart['AsGuest']))
            $ArrayTransaction['AsGuest'] = $InitialCart['AsGuest'];

        switch ($Type) {
        	case 0: // Bank Transfer
        		$AccountNumber = $request["AccountNumber$PaymentMethod"];
        		$BeneficiaryName = $request["AccountNumber$PaymentMethod"];

                $this->_loaddbclass(['OrderTransaction','OrderTransactionDetail']);

                $Past1Hour = $this->OrderTransaction->where([['CreatedDate', '>=', 'DATE_SUB(NOW(),INTERVAL 1 HOUR)']])->orderBy('ID', 'DESC')->first();
                if($Past1Hour) {
                    if($Past1Hour->UniqueOrder == 999) {
                        $UniqueOrder = sprintf('%03d', 1);
                    } else {
                        $UniqueOrder = sprintf('%03d', $Past1Hour->UniqueOrder + 1);
                    }
                } else {
                    $UniqueOrder = sprintf('%03d', 1);
                }

                $ArrayTransaction['UniqueOrder'] = $UniqueOrder;
                $ArrayTransaction['GrandTotalUnique'] = (int)$Cart['GrandTotalRealTransaction'] + (int)$UniqueOrder;
                $ArrayTransaction['AccountNumber'] = $AccountNumber;
                $ArrayTransaction['BeneficiaryName'] = $BeneficiaryName;

                $this->_loaddbclass(['OurBank']);

                $AccountBankNumber = '';
                $OurBank = $this->OurBank->where([['ID', '=', $PaymentType->OurBankID]])->first();
                if($OurBank) $AccountBankNumber = $OurBank->BankAccountNumber;

                $ArrayTransaction['AccountBankNumber'] = $AccountBankNumber;

                $procedureofpayment = 'banktransfer';
    		break;
        	case 1: // Virtual Account
                switch ($PaymentMethod) {
                    case 5: // BCA VA
                        $this->_loaddbclass(['SprintBcava']);

                        $DateNow = new \DateTime("now");
                        $CreatedDate = $DateNow->format('Y-m-d H:i:s');
                        $ExpiredDate = $DateNow->modify('+1 hours')->format('Y-m-d H:i:s');
                        $array = array(
                            'TransactionCode' => $TransactionCode,
                            'CreatedDate' => $CreatedDate,
                            'ExpiredDate' => $ExpiredDate,
                            'GrandTotal' => $Cart['GrandTotalRealTransaction'],
                            'CurrencyCode' => 'IDR',
                            'Description' => "Order".$TransactionCode,
                            'AdditionalData' => '',
                            'ItemDetail' => '',
                        );

                        if(isset($InitialCart['AsGuest']))
                            $array['CustomerName'] = $InitialCart['AsGuest'];
                        else
                            $array['CustomerName'] = \Session::get('customerdata')['ccustomername'];

                        $SprintBcava = $this->SprintBcava->creates($array);

                        $this->_loadfcclass([ 'SprintBCAVA' ]);

                        $VANumber = $this->SprintBCAVA->_getvanumber(date('y')[1].date("mdhis"));
                        $SprintBCAVA = $this->SprintBCAVA->_request($SprintBcava, $VANumber);
                        $SprintBCAVARS = json_decode($SprintBCAVA['rs'],TRUE);
                        $SprintBcava->update([
                            'PackageData' => json_encode($SprintBCAVA['data'], JSON_FORCE_OBJECT),
                            'VANumber' => $VANumber,
                            'Status' => 'ORDERING',
                            'InsertStatus' => $SprintBCAVARS['insertStatus'],
                            'InsertMessage' => $SprintBCAVARS['insertMessage'],
                            'InsertID' => $SprintBCAVARS['insertId'],
                        ]);

                        $ArrayTransaction['VANumber'] = $VANumber;

                        $procedureofpayment = 'bcava';
                    break;
                    case 6: // Permata VA
                        $this->_loaddbclass(['SprintPermatava']);

                        $DateNow = new \DateTime("now");
                        $CreatedDate = $DateNow->format('Y-m-d H:i:s');
                        $ExpiredDate = $DateNow->modify('+1 hours')->format('Y-m-d H:i:s');
                        $array = array(
                            'TransactionCode' => $TransactionCode,
                            'CreatedDate' => $CreatedDate,
                            'ExpiredDate' => $ExpiredDate,
                            'GrandTotal' => $Cart['GrandTotalRealTransaction'],
                            'CurrencyCode' => 'IDR',
                            'Description' => "Order".$TransactionCode,
                            'AdditionalData' => '',
                        );

                        if(isset($InitialCart['AsGuest']))
                            $array['CustomerName'] = $InitialCart['AsGuest'];
                        else
                            $array['CustomerName'] = \Session::get('customerdata')['ccustomername'];

                        $SprintPermatava = $this->SprintPermatava->creates($array);

                        $this->_loadfcclass([ 'SprintPermataVA' ]);

                        $VANumber = $this->SprintPermataVA->_getvanumber(date("mdhis"));
                        $SprintPermataVA = $this->SprintPermataVA->_request($SprintPermatava, $VANumber);
                        $SprintPermataVARS = json_decode($SprintPermataVA['rs'],TRUE);
                        $SprintPermatava->update([
                            'PackageData' => json_encode($SprintPermataVA['data'], JSON_FORCE_OBJECT),
                            'VANumber' => $VANumber,
                            'Status' => 'ORDERING',
                            'InsertStatus' => $SprintPermataVARS['insertStatus'],
                            'InsertMessage' => $SprintPermataVARS['insertMessage'],
                            'InsertID' => $SprintPermataVARS['insertId'],
                        ]);

                        $ArrayTransaction['VANumber'] = $VANumber;

                        $procedureofpayment = 'permatava';
                    break;
                }
    		break;
        	case 2: // Internet Banking
                switch ($PaymentMethod) {
                    case 7: // ePay BRI
                        $this->_loaddbclass(['SprintEpaybri']);

                        $DateNow = new \DateTime("now");
                        $CreatedDate = $DateNow->format('Y-m-d H:i:s');
                        $ExpiredDate = $DateNow->modify('+1 hours')->format('Y-m-d H:i:s');
                        $array = array(
                            'TransactionCode' => $TransactionCode,
                            'CreatedDate' => $CreatedDate,
                            'ExpiredDate' => $ExpiredDate,
                            'GrandTotalUnshipping' => $Cart['GrandTotalRealTransactionUnshipping'],
                            'CurrencyCode' => 'IDR',
                            'Description' => "Order".$TransactionCode,
                            'AdditionalData' => '',
                        );

                        foreach ($this->_constructViewCart(\Session::get('Cart')) as $key => $value) {
                            if(is_numeric($key)) {
                                $array['ItemDetail'][] = [
                                    "itemName"  => $value['ProductName'],
                                    "quantity"  => $value['ProductQty'],
                                    "price"     => $value['ProductRealPrice'],
                                ];
                            }
                        }

                        $array['ItemDetail'] = json_encode($array['ItemDetail'], JSON_FORCE_OBJECT);

                        $SprintEpaybri = $this->SprintEpaybri->creates($array);

                        $this->_loadfcclass([ 'SprintEpayBRI' ]);

                        $SprintEpayBRI = $this->SprintEpayBRI->_request($SprintEpaybri);
                        $SprintEpayBRIRS = json_decode($SprintEpayBRI['rs'],TRUE);
                        $SprintEpaybri->update([
                            'PackageData' => json_encode($SprintEpayBRI['data'], JSON_FORCE_OBJECT),
                            'Status' => 'ORDERING',
                            'InsertStatus' => $SprintEpayBRIRS['insertStatus'],
                            'InsertMessage' => $SprintEpayBRIRS['insertMessage'],
                            'InsertID' => $SprintEpayBRIRS['insertId'],
                        ]);

                        if($SprintEpayBRIRS['insertStatus'] == "00" AND $SprintEpayBRIRS['redirectURL'] != "" AND COUNT($SprintEpayBRIRS['redirectData']) > 0 ) {
                            echo '<form method="POST" action="'.$SprintEpayBRIRS['redirectURL'].'" id="dataPOST">';
                            foreach ($SprintEpayBRIRS['redirectData'] as $key => $value) {
                                echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
                            }
                            echo '</form>';
                            echo '<script type="text/javascript">document.getElementById("dataPOST").submit();</script>';
                            exit;
                        } else die($SprintEpayBRIRS['insertMessage']);

                        $procedureofpayment = 'epaybri';
                    break;
                    case 8: // BCA KlikPay
                        $this->_loaddbclass(['SprintBcaklikpay']);

                        $DateNow = new \DateTime("now");
                        $CreatedDate = $DateNow->format('Y-m-d H:i:s');
                        $ExpiredDate = $DateNow->modify('+1 hours')->format('Y-m-d H:i:s');
                        $array = array(
                            'TransactionCode' => $TransactionCode,
                            'CreatedDate' => $CreatedDate,
                            'ExpiredDate' => $ExpiredDate,
                            'GrandTotalUnshipping' => $Cart['GrandTotalRealTransactionUnshipping'],
                            'GrandTotalFee' => $Cart['GrandTotalRealTransaction'] - $Cart['GrandTotalRealTransactionUnshipping'],
                            'CurrencyCode' => 'IDR',
                            'Description' => "Order".$TransactionCode,
                            'AdditionalData' => '',
                        );

                        foreach ($this->_constructViewCart(\Session::get('Cart')) as $key => $value) {
                            if(is_numeric($key)) {
                                $array['ItemDetail'][] = [
                                    "itemName"  => $value['ProductName'],
                                    "quantity"  => $value['ProductQty'],
                                    "price"     => $value['ProductRealPrice'],
                                ];
                            }
                        }

                        $array['ItemDetail'] = json_encode($array['ItemDetail'], JSON_FORCE_OBJECT);

                        $SprintBcaklikpay = $this->SprintBcaklikpay->creates($array);

                        $this->_loadfcclass([ 'SprintBCAKlikPay' ]);

                        $SprintBCAKlikPay = $this->SprintBCAKlikPay->_request($SprintBcaklikpay);
                        $SprintBCAKlikPayRS = json_decode($SprintBCAKlikPay['rs'],TRUE);
                        $SprintBcaklikpay->update([
                            'PackageData' => json_encode($SprintBCAKlikPay['data'], JSON_FORCE_OBJECT),
                            'Status' => 'ORDERING',
                            'InsertStatus' => $SprintBCAKlikPayRS['insertStatus'],
                            'InsertMessage' => $SprintBCAKlikPayRS['insertMessage'],
                            'InsertID' => $SprintBCAKlikPayRS['insertId'],
                        ]);

                        if($SprintBCAKlikPayRS['insertStatus'] == "00" AND $SprintBCAKlikPayRS['redirectURL'] != "" AND COUNT($SprintBCAKlikPayRS['redirectData']) > 0 ) {
                            echo '<form method="POST" action="'.$SprintBCAKlikPayRS['redirectURL'].'" id="dataPOST">';
                            foreach ($SprintBCAKlikPayRS['redirectData'] as $key => $value) {
                                echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
                            }
                            echo '</form>';
                            echo '<script type="text/javascript">document.getElementById("dataPOST").submit();</script>';
                            exit;
                        } else die($SprintBCAKlikPayRS['insertMessage']);

                        $procedureofpayment = 'bcaklikpay';
                    break;
                }
    		break;
            case 3: // Credit Card / Virtual Card
            break;
        	case 4: // Another / Gerai
    		break;
        }

        $OrderTransaction = $this->OrderTransaction->creates($ArrayTransaction);

        if($OrderTransaction->GrandTotal > 200000) {
            $tmpOrderTransaction = $this->OrderTransaction->where([['CustomerID', '=', $InitialCart['CustomerID']]])->get();
            if(count($tmpOrderTransaction) == 1) {
                $this->_loaddbclass(['Customer', 'GetStoreCredit']);

                $Customer = $this->Customer->where([['ID', '=', $InitialCart['CustomerID']],['CreatedDate', '>=', 'DATE_SUB(NOW(), INTERVAL 30 DAY)']])->first();
                if($Customer) {
                    if($Customer->ReferralCustomerID) {
                        $tmpCustomer = $this->Customer->where([['ID', '=', $Customer->ReferralCustomerID]])->first();
                        if($tmpCustomer) {
                            $this->GetStoreCredit->creates([
                                'TransactionCode' => $TransactionCode,
                                'FromCustomerID' => $Customer->ID,
                                'ToCustomerID' => $tmpCustomer->ID,
                                'StoreCreditAmount' => 50000,
                                'CreatedDate' => new \DateTime("now"),
                                'Status' => 0
                            ]);
                        }
                    }
                }
            }
        }
        
        $this->compileCart($Cart, $TransactionCode);

        \Session::put('FinishCart', array_merge($ArrayTransaction, ['procedureofpayment' => $procedureofpayment]));

        return \Redirect::to('purchase-completed');
	}

    public function compileCart($Cart, $TransactionCode)
    {
        foreach($Cart as $key => $val) {
            if(!is_numeric($key)) continue;
            foreach($val['Shipping'] as $key1 => $val1) {
                foreach($val1['ShippingPackage'] as $key2 => $val2) {
                    foreach($val2['District'] as $key3 => $val3) {
                        $QtyProductShip = 0;
                        $WeightProductShip = 0;
                        $PriceProductShip = 0;
                        $DescProductShip = '';
                        foreach($val3['Product'] as $key4 => $val4) {
                            $array = array(
                                'TransactionCode' => $TransactionCode,
                                'ArrayIndex' => $key,
                                'SellerID' => $val['SellerID'],
                                'ShippingID' => $val1['ShippingID'],
                                'ShippingPackageID' => $val2['ShippingPackageID'],
                                'IDDistrict' => $val3['IDDistrict'],
                                'ProductID' => $val4['ProductID'],
                                'ProductPrice' => $val4['ProductRealPrice'],
                                'Qty' => $val4['ProductQty'],
                                'Weight' => $val4['ProductWeight'],
                                'ColorID' => $val4['ProductColorID'],
                                'GroupSizeID' => $val4['ProductGroupSizeID'],
                                'SizeVariantID' => $val4['ProductSizeVariantID'],
                                'Notes' => $val4['ProductNotes'],
                                'CustomerAddressID' => $val4['IDCustomerAddress'],
                                'AddressInfo' => $val4['TextAddressInfo'],
                                'RecepientName' => $val4['TextRecepientName'],
                                'RecepientPhone' => $val4['TextRecepientPhone'],
                                'Address' => $val4['TextAddress'],
                                'ProvinceID' => $val4['IDProvince'],
                                'CityID' => $val4['IDCity'],
                                'DistrictID' => $val4['IDDistrict'],
                                'PostalCode' => $val4['TextPostalCode'],
                                'ShippingPackage' => $val4['ShippingPackage'],
                                'ShippingPrice' => $val4['ShippingRealPrice'],
                            );

                            $OrderTransactionDetail = $this->OrderTransactionDetail->creates($array);

                            $this->_loaddbclass([ 'Product','ProductDetailSizeVariant','SizeLink' ]);

                            $Product = $this->Product->where([['ID', '=', $val4['ProductID']]])->first();
                            if($Product) {
                                $SizeVariantID = $val4['ProductSizeVariantID'];
                                if($Product->GroupSizeID != $val4['ProductGroupSizeID']) {
                                    $SizeLink = $this->SizeLink->where([['SizeVariantIDLink', '=', $SizeVariantID]])->first();
                                    $SizeVariantID = $SizeLink->SizeVariantID;
                                }
                                
                                $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->where([['ProductID', '=', $val4['ProductID']],['SizeVariantID', '=', $SizeVariantID]])->first();
                                if($ProductDetailSizeVariant) {
                                    $ProductDetailSizeVariant->update([
                                        'Qty' => $ProductDetailSizeVariant->Qty - $val4['ProductQty']
                                    ]);
                                }
                            }

                            $QtyProductShip = $QtyProductShip + $val4['ProductQty'];
                            $WeightProductShip = $WeightProductShip + $val4['ProductWeight'];
                            $PriceProductShip = $PriceProductShip + $val4['ProductRealPrice'];
                            $DescProductShip = $DescProductShip.$val4['ProductQty'].' Product ('.$val4['ProductRealPrice'].'),';

                            if($val4['ShippingRealPrice']) {
                                $this->_loaddbclass([ 'OrderTransactionSeller' ]);

                                $TransactionSellerCode = date("ymdhis").gettimeofday()["usec"];

                                $array = array(
                                    'TransactionCode' => $TransactionCode,
                                    'TransactionSellerCode' => $TransactionSellerCode,
                                    'SellerID' => $val['SellerID'],
                                    'ShippingID' => $val1['ShippingID'],
                                    'ShippingPackageID' => $val2['ShippingPackageID'],
                                    'IDDistrict' => $val3['IDDistrict'],
                                    'QtyProductShip' => $QtyProductShip,
                                    'WeightProductShip' => ceil($WeightProductShip),
                                    'PriceProductShip' => $PriceProductShip,
                                    'DescProductShip' => rtrim($DescProductShip, ','),
                                    'ShippingPrice' => $val4['ShippingRealPrice'],
                                    'AWBNumber' => '',
                                    'StatusShipment' => '0',
                                    'CreatedDate' => new \DateTime("now"),
                                    'CreatedBy' => 0,
                                );

                                $OrderTransactionSeller = $this->OrderTransactionSeller->creates($array);

                                switch ($val1['ShippingID']) {
                                    case 1: // JNE
                                        $this->_loadfcclass([ 'JNE' ]);

                                        $arrayshipping = array(
                                            'OLSHOP_BRANCH' => substr($val['PickupJNECode'], 0, 3).'000',
                                            'OLSHOP_CUST' => $this->JNE->ID,
                                            'OLSHOP_ORIG' => substr($val['PickupJNECode'], 0, 4).'0000',
                                            'OLSHOP_ORDERID' => $TransactionSellerCode,
                                            'OLSHOP_SHIPPER_NAME' => $val['SellerName'],
                                            'OLSHOP_SHIPPER_ADDR1' => $val['SellerAddress'],
                                            'OLSHOP_SHIPPER_ADDR2' => '',
                                            'OLSHOP_SHIPPER_ADDR3' => '',
                                            'OLSHOP_SHIPPER_CITY' => $val['SellerCity'],
                                            'OLSHOP_SHIPPER_REGION' => '',
                                            'OLSHOP_SHIPPER_ZIP' => $val['SellerZipCode'],
                                            'OLSHOP_SHIPPER_PHONE' => str_replace('+62', '0', str_replace(' ', '', $val['SellerPhone'])),
                                            'OLSHOP_RECEIVER_NAME' => $val4['TextRecepientName'],
                                            'OLSHOP_RECEIVER_ADDR1' => $val4['TextAddress'],
                                            'OLSHOP_RECEIVER_ADDR2' => '',
                                            'OLSHOP_RECEIVER_ADDR3' => '',
                                            'OLSHOP_RECEIVER_CITY' => $val4['TextCityName'],
                                            'OLSHOP_RECEIVER_REGION' => '',
                                            'OLSHOP_RECEIVER_ZIP' => $val4['TextPostalCode'],
                                            'OLSHOP_RECEIVER_PHONE' => str_replace('+62', '0', str_replace(' ', '', $val4['TextRecepientPhone'])),
                                            'OLSHOP_DEST' => $val3['DistrictJNECode'],
                                            'OLSHOP_SERVICE' => $val2['ShippingPackageID'],
                                            'OLSHOP_QTY' => $QtyProductShip,
                                            'OLSHOP_WEIGHT' => ceil($WeightProductShip),
                                            'OLSHOP_GOODSTYPE' => 2,
                                            'OLSHOP_GOODSDESC' => rtrim($DescProductShip, ','),
                                            'OLSHOP_INST' => '',
                                            'OLSHOP_GOODSVALUE' => $PriceProductShip,
                                            'OLSHOP_INS_FLAG' => 'N'
                                        );

                                        $OrderTransactionSeller->update(['PackageData' => json_encode($arrayshipping, JSON_FORCE_OBJECT)]);
                                        // $shippingresponse = json_decode($this->JNE->_createAirwaybill($arrayshipping), True);
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}