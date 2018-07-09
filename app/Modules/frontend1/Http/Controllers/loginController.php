<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class loginController extends Controller
{
	public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'lemail' => ['Email'],
        'lpassword' => ['Password'],
        'lremember' => ['Remember'],
        'rfirstname' => ['Nama Depan'],
        'rlastname' => ['Nama Belakang'],
        'rgender' => ['Jenis Kelamin'],
        'rphone' => ['Telepon'],
        'remail' => ['Email'],
        'rpassword' => ['Password'],
        'rrepassword' => ['Re-Password'],
        'rremember' => ['Remember'],
        'rsubscribe' => ['Subscriber'],
        'info' => ['Info'],
    ];

    public function ajaxpost()
    {
        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'ForgotPass' :
                    $Email = $request['Email'];

                    $this->_loaddbclass([ 'Customer' ]);

                    $Customer = $this->Customer->where([['Email', '=', $Email]])->first();

                    if($Customer) {
                        $this->_loaddbclass([ 'SendEmail' ]);

                        $FullName = $Customer->FullName;
                        if(!$FullName) $FullName = $Customer->Email;

                        $randompass = uniqid();

                        $this->SendEmail->creates([
                            'MailTo' => $Customer->Email,
                            'MailToName' => $FullName,
                            'Subject' => 'Forgot Password - Lacigue',
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
                        <td align="center" style="font-size: 17px;"><br/>Hello <b>'.$FullName.'</b> !</td>
                    </tr>
                    <tr>
                        <td align="center"><br/>
                            System is automatically reset your password.<br/><br/>
                    
                            Your email is <b>'.$Customer->Email.'</b><br/>
                            Your new password is <b>'.$randompass.'</b><br/><br/>
                            
                            Please update your password in Profile !<br/><br/>

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
                            'Type' => 'FORGET',
                            'DescriptionType' => 'Register Customer',
                            'MailFrom' => $this->inv['config']['email']['smtp_user'],
                            'MailFromName' => 'no-reply@lacigue.com',
                            'FromSource' => 'Register Page',
                        ]);

                        $Customer->update(['Password' => \Hash::make($randompass)]);

                        die(json_encode(['response' => 'OK'], JSON_FORCE_OBJECT));
                    } else {
                        die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                    }
                break;
            }
        }
    }

	public function index()
	{
		$this->_geturi();

		if(\Session::get('customerdata')) return $this->_redirect($this->inv['basesite']);

		$lemail = $lpassword = $lremember = $login = '';
		$rfirstname = $rlastname = $rgender = $rphone = $remail = $rpassword = $rrepassword = $rremember = $rsubscribe = '';
		$lerrormessage = $rerrormessage = [];

        $request = \Request::instance()->request->all();

        $this->_loaddbclass([ 'Customer' ]);

        if(isset($request['login'])) {
        	$lemail = $request['lemail'];
        	if(empty($lemail)) {
                $lerrormessage = array_merge($lerrormessage, [
                	'lemail' => $this->_trans('validation.mandatory', 
	                    ['value' => $this->_trans('frontend.login.lemail')]
	                )
	            ]);
            }

            $lpassword = $request['lpassword'];
            if(empty($lpassword)) {
                $lerrormessage = array_merge($lerrormessage, [
                	'lpassword' => $this->_trans('validation.mandatory', 
	                    ['value' => $this->_trans('frontend.login.lpassword')]
	                )
	            ]);
            }
            
            if(isset($request['lremember']))
                $lremember = $request['lremember'];

            if(!$lerrormessage) {
                $Customer = $this->Customer->where([['UserName','=',$lemail],['Status','=',0]])->orwhere([['Email','=',$lemail],['Status','=',0]])->first();

                if($Customer) {
                    if(\Hash::check($lpassword, $Customer->Password)) {
                        if($Customer->IsActive == 1) {
                            $customerdata = array(
                                'ccustomerid' => $Customer->ID,
                                'ccustomeruniqueid' => $Customer->CustomerUniqueID,
                                'ccustomerusername' => $Customer->UserName,
                                'ccustomeremail' => $Customer->Email,
                                'ccustomername' => $Customer->FullName,
                                'ccustomer' => $Customer->permalink,
                            );

                            $array['LastLogin'] = new \DateTime("now");
                            $Customer->update($array);
                            
                            $cookie = null;

                            \Session::put('customerdata', $customerdata);

                            $oneday = 60 * 24;
                            $onemonth = $oneday * 30;
                            $oneyear = $onemonth * 12;

                            $minute = $oneyear * 5;
                            
                            if($lremember) return \Redirect::to('account')->withCookie('customerdata', $customerdata, $minute);
                            else return \Redirect::to('account');
                        } else {
                            $lerrormessage = array_merge($lerrormessage, [
                                'info' => $this->_trans('backend.login.errornotactive')
                            ]);
                        }
                    } else {
                        $lerrormessage = array_merge($lerrormessage, [
                            'info' => str_replace('Username', 'Email', $this->_trans('backend.login.errorinvalid'))
                        ]);
                    }
                } else {
                    $lerrormessage = array_merge($lerrormessage, [
                        'info' => str_replace('Username', 'Email', $this->_trans('backend.login.errorinvalid'))
                    ]);
                }
            }
        }

        if(isset($request['register'])) {
        	$rfirstname = $request['rfirstname'];
        	if(empty($rfirstname)) {
                $rerrormessage = array_merge($rerrormessage, [
                	'rfirstname' => $this->_trans('validation.mandatory', 
	                    ['value' => $this->_trans('frontend.login.rfirstname')]
	                )
	            ]);
            }

            $rlastname = $request['rlastname'];
            if(empty($rlastname)) {
                $rerrormessage = array_merge($rerrormessage, [
                	'rlastname' => $this->_trans('validation.mandatory', 
	                    ['value' => $this->_trans('frontend.login.rlastname')]
	                )
	            ]);
            }

            $Customer = $this->Customer->where([['permalink','=',$this->_permalink($rfirstname.' '.$rlastname)]])->first();
            if($Customer) {
            	$rerrormessage = array_merge($rerrormessage, [
                	'rlastname' => $this->_trans('validation.already', 
	                    ['value' => $this->_trans('frontend.login.rfirstname').' '.$this->_trans('frontend.login.rlastname')]
	                )
	            ]);
	        }

            $rgender = $request['rgender'];
            if(!is_numeric($rgender)) {
                $rerrormessage = array_merge($rerrormessage, [
                    'rgender' => $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('frontend.login.rgender')]
                    )
                ]);
            }

            $rphone = $request['rphone'];
            if(empty($rphone)) {
                $rerrormessage = array_merge($rerrormessage, [
                	'rphone' => $this->_trans('validation.mandatory', 
	                    ['value' => $this->_trans('frontend.login.rphone')]
	                )
	            ]);
            }

            $remail = $request['remail'];
            if(empty($remail)) {
                $rerrormessage = array_merge($rerrormessage, [
                	'remail' => $this->_trans('validation.mandatory', 
	                    ['value' => $this->_trans('frontend.login.remail')]
	                )
	            ]);
            }

            $Customer = $this->Customer->where([['Email','=',$remail]])->first();
            if($Customer) {
            	$rerrormessage = array_merge($rerrormessage, [
                	'remail' => $this->_trans('validation.already', 
	                    ['value' => $this->_trans('frontend.login.remail')]
	                )
	            ]);
	        }

            $rpassword = $request['rpassword'];
            if(empty($rpassword)) {
                $rerrormessage = array_merge($rerrormessage, [
                	'rpassword' => $this->_trans('validation.mandatory', 
	                    ['value' => $this->_trans('frontend.login.rpassword')]
	                )
	            ]);
            }

            $rrepassword = $request['rrepassword'];
            if(empty($rrepassword)) {
                $rerrormessage = array_merge($rerrormessage, [
                	'rrepassword' => $this->_trans('validation.mandatory', 
	                    ['value' => $this->_trans('frontend.login.rrepassword')]
	                )
	            ]);
            }

            if($rpassword && $rrepassword) {
	        	if($rpassword != $rrepassword) {
	        		$rerrormessage = array_merge($rerrormessage, [
	                	'rrepassword' => $this->_trans('validation.notsame', 
		                    ['value' => $this->_trans('frontend.login.rrepassword')]
		                )
		            ]);
	        	}
	        }

            if(isset($request['rremember']))
                $rremember = $request['rremember'];
            if(isset($request['rsubscribe']))
                $rsubscribe = $request['rsubscribe'];

            if(!$rerrormessage) {
            	$LastCustomer = $this->_dbgetlastrow('customer', 'CustomerUniqueID');

	    		if($LastCustomer) {
	    			$LastCustomer = substr($LastCustomer, -2);
	    			$LastCustomer = sprintf('%02d', $LastCustomer + 1);
	    		} else $LastCustomer = sprintf('%02d', 1);

	    		$CustomerUniqueID = 'LG' . date('ymdhis') . sprintf('%02d', $LastCustomer);

	        	$array = array(
	                'CustomerUniqueID' => $CustomerUniqueID,
	                'Password' => \Hash::make($rpassword),
	                'FirstName' => $rfirstname,
	                'LastName' => $rlastname,
	                'FullName' => $rfirstname.' '.$rlastname,
	                'Username' => $remail,
                    'Gender' => $rgender,
	                'Email' => $remail,
                    'Mobile' => $rphone,
	                'CustomerShareLink' => strtoupper(uniqid()),
	                'permalink' => $this->_permalink($rfirstname.' '.$rlastname),
	            );

	            $array['IsActive'] = 1;
                $array['Status'] = 0;
                $array['CreatedDate'] = new \DateTime("now");
            	
                if($rsubscribe != '') {
                    if($rgender == 0) {
                        $array['IsSubscribeWomen'] = 1;
                    } else {
                        $array['IsSubscribeMen'] = 1;
                    }
                } else {
                    $array['IsSubscribeMen'] = 0;
                    $array['IsSubscribeWomen'] = 0;
                }
                
                if(\Session::get('ReferralCustomerID')) {
                    $array['ReferralCustomerID'] = \Session::get('ReferralCustomerID');
                    \Session::forget('ReferralCustomerID');
                }

            	$Customer = $this->Customer->creates($array);

                if($Customer->ReferralCustomerID) {
                    $tmpCustomer = $this->Customer->where([['ID','=',$Customer->ReferralCustomerID]])->first();
                    if($tmpCustomer) {
                        $tmpCustomer->update(['CountReferral' => $tmpCustomer->CountReferral + 1]);
                    }
                }

            	$this->_loaddbclass([ 'SendEmail' ]);

                $this->SendEmail->creates([
                    'MailTo' => $remail,
                    'MailToName' => $rfirstname.' '.$rlastname,
                    'Subject' => 'Registration - Lacigue',
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
                <td align="center" style="font-size: 17px;"><br/>Hello <b>'.$rfirstname.' '.$rlastname.'</b> !</td>
            </tr>
            <tr>
                <td align="center"><br/>
                    Welcome to Lacigue!<br/>
                    Thanks for registering.<br/><br/>

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
                    'Type' => 'REGISTER',
                    'DescriptionType' => 'Register Customer',
                    'MailFrom' => $this->inv['config']['email']['smtp_user'],
                    'MailFromName' => 'no-reply@lacigue.com',
                    'FromSource' => 'Register Page',
                ]);

                foreach ($request as $key => $value) {
                    $$key = '';
                }

                $customerdata = array(
                    'ccustomerid' => $Customer->ID,
                    'ccustomeruniqueid' => $Customer->CustomerUniqueID,
                    'ccustomerusername' => $Customer->UserName,
                    'ccustomeremail' => $Customer->Email,
                    'ccustomername' => $Customer->FullName,
                    'ccustomer' => $Customer->permalink,
                );

                $array['LastLogin'] = new \DateTime("now");
                $Customer->update($array);
                
                $cookie = null;

                \Session::put('customerdata', $customerdata);

                $oneday = 60 * 24;
                $onemonth = $oneday * 30;
                $oneyear = $onemonth * 12;

                $minute = $oneyear * 5;
                
                if($rremember) return \Redirect::to('account')->withCookie('customerdata', $customerdata, $minute);
                else return \Redirect::to('account');
            }
        }

		$this->inv['lemail'] = $lemail;
		$this->inv['lpassword'] = $lpassword;
		$this->inv['lremember'] = $lremember;
		$this->inv['lerrormessage'] = $lerrormessage;

		$this->inv['rfirstname'] = $rfirstname;
		$this->inv['rlastname'] = $rlastname;
        if($rgender == '') $rgender = 1;
        $this->inv['rgender'] = $rgender;
		$this->inv['rphone'] = $rphone;
		$this->inv['remail'] = $remail;
		$this->inv['rpassword'] = $rpassword;
		$this->inv['rrepassword'] = $rrepassword;
		$this->inv['rremember'] = $rremember;
		$this->inv['rsubscribe'] = $rsubscribe;
		$this->inv['rerrormessage'] = $rerrormessage;

		return $this->_showviewfront(['login']);
	}
}