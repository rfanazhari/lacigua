<?php

namespace App\Modules\api\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class insertController extends Controller
{
    // $this->_debugvar();
    public function index()
    {
        $request = \Request::instance()->request->all();
        $requestfile = \Request::file();

        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'Subscribe' :
                    $Email = $Subscribe = '';

                    if(isset($request['Email'])) $Email = $request['Email'];
                    else $Email = '';
                    if(empty($Email)) {
                        $data['error'][] = 'Please enter your email';
                    }

                    if(isset($request['Subscribe'])) $Subscribe = $request['Subscribe'];
                    else $Subscribe = '';
                    if(empty($Subscribe)) {
                        $data['error'][] = 'Please contact admin';
                    }

                    if(isset($data['error'])) $return = 'Not OK';
                    else {
                        $this->_loaddbclass([ 'Customer' ]);

                        $Customer = $this->Customer->where([['Email','=',$Email]])->first();

                        if(!$Customer) {
                            $LastCustomer = $this->_dbgetlastrow('customer', 'CustomerUniqueID');

                            if($LastCustomer) {
                                $LastCustomer = substr($LastCustomer, -2);
                                $LastCustomer = sprintf('%02d', $LastCustomer + 1);
                            } else $LastCustomer = sprintf('%02d', 1);

                            $CustomerUniqueID = 'LG' . date('ymdhis') . sprintf('%02d', $LastCustomer);
                            
                            $password = uniqid();
                            $array = array(
                                'CustomerUniqueID' => $CustomerUniqueID,
                                'Password' => \Hash::make($password),
                                'Username' => $Email,
                                'Email' => $Email,
                            );

                            $array['IsSubscribeMen'] = 0;
                            $array['IsSubscribeWomen'] = 0;

                            if($Subscribe == 'MEN') {
                                $array['IsSubscribeMen'] = 1;
                            } else {
                                $array['IsSubscribeWomen'] = 1;
                            }

                            $array['IsActive'] = 0;
                            $array['Status'] = 0;
                            $array['CreatedDate'] = new \DateTime("now");
                            
                            $Customer = $this->Customer->creates($array);

                            $this->_loaddbclass([ 'SendEmail' ]);

                            $this->SendEmail->creates([
                                'MailTo' => $Email,
                                'MailToName' => $Email,
                                'Subject' => 'Activate Your Account - Lacigue',
                                'Body' => '<html>
    <body>
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="font-family: \'Roboto\'; margin: 0 auto; border: 1px solid #ededed;
            padding: 10px;">
            <tr>
                <td style="height: 50px; background: url('.$this->inv['basesite'].'assets/frontend/images/material/top_bar.png) repeat-x; color: white; font-size: 18px;" align="center">
                    Welcome '.$Email.' !
                </td>
            </tr>
            <tr>
                <td align="center" style="font-size: 17px;"><br/>Hello <b>'.$Email.'</b> !</td>
            </tr>
            <tr>
                <td align="center"><br/>
                    System is automatically create your account.<br/><br/>
                    
                    Please activate your account !<br/><br/>
<table>
    <tr>
        <td style="background-color: #848484;border-color: #6D6D6D;border: 1px solid #6D6D6D;padding: 7px;text-align: center;">
            <a style="display: block;color: #ffffff;font-size: 11px;text-decoration: none;text-transform: uppercase;" href="'.$this->inv['basesite'].'activate/code_'.encrypt($CustomerUniqueID).'">
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
                                'Type' => 'REGISTER',
                                'DescriptionType' => 'Subscribe Customer',
                                'MailFrom' => $this->inv['config']['email']['smtp_user'],
                                'MailFromName' => 'no-reply@lacigue.com',
                                'FromSource' => 'Bottom Subscribe',
                            ]);
                        } else {
                            if($Subscribe == 'MEN') {
                                $array['IsSubscribeMen'] = 1;
                            } else {
                                $array['IsSubscribeWomen'] = 1;
                            }

                            $Customer->update($array);
                        }

                        $return = 'OK';
                        $data = '';
                    }

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'ReportItem' :
                    $ProductID = $Reason = $Detail = '';

                    if(isset($request['ProductID'])) $ProductID = $request['ProductID'];
                    else $ProductID = '';
                    if(empty($ProductID)) {
                        $data['error'][] = 'Please contact admin';
                    }

                    if(isset($request['Reason'])) $Reason = $request['Reason'];
                    else $Reason = '';
                    if(empty($Reason)) {
                        $data['error'][] = 'Please contact admin';
                    }

                    if(isset($request['Detail'])) $Detail = $request['Detail'];
                    else $Detail = '';
                    if(empty($Detail)) {
                        $data['error'][] = 'Please contact admin';
                    }

                    if(isset($data['error'])) $return = 'Not OK';
                    else {
                        $this->_loaddbclass(['ProductReport']);

                        $this->ProductReport->creates([
                            'ProductID' => $ProductID,
                            'Reason' => $Reason,
                            'Detail' => $Detail,
                            'CreatedDate' => new \DateTime('now')
                        ]);

                        $return = 'OK';
                        $data = '';
                    }

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
                case 'ApplyPosition' :
                    $PositionID = $CVFile = $errorCVFile = $CVFilefiletype = $PortfolioFile = $errorPortfolioFile = $PortfolioFilefiletype = $Note = $errorNote = '';
                    $pathfile = '/resources/assets/backend/file/cvportfolio/';

                    if(isset($request['PositionID'])) $PositionID = $request['PositionID'];
                    else $PositionID = '';
                    if(empty($PositionID)) {
                        $data['error'][] = 'Please contact admin';
                    }

                    if(isset($requestfile['CVFile'])) $CVFile = $requestfile['CVFile'];
                    else $CVFile = '';
                    if(empty($CVFile)) {
                        $errorCVFile = $this->_trans('validation.mandatory', 
                            ['value' => 'Upload CV']
                        );
                    }
                    if($CVFile && !$this->_checkfile($CVFile, $CVFilefiletype)) {
                        $errorCVFile = $this->_trans('validation.format', 
                            ['value' => 'Upload CV', 'format' => 'Document File']
                        );
                    }

                    if(isset($requestfile['PortfolioFile'])) $PortfolioFile = $requestfile['PortfolioFile'];
                    else $PortfolioFile = '';
                    if(empty($PortfolioFile)) {
                        $errorPortfolioFile = $this->_trans('validation.mandatory', 
                            ['value' => 'Upload Portofolio']
                        );
                    }
                    if($PortfolioFile && !$this->_checkfile($PortfolioFile, $PortfolioFilefiletype)) {
                        $errorPortfolioFile = $this->_trans('validation.format', 
                            ['value' => 'Upload Portofolio', 'format' => 'Document File']
                        );
                    }

                    if(isset($request['Note'])) $Note = $request['Note'];
                    else $Note = '';
                    if(empty($Note)) {
                        $errorNote = $this->_trans('validation.mandatory', 
                            ['value' => 'Catatan']
                        );
                    }

            		if(!$errorCVFile && !$errorPortfolioFile && !$errorNote) {
                        $this->_loaddbclass(['CareerApply']);

                        $array = array(
                            'ID' => $this->SellerID,
                            'CareerID' => $PositionID,
                            'Note' => $Note,
                            'CreatedDate' => new \DateTime("now")
                        );

                        $CareerApply = $this->CareerApply->creates($array);
                        
                        if($CVFile) {
                            $FileName = 'CVFile_'.$CareerApply['ID'].$CVFilefiletype;
                            $array['CVFile'] = $FileName;
                            $CareerApply->update($array);
                            $this->_filetofolder($CVFile, base_path().$pathfile, $FileName);
                        }

                        if($PortfolioFile) {
                            $FileName = 'Portfolio_'.$CareerApply['ID'].$PortfolioFilefiletype;
                            $array['PortfolioFile'] = $FileName;
                            $CareerApply->update($array);
                            $this->_filetofolder($PortfolioFile, base_path().$pathfile, $FileName);
                        }

                        $return = 'OK';
                        $data = '';
                    } else {
                        if(!isset($data['error'])) {
                            if($errorCVFile) $data['error'][] = $errorCVFile;
                            if($errorPortfolioFile) $data['error'][] = $errorPortfolioFile;
                            if($errorNote) $data['error'][] = $errorNote;
                        }
                    }

                    if(isset($data['error'])) $return = 'Not OK';

                    die(json_encode(['response' => $return, 'data' => $data], JSON_FORCE_OBJECT));
                break;
            }
        } else die(json_encode(['response' => 'error'], JSON_FORCE_OBJECT));
    }
}
