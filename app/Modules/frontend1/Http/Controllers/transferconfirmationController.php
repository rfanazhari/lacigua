<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class transferconfirmationController extends Controller
{
	var $pathimage = '/resources/assets/backend/images/transfer-confirmation/';
	public function index()
	{
		$TransactionCode = $errorTransactionCode = $BankName = $errorBankName = $BankBeneficiaryName = $errorBankBeneficiaryName = $Total = $errorTotal = $TransferDate = $errorTransferDate = $BankID = $errorBankID = $ImageTransfer = $errorImageTransfer = $ImageTransferfiletype = $OrderTransaction = '';

		$this->_loaddbclass(['OurBank']);

		$OurBank = $this->OurBank->where([['IsActive', '=', 1],['Status', '=', 0]])->orderBy('BankName')->get();
		$this->inv['OurBank'] = $OurBank;

		$request = \Request::instance()->request->all();
		$requestfile = \Request::file();

		if(isset($request['submit'])) {
			$TransactionCode = $request['TransactionCode'];
			if (empty($TransactionCode)) {
                $errorTransactionCode = $this->_trans('validation.mandatory',
                    ['value' => 'No Order']
                );
            }

            if($TransactionCode) {
            	$this->_loaddbclass(['OrderTransaction']);

            	$OrderTransaction = $this->OrderTransaction->where([['TransactionCode', '=', $TransactionCode]])->first();

            	if(!$OrderTransaction) {
	                $errorTransactionCode = $this->_trans('validation.norecorddata',
	                    ['value' => 'No Order']
	                );
            	}

            	$this->_loaddbclass(['TransferConfirmation']);

            	$TransferConfirmation = $this->TransferConfirmation->where([['TransactionCode', '=', $TransactionCode]])->first();

            	if($TransferConfirmation) {
	                $errorTransactionCode = $this->_trans('validation.already',
	                    ['value' => 'No Order']
	                );
            	}
            }

			$BankName = $request['BankName'];
			if (empty($BankName)) {
                $errorBankName = $this->_trans('validation.mandatory',
                    ['value' => 'Bank Anda']
                );
            }

			$BankBeneficiaryName = $request['BankBeneficiaryName'];
			if (empty($BankBeneficiaryName)) {
                $errorBankBeneficiaryName = $this->_trans('validation.mandatory',
                    ['value' => 'Rekening Atas Nama']
                );
            }

			$Total = $request['Total'];
			if (empty($Total)) {
                $errorTotal = $this->_trans('validation.mandatory',
                    ['value' => 'Nominal Transfer']
                );
            }

			$TransferDate = $request['TransferDate'];
			if (empty($TransferDate)) {
                $errorTransferDate = $this->_trans('validation.mandatoryselect',
                    ['value' => 'Tanggal Transfer']
                );
            }

			$BankID = $request['BankID'];
			if (empty($BankID)) {
                $errorBankID = $this->_trans('validation.mandatoryselect',
                    ['value' => 'Bank Tujuan']
                );
            }

			if(isset($requestfile['ImageTransfer'])) $ImageTransfer = $requestfile['ImageTransfer'];
            else $ImageTransfer = '';
            if(empty($ImageTransfer)) {
                $errorImageTransfer = $this->_trans('validation.mandatoryselect', 
                    ['value' => 'Upload Bukti Transfer']
                );
            }
            if($ImageTransfer && !$this->_checkimage($ImageTransfer, $ImageTransferfiletype)) {
                $errorImageTransfer = $this->_trans('validation.format', 
                    ['value' => 'Upload Bukti Transfer', 'format' => 'Image Format']
                );
            }

            if(!$errorTransactionCode && !$errorBankName && !$errorBankBeneficiaryName && !$errorTotal && !$errorTransferDate && !$errorBankID && !$errorImageTransfer) {
            	$this->_loaddbclass(['TransferConfirmation']);

                $array = array(
                    'TransactionCode' => $TransactionCode,
                    'BankName' => $BankName,
                    'BankBeneficiaryName' => $BankBeneficiaryName,
                    'GrandTotal' => $Total,
                    'TransferDate' => $this->_dateformysql($TransferDate),
                    'OurBankID' => $BankID,
                );

                $array['CreatedDate'] = new \DateTime("now");
                
                $TransferConfirmation = $this->TransferConfirmation->creates($array);

	            if($ImageTransfer) {
	                $ImageName = 'TransferConfirmation_'.$TransferConfirmation['ID'].$ImageTransferfiletype;
	                $array['ImageTransfer'] = $ImageName;
	                $TransferConfirmation->update($array);
	                list($width, $height) = getimagesize($ImageTransfer->GetPathName());
	                $this->_imagetofolderratio($ImageTransfer, base_path().$this->pathimage, $ImageName, $width, $height);
	                $this->_imagetofolderratio($ImageTransfer, base_path().$this->pathimage, 'medium_'.$ImageName, $width / 3, $height / 3);
	                $this->_imagetofolderratio($ImageTransfer, base_path().$this->pathimage, 'small_'.$ImageName, $width / 6, $height / 6);
	            }

	            $this->_loaddbclass(['OrderTransaction','OrderTransactionSeller','OrderTransactionDetail']);

		        $OrderTransaction = $this->OrderTransaction->leftjoin([
		            ['customer as c', 'c.ID', '=', 'order_transaction.CustomerID'],
		        ])->selectraw('
		            c.FullName as CustomerName,
		            order_transaction.*
		        ')->where([
		        	['order_transaction.TransactionCode', '=', $TransactionCode],
		        ]);

		        $OrderTransaction = $OrderTransaction->get();

		        if($OrderTransaction) {
		        	$OrderTransaction = $OrderTransaction->toArray();
		        	foreach ($OrderTransaction as $key1 => $value1) {
			        	$OrderTransaction[$key1]['ListSeller'] = $this->OrderTransactionSeller->leftjoin([
			                ['seller as s', 's.ID', '=', 'order_transaction_seller.SellerID'],
			                ['shipping as sg', 'sg.ID', '=', 'order_transaction_seller.ShippingID'],
			                ['district as d', 'd.ID', '=', 'order_transaction_seller.IDDistrict'],
			                ['city as c', 'c.ID', '=', 'd.CityID'],
			                ['province as p', 'p.ID', '=', 'd.ProvinceID'],
			            ])->selectraw('
			                s.FullName as SellerName,
			                sg.Name as ShippingName,
			                CONCAT(p.Name,"<br/>",c.Name," - ",d.Name) as DistrictName,
			                order_transaction_seller.*
			            ')->where([['TransactionCode', '=', $value1['TransactionCode']]])->get();

			            if($OrderTransaction[$key1]['ListSeller']) {
			            	$OrderTransaction[$key1]['ListSeller'] = $OrderTransaction[$key1]['ListSeller']->toArray();
			            	foreach ($OrderTransaction[$key1]['ListSeller'] as $key2 => $value2) {
		                        $OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct'] = $this->OrderTransactionDetail->leftjoin([
		                            ['product as p', 'p.ID', '=', 'order_transaction_detail.ProductID'],
		                            ['colors as cs', 'cs.ID', '=', 'order_transaction_detail.ColorID'],
		                            ['brand as b', 'b.ID', '=', 'p.BrandID'],
		                            ['size_variant as sv', 'sv.ID', '=', 'order_transaction_detail.SizeVariantID'],
		                            ['district as d', 'd.ID', '=', 'order_transaction_detail.DistrictID'],
		                            ['city as c', 'c.ID', '=', 'order_transaction_detail.CityID'],
		                            ['shipping as sg', 'sg.ID', '=', 'order_transaction_detail.ShippingID'],
		                        ])->selectraw('
		                            cs.Name as ColorName,
		                            b.Name as BrandName,
		                            sv.Name as SizeName,
		                            d.Name as DistrictName,
		                            c.Name as CityName,
		                            sg.Name as ShippingName,
		                            p.permalink as ProductPermalink,
		                            p.*,
		                            order_transaction_detail.*
		                        ')->where([
		                            ['order_transaction_detail.TransactionCode', '=', $value2['TransactionCode']],
		                            ['order_transaction_detail.SellerID', '=', $value2['SellerID']],
		                            ['order_transaction_detail.ShippingID', '=', $value2['ShippingID']],
		                            ['order_transaction_detail.ShippingPackageID', '=', $value2['ShippingPackageID']],
		                            ['order_transaction_detail.IDDistrict', '=', $value2['IDDistrict']],
		                        ])->get();

		                        if($OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct']) {
		                        	$OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct'] = $OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct']->toArray();
		                        } else $OrderTransaction[$key1]['ListSeller'][$key2]['ListProduct'] = [];
		                    }
			            } else $OrderTransaction[$key]['ListSeller'] = [];
			        }
		        } else $OrderTransaction = [];

	            $TransactionCode = $errorTransactionCode = $BankName = $errorBankName = $BankBeneficiaryName = $errorBankBeneficiaryName = $Total = $errorTotal = $TransferDate = $errorTransferDate = $BankID = $errorBankID = $ImageTransfer = $errorImageTransfer = $ImageTransferfiletype = '';
	        }
		}

		if($errorTransactionCode || $errorBankName || $errorBankBeneficiaryName || $errorTotal || $errorTransferDate || $errorBankID || $errorImageTransfer) {
			$OrderTransaction = '';
		}

		$this->inv['OrderTransaction'] = $OrderTransaction;

		$this->inv['TransactionCode'] = $TransactionCode; $this->inv['errorTransactionCode'] = $errorTransactionCode;
		$this->inv['BankName'] = $BankName; $this->inv['errorBankName'] = $errorBankName;
		$this->inv['BankBeneficiaryName'] = $BankBeneficiaryName; $this->inv['errorBankBeneficiaryName'] = $errorBankBeneficiaryName;
		$this->inv['Total'] = $Total; $this->inv['errorTotal'] = $errorTotal;
		if(!$TransferDate) $TransferDate = date('D, d M Y');
		$this->inv['TransferDate'] = $TransferDate; $this->inv['errorTransferDate'] = $errorTransferDate;
		$this->inv['BankID'] = $BankID; $this->inv['errorBankID'] = $errorBankID;
		$this->inv['ImageTransfer'] = $ImageTransfer; $this->inv['errorImageTransfer'] = $errorImageTransfer;


		return $this->_showviewfront(['transferconfirmation']);
	}
}