<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class affiliateController extends Controller
{
	public function index()
	{
		if(!\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);
		
		$this->_loaddbclass([ 'Customer' ]);

		$CustomerData = $this->Customer->where([['ID','=',\Session::get('customerdata')['ccustomerid']]])->first();
		$this->inv['CustomerData'] = $CustomerData;

		$listemail = $errorlistemail = $messagesuccess = '';
		
		$request = \Request::instance()->request->all();

		if(isset($request['submit'])) {
			if(isset($request['listemail']) && $request['listemail']) {
				$listemail = explode(',', $request['listemail']);

				$newlistemail = [];
				foreach ($listemail as $key => $value) {
					if($this->_email(trim($value))) {
						$errorlistemail .= 'Format '.$value.' salah !<br/>';
					} else if($value == $CustomerData->Email) {
						$errorlistemail .= 'Anda tidak dapat mengundang ke email anda sendiri !<br/>';
					} else {
						$newlistemail[] = trim($value);
					}
				}

				if($errorlistemail) $errorlistemail = rtrim($errorlistemail, '<br/>');
				else {
					foreach ($newlistemail as $key => $value) {
						$this->_loaddbclass([ 'SendEmail' ]);

	                    $this->SendEmail->creates([
	                        'MailTo' => $value,
	                        'MailToName' => $value,
	                        'Subject' => 'Lacigue Invitation',
	                        'Body' => '<html>
	        <body>
	            <table width="90%" border="0" cellspacing="0" cellpadding="0" style="font-family: \'Roboto\'; margin: 0 auto; border: 1px solid #ededed;
	                padding: 10px;">
	                <tr>
	                    <td style="height: 50px; background: url('.$this->inv['basesite'].'assets/frontend/images/material/top_bar.png) repeat-x; color: white; font-size: 18px;" align="center">
	                        Lacigue Registration Account
	                    </td>
	                </tr>
	                <tr>
	                    <td align="center" style="font-size: 17px;"><br/>Hello <b>'.$value.'</b> !</td>
	                </tr>
	                <tr>
	                    <td align="center"><br/>
	                        You have invitation for cool fashion.<br/><br/>
	                
	                        Please visit and register<br/>
<table>
    <tr>
        <td style="background-color: #848484;border-color: #6D6D6D;border: 1px solid #6D6D6D;padding: 7px;text-align: center;">
            <a style="display: block;color: #ffffff;font-size: 11px;text-decoration: none;text-transform: uppercase;" href="'.$this->inv['basesite'].'reff/code_'.$CustomerData->CustomerShareLink.'">
                Click me
            </a>
        </td>
    </tr>
</table><br/>
	                        Sincerely Yours,<br/><br/>
	                        <img src="'.$this->inv['basesite'].'assets/frontend/images/material/logo.png" width="200px"><br/>
	                    <br/></td>
	                </tr>
	                <tr>
	                    <td style="height: 40px; background: url('.$this->inv['basesite'].'assets/frontend/images/material/top_bar.png) repeat-x; color: white; font-size: 13px;" align="center">
	                        <a href="'.$this->inv['basesite'].'" target="_blank" style="text-decoration: none; color: white;">LACIGUE.COM</a> &copy; '.date('Y').'
	                    </td>
	                </tr>
	            </table>
	        </body>
	    </html>',
	                        'Status' => 0,
	                        'DateTimeEntry' => new \DateTime("now"),
	                        'Type' => 'ANY TYPE',
	                        'DescriptionType' => 'Lacigue Invitation',
	                        'MailFrom' => $this->inv['config']['email']['smtp_user'],
	                        'MailFromName' => 'no-reply@lacigue.com',
	                        'FromSource' => 'Affiliate Page',
	                    ]);
					}

					$messagesuccess = 'success';
					$listemail = '';
				}

				$listemail = $request['listemail'];
			} else $errorlistemail = 'null';
		}

		$this->inv['listemail'] = $listemail;
		$this->inv['errorlistemail'] = $errorlistemail;
		$this->inv['messagesuccess'] = $messagesuccess;

		return $this->_showviewfront(['affiliate']);
	}
}