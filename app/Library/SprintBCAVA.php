<?php

/*
 * This file is mail library support | invasma sinar indonesia.
 *
 * (c) Refnaldi Hakim Monintja <refnaldihakim@invasma.com>
 *
 * INVASMA 2016
 */

namespace App\Library;

class SprintBCAVA extends \App\Library\GlobalFunctionsCall
{
	var $ChannelID = 'LACIGBVA01';
	var $SecretKey = 'a81918c98bf09d5ca04f0fd0eb182efa';
	var $CompanyCode = 39111;
	var $InsertTransactionURL = 'https://simpg.sprintasia.net/PaymentRegister'; // Development
	// var $InsertTransactionURL = 'https://pay.sprintasia.net:8899/PaymentRegister'; // Staging
	// var $InsertTransactionURL = 'https://pay.sprintasia.net/PaymentRegister'; // Production
	
	public function _getvanumber($str) {
		return $this->CompanyCode.$str;
	}

	public function _request($array, $VANumber) {
		$data = array(
		    "channelId"         => $this->ChannelID,
		    "currency"          => $array->CurrencyCode,
		    "transactionNo"     => $array->TransactionCode,
		    "transactionAmount" => $array->GrandTotal,
		    "transactionDate"   => $array->CreatedDate,
		    "transactionExpire" => $array->ExpiredDate,
		    "description"       => $array->Description,
		    "itemDetail"        => $array->ItemDetail,
		    "authCode"          => hash("sha256", $array->TransactionCode.$array->GrandTotal.$this->ChannelID.$this->SecretKey),
		    "additionalData"    => $array->AdditionalData,
		    "customerAccount"   => $VANumber,
		    "customerName"      => $array->CustomerName,
		);

		$OPT = http_build_query($data);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->InsertTransactionURL);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $OPT);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		$rs = curl_exec($ch);

		if(empty($rs)) {
			curl_close($ch);
			return false;
		}
		curl_close($ch);
		return ['rs' => $rs, 'data' => $data];
	}

	public function _response($request, $SprintBcava) {
		$data_sprint = array(
		    "channelId"           => $request['channelId'],
		    "currency"            => $request['currency'],
		    "transactionNo"       => $request['transactionNo'],
		    "transactionAmount"   => $request['transactionAmount'],
		    "transactionDate"     => $request['transactionDate'],
		    "transactionStatus"   => $request['transactionStatus'],
		    "transactionMessage"  => $request['transactionMessage'],
		    "flagType"            => $request['flagType'],
		    "insertId"            => $request['insertId'],
		    "paymentReffId"       => $request['paymentReffId'],
		    "authCode"            => $request['authCode'],
		    "additionalData"      => $request['additionalData'],
		);

		$response = array(
		    "channelId"           => $request['channelId'],
		    "currency"            => $request['currency'],
		    "paymentStatus"       => "",
		    "paymentMessage"      => "",
		    "flagType"            => $request['flagType'],
		    "paymentReffId"       => $request['paymentReffId'],
		);

		$authCode = hash("sha256", $SprintBcava->TransactionCode.$SprintBcava->GrandTotal.$this->ChannelID.$request['transactionStatus'].$SprintBcava->InsertID.$this->SecretKey);

		if( !$SprintBcava ) {
		    $response['paymentStatus']  = "01";
		    $response['paymentMessage'] = "Invalid Transaction";
		} elseif( $data_sprint['channelId'] != $this->ChannelID ) {
		    $response['paymentStatus']  = "01";
		    $response['paymentMessage'] = "Invalid Channel ID";
		} elseif( $data_sprint['currency'] != "IDR" ) {
		    $response['paymentStatus']  = "01";
		    $response['paymentMessage'] = "Invalid Currency";
		} elseif( $data_sprint['transactionNo'] != $SprintBcava->TransactionCode ) {
		    $response['paymentStatus']  = "01";
		    $response['paymentMessage'] = "Invalid Currency";
		} elseif( $data_sprint['transactionAmount'] != $SprintBcava->GrandTotal ) {
		    $response['paymentStatus']  = "01";
		    $response['paymentMessage'] = "Invalid Transaction Amount";
		} elseif( $data_sprint['transactionStatus'] != "00" ) {
		    $response['paymentStatus']  = "01";
		    $response['paymentMessage'] = "Invalid Transaction Status ";
		} elseif( $_REQUEST['flagType'] != "11" && $_REQUEST['flagType'] != "12" && $_REQUEST['flagType'] != "13" ) {
		    $response['paymentStatus']  = "01";
		    $response['paymentMessage'] = "Invalid Flagtype";
		} elseif( $data_sprint['insertId'] != $SprintBcava->InsertID ) {
		    $response['paymentStatus']  = "01";
		    $response['paymentMessage'] = "Invalid insertId";
		} elseif( $data_sprint['authCode'] != $authCode ) {
		    $response['paymentStatus'] = "01";
		    $response['paymentMessage'] = "Invalid authCode";
		} elseif( $SprintBcava->Status == "CANCELLED" ) {
		    $response['paymentStatus']  = "05";
		    $response['paymentMessage'] = "Transaction has been cancelled";
		} elseif( $SprintBcava->Status == "EXPIRED" ) {
		    $response['paymentStatus']  = "04";
		    $response['paymentMessage'] = "Transaction has been expired";
		} elseif( $SprintBcava->Status == "PAID" ) {
		    $response['paymentStatus']  = "02";
		    $response['paymentMessage'] = "Transaction has been paid";
		} else {
		    $response['paymentStatus']  = "00";
		    $response['paymentMessage'] = "Success";
		}

		return $response;
	}
}