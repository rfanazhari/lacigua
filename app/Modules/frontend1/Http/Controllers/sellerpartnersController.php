<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class sellerpartnersController extends Controller
{
	public function index()
	{
		$CompanyName = $errorCompanyName = $FullName = $errorFullName = $Email = $errorEmail = $Phone = $errorPhone = $Website = $errorWebsite = $Note = $errorNote = $Message = '';

		$request = \Request::instance()->request->all();
		if(isset($request['submit'])) {
			if(isset($request['CompanyName'])) $CompanyName = $request['CompanyName'];
			if(isset($request['FullName'])) $FullName = $request['FullName'];
			if(isset($request['Email'])) $Email = $request['Email'];
			if(isset($request['Phone'])) $Phone = $request['Phone'];
			if(isset($request['Website'])) $Website = $request['Website'];
			if(isset($request['Note'])) $Note = $request['Note'];

			// if(!$CompanyName) $errorCompanyName = 'error';
			if(!$FullName) $errorFullName = 'error';
			if(!$Email) $errorEmail = 'error';
			if($this->_email($Email)) $errorEmail = 'error';
			if(!$Phone) $errorPhone = 'error';
			// if(!$Website) $errorWebsite = 'error';

			$Message = 'error';
			if(!$errorCompanyName && !$errorFullName && !$errorEmail && !$errorPhone && !$errorWebsite && !$errorNote) {
				$this->_loaddbclass(['SellerPartner']);

				$this->SellerPartner->creates([
					'CompanyName' => $CompanyName,
					'FullName' => $FullName,
					'Email' => $Email,
					'Phone' => $Phone,
					'Website' => $Website,
					'Note' => $Note,
					'CreatedDate' => new \Datetime('now')
				]);

				$Message = 'success';

				$CompanyName = $errorCompanyName = $FullName = $errorFullName = $Email = $errorEmail = $Phone = $errorPhone = $Website = $errorWebsite = $Note = $errorNote = '';
			}
		}

		$this->inv['CompanyName'] = $CompanyName; $this->inv['errorCompanyName'] = $errorCompanyName;
		$this->inv['FullName'] = $FullName; $this->inv['errorFullName'] = $errorFullName;
		$this->inv['Email'] = $Email; $this->inv['errorEmail'] = $errorEmail;
		$this->inv['Phone'] = $Phone; $this->inv['errorPhone'] = $errorPhone;
		$this->inv['Website'] = $Website; $this->inv['errorWebsite'] = $errorWebsite;
		$this->inv['Note'] = $Note; $this->inv['errorNote'] = $errorNote;
		$this->inv['Message'] = $Message;

		return $this->_showviewfront(['sellerpartners']);
	}
}