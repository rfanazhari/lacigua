<?php

/*
 * This file is mail library support | invasma sinar indonesia.
 *
 * (c) Refnaldi Hakim Monintja <refnaldihakim@invasma.com>
 *
 * INVASMA 2016
 */

namespace App\Library;

class JNE extends \App\Library\GlobalFunctionsCall
{
	var $ID = 10833600;
	var $username = 'LACIGUE';
	var $key = '7fb6ac60a7a7d4b63951ad1fa3c70ab5';
	var $urlprice = 'http://api.jne.co.id:8889/tracing/lacigue/price';
	var $urlairwaybill = 'http://api.jne.co.id:8889/tracing/lacigue/generateCnoteTraining';
	
	public function _getprice($from, $thru, $weight) {
		if($from && $thru && $weight) {
			$array = [
                'username' => $this->username,
                'api_key' => $this->key,
                'from' => $from,
                'thru' => $thru,
                'weight' => $weight
            ];

            return $this->_curlpost($this->urlprice, $array);
		}
	}

	public function _createAirwaybill($array) {
		if($array) {
			$array = array_merge(['username' => $this->username, 'api_key' => $this->key], $array);

            return $this->_curlpost($this->urlairwaybill, $array);
		}
	}
}