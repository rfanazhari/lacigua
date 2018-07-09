<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class contactController extends Controller
{
	public function index()
	{
		$request = \Request::instance()->request->all();
		$error = [];
		
		$success = $fullname = $email = $mobile = $message = '';

		if(isset($request['submit'])) {
			$fullname = $request['fullname'];
			if(!$fullname) $error['fullname'] = 'error';
			$email = $request['email'];
			if(!$email) $error['email'] = 'error';
			else if($this->_email($email)) $error['email'] = 'error';
			$mobile = $request['mobile'];
			if(!$mobile) $error['mobile'] = 'error';
			$message = $request['message'];
			if(!$message) $error['message'] = 'error';

			if(!count($error)) {
				$this->_loaddbclass([ 'SendEmail' ]);

	            $this->SendEmail->creates([
	                'MailTo' => 'admin@lacigue.com',
	                'MailToName' => 'Admin Lacigue',
	                'Subject' => 'Contact From : '.$fullname,
	                'Body' => 'Contact : '.$fullname.'<br/><br/>
	                Email : '.$email.'<br/><br/>
	                Mobile : '.$mobile.'<br/><br/>
	                Message : '.$message,
	                'Status' => 0,
	                'DateTimeEntry' => new \DateTime("now"),
	                'Type' => 'ANY TYPE',
	                'DescriptionType' => 'Contact',
	                'MailFrom' => $this->inv['config']['email']['smtp_user'],
	                'MailFromName' => 'no-reply@lacigue.com',
	                'FromSource' => 'Contact Page',
	            ]);

	            $fullname = $email = $mobile = $message = '';
	            $success = 'OK';
			}
		}

		$this->inv['fullname'] = $fullname;
		$this->inv['email'] = $email;
		$this->inv['mobile'] = $mobile;
		$this->inv['message'] = $message;
		$this->inv['error'] = $error;
		$this->inv['success'] = $success;
		
		return $this->_showviewfront(['contact']);
	}
}