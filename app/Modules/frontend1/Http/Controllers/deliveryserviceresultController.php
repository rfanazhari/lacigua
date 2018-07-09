<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class deliveryserviceresultController extends Controller
{
	public function index()
	{
		$errormessage = $From = $To = $Weight = '';
		$ListArray = [];

		$request = \Request::instance()->request->all();

		if(isset($request['submit'])) {
			$From = $request['TmpFrom'];
			$To = $request['TmpTo'];
			$Weight = $request['Weight'];

			if($From && $To && $Weight) {
				$this->_loaddbclass(['Village']);

				$From = $this->Village->leftjoin([
                    ['province','province.ID','=','village.ProvinceID'],
                    ['city','city.ID','=','village.CityID'],
                    ['district','district.ID','=','village.DistrictID'],
                ])->select([
                    'province.Name as ProvinceName',
                    'city.Name as CityName',
                    'district.Name as DistrictName',
                    'district.JNECode as JNECode',
                    'village.Name as VillageName',
                    'village.ID as ID'
                ])->where([
                    ['village.IsActive','=',1],
                    ['village.Status','=',0],
                    ['district.IsActive','=',1],
                    ['district.Status','=',0],
                    ['city.IsActive','=',1],
                    ['city.Status','=',0],
                    ['province.IsActive','=',1],
                    ['province.Status','=',0],
                    ['village.ID','=',$From]
                ])->first();

                $FromJNECode = '';
                if($From) {
                	$FromJNECode = $From->JNECode;
                	$From = $From->DistrictName.', '.$From->VillageName;
                } else $errormessage = 'Data Cek Tarif tidak ditemukan !';

                $this->_loaddbclass(['Village']);

				$To = $this->Village->leftjoin([
                    ['province','province.ID','=','village.ProvinceID'],
                    ['city','city.ID','=','village.CityID'],
                    ['district','district.ID','=','village.DistrictID'],
                ])->select([
                    'province.Name as ProvinceName',
                    'city.Name as CityName',
                    'district.Name as DistrictName',
                    'district.JNECode as JNECode',
                    'village.Name as VillageName',
                    'village.ID as ID'
                ])->where([
                    ['village.IsActive','=',1],
                    ['village.Status','=',0],
                    ['district.IsActive','=',1],
                    ['district.Status','=',0],
                    ['city.IsActive','=',1],
                    ['city.Status','=',0],
                    ['province.IsActive','=',1],
                    ['province.Status','=',0],
                    ['village.ID','=',$To]
                ])->first();

                $ToJNECode = '';
                if($To) {
                	$ToJNECode = $To->JNECode;
                	$To = $To->DistrictName.', '.$To->VillageName;
                } else $errormessage = 'Data Cek Tarif tidak ditemukan!';

                $this->_loaddbclass(['Shipping']);

                foreach ($this->Shipping->where([
                    ['IsActive','=',1],
                    ['Status','=',0]
                ])->get() as $key => $value) {
                	if($value['ID'] == 1) { // JNE
                		$this->_loadfcclass([ 'JNE' ]);

                        $from = substr($FromJNECode, 0, 4).'0000';
                        $thru = $ToJNECode;

                        if(!$this->inv['config']['JNETest']) {
                        	$data = json_decode($this->JNE->_getprice($from, $thru, $Weight), True);	
                        } else {
                        	$data = '';
                            if(!$data) {
                            	$data = json_decode('{"price":[{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR","service_code":"JTR","price":"40000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR250","service_code":"JTR250","price":"1100000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR<150","service_code":"JTR<150","price":"500000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"JTR>250","service_code":"JTR>250","price":"1500000","etd_from":null,"etd_thru":null,"times":null},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"OKE","service_code":"OKE15","price":"16000","etd_from":"2","etd_thru":"3","times":"D"},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"REG","service_code":"REG15","price":"18000","etd_from":"1","etd_thru":"2","times":"D"},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"SPS","service_code":"SPS15","price":"443000","etd_from":"0","etd_thru":"0","times":"D"},{"origin_name":"JAKARTA","destination_name":"BANTUL,KAB.BANTUL","service_display":"YES","service_code":"YES15","price":"28000","etd_from":"1","etd_thru":"1","times":"D"}]}', True);
                            }
                        }
                        
                        $data = $data['price'];

                        $dispayname = [
                            'OKE' => '(Ongkos Kirim Ekonomis)',
                            'REG' => '(Reguler)',
                            'YES' => '(Yakin Esok Sampai)'
                        ];

                        foreach ($data as $key1 => $value1) {
                            if(!in_array($value1['service_display'], array_keys($dispayname))) {
                                unset($data[$key1]);
                            } else {
                            	$ListArray[] = [
                            		$value['Name'].' - '.$value1['service_display'],
                            		$value1['etd_from'].' - '.$value1['etd_thru'].' Hari',
                            		$this->_formatamount($value1['price'], 'Rupiah', 'Rp ').',-'
                            	];
                            }
                        }
                	}
                }
			} else $errormessage = 'Data Cek Tarif tidak ditemukan.';
		} else $errormessage = 'Data Cek Tarif tidak ditemukan.';

		$this->inv['errormessage'] = $errormessage;
		$this->inv['From'] = $From;
		$this->inv['To'] = $To;
		$this->inv['Weight'] = $Weight;
		$this->inv['ListArray'] = $ListArray;

		return $this->_showviewfront(['deliveryserviceresult']);
	}
}