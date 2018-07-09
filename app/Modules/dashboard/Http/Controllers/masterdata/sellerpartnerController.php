<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class sellerpartnerController extends Controller
{
    // Set header active
    public $header = [
        'menus'   => true, // True is show menu and false is not show.
        'check'   => true, // Active all header function. If all true and this check false then header not show.
        'search'  => true,
        'addnew'  => false,
        'refresh' => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'SellerPartnerID',
        'CompanyName' => 'CompanyName',
        'FullName' => 'FullName',
        'Email' => 'Email',
        'Phone' => 'Phone',
        'Website' => 'Website',
        'Note' => 'Note',
        'CreatedDate' => 'CreatedDate',
        'Approve' => 'Approve',
        'SendEmail' => 'SendEmail',
        'idfunction' => 'ID',
    ];

    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'           => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'SellerPartnerID' => ['Seller Partner ID'],
        'CompanyName' => ['Company Name', true],
        'FullName' => ['Full Name', true],
        'Email' => ['Email', true],
        'Phone' => ['Phone', true],
        'Website' => ['Website'],
        'Note' => ['Note'],
        'CreatedDate' => ['Created Date', true],
        'Approve' => ['Approve', true],
        'SendEmail' => ['Send Email', true],
    ];

    var $objectkey = '', $SellerPartnerID = '', $errorSellerPartnerID = '', $CompanyName = '', $errorCompanyName = '', $FullName = '', $errorFullName = '', $Email = '', $errorEmail = '', $Phone = '', $errorPhone = '', $Website = '', $errorWebsite = '', $Note = '', $errorNote = '', $CreatedDate = '', $errorCreatedDate = '', $Approve = '', $errorApprove = '', $SendEmail = '', $errorSendEmail = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) exit;

        $request = \Request::instance()->request->all();
        if (isset($request['ajaxpost'])) {
            $id = $request['value'];
            $this->_loaddbclass(['SellerPartner']);
            $SellerPartner = $this->SellerPartner->where([['ID', '=', $id]])->first();
            switch ($request['ajaxpost']) {
                case 'setapprove':
                    if ($SellerPartner) {
                        $Approve = 1;
                        if ($SellerPartner->Approve == 1) $Approve = 0;

                        $array[$this->inv['flip']['Approve']] = $Approve;
                        $SellerPartner->update($array);

                        if($SellerPartner->Approve == 1) {
                            $this->_loaddbclass(['Seller']);

                            $lastincrement = $this->_dbgetlastincrement(env('DB_DATABASE'), 'seller');
                            $lastincrement = 'LS'.date("ymd").sprintf('%03d', $lastincrement);

                            $userdata =  \Session::get('userdata');
                            $userid =  $userdata['uuserid'];

                            $array = array(
                                'SellerUniqueID' => $lastincrement,
                                'CompanyName' => $SellerPartner->CompanyName,
                                'FullName' => $SellerPartner->FullName,
                                'Email' => $SellerPartner->Email,
                                'Phone' => $SellerPartner->Phone,
                                'Website' => $SellerPartner->Website,
                                'SellerPartnerID' => $SellerPartner->ID,
                                'IsActive' => 0,
                                'Status' => 0,
                                'CreatedDate' => new \DateTime("now"),
                                'CreatedBy' => $userid,
                                'permalink' => $this->_permalink($SellerPartner->FullName),
                            );

                            $Seller = $this->Seller->creates($array);

                            $this->_dblog('addnew', $this, $SellerPartner->FullName);
                            \Session::put('messagesuccess', "Saving $SellerPartner->FullName Completed !");

                            $datapost['ajaxpost'] = 'addnew';
                            $datapost['groupname'] = 'Seller '.$SellerPartner->FullName;

                            $datapost['optmenu'] = $this->inv['config']['sellermenu'];

                            $idGroup = $this->_curlpost($this->inv['basesite'].$this->inv['config']['backend']['aliaspage'].'dashboard/userteam/usergroup/ajaxpost', $datapost);

                            $Seller->update(['idGroup' => $idGroup]);
                        }

                        die('OK');
                    } else die('Error');
                break;
                case 'sendemail':
                    if ($SellerPartner) {
                        $this->_loaddbclass(['Seller', 'MasterUser']);
                        
                        $Seller = $this->Seller->where([['SellerPartnerID', '=', $id]])->first();

                        if($Seller) {
                            $MasterUser = $this->MasterUser->where([['idGroup', '=', $Seller->idGroup]])->first();

                            if($MasterUser) {
                                if(isset($request['Password'])) {
                                    if(\Hash::check($request['Password'], $MasterUser->pass)) {
                                        $this->_loaddbclass([ 'SendEmail' ]);

                                        $this->SendEmail->creates([
                                            'MailTo' => $Seller->Email,
                                            'MailToName' => $Seller->FullName,
                                            'Subject' => 'Seller Activation - Lacigue',
                                            'Body' => '<html>
    <body>
        <table width="90%" border="0" cellspacing="0" cellpadding="0" style="font-family: \'Roboto\'; margin: 0 auto; border: 1px solid #ededed;
            padding: 10px;">
            <tr>
                <td style="height: 50px; background: url('.$this->inv['basesite'].'assets/frontend/images/material/top_bar.png) repeat-x; color: white; font-size: 18px;" align="center">
                    Lacigue Seller Activation
                </td>
            </tr>
            <tr>
                <td align="center" style="font-size: 17px;"><br/>Hello <b>'.$Seller->FullName.'</b> !</td>
            </tr>
            <tr>
                <td align="center"><br/>
                    Congratulation !<br/>
                    Your account has been active<br/><br/>
                    
                    Please LOGIN and complete your detail account.<br/><br/>

                    Your username is <b>'.$MasterUser->username.'</b><br/>
                    Your password is <b>'.$request['Password'].'</b><br/><br/>

                    <table>
                        <tr>
                            <td style="background-color: #848484;border-color: #6D6D6D;border: 1px solid #6D6D6D;padding: 7px;text-align: center;">
                                <a style="display: block;color: #ffffff;font-size: 11px;text-decoration: none;text-transform: uppercase;" href="'.$this->inv['basesite'].'admin">
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
                    <a href="'.$this->inv['basesite'].'" target="_blank" style="text-decoration: none; color: white;">LACIGUE.COM</a> &copy; 2018
                </td>
            </tr>
        </table>
    </body>
</html>',
                                            'Status' => 0,
                                            'DateTimeEntry' => new \DateTime("now"),
                                            'Type' => 'REGISTER',
                                            'DescriptionType' => 'Register Seller Activation',
                                            'MailFrom' => $this->inv['config']['email']['smtp_user'],
                                            'MailFromName' => 'no-reply@lacigue.com',
                                            'FromSource' => 'Seller Partner',
                                        ]);

                                        $SellerPartner->update(['SendEmail' => 1]);

                                        die(json_encode(['response' => 'OK'], JSON_FORCE_OBJECT));
                                    } else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                                } else die(json_encode(['response' => 'NeedPassword', 'username' => $MasterUser->username], JSON_FORCE_OBJECT));
                            } else die(json_encode(['response' => 'AddUser'], JSON_FORCE_OBJECT));
                        } else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                    } else die(json_encode(['response' => 'Not OK'], JSON_FORCE_OBJECT));
                break;
            }
        }
    }

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) return $this->_redirect($url);

        return $this->views();
    }

    public function detail()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if ($url) return $this->_redirect($url);

        return $this->getdata();
    }

    private function getdata()
    {
        if (isset($this->inv['getid'])) {
            if (!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass(['SellerPartner']);

                $SellerPartner = $this->SellerPartner->where([[$this->objectkey, '=', $this->inv['getid']]])->first();
                if ($SellerPartner) {
                    $this->SellerPartnerID = $SellerPartner[$this->inv['flip']['SellerPartnerID']];
                    $this->CompanyName = $SellerPartner[$this->inv['flip']['CompanyName']];
                    $this->FullName = $SellerPartner[$this->inv['flip']['FullName']];
                    $this->Email = $SellerPartner[$this->inv['flip']['Email']];
                    $this->Phone = $SellerPartner[$this->inv['flip']['Phone']];
                    $this->Website = $SellerPartner[$this->inv['flip']['Website']];
                    $this->Note = $SellerPartner[$this->inv['flip']['Note']];
                    $this->CreatedDate = $SellerPartner[$this->inv['flip']['CreatedDate']];
                    $this->Approve = $SellerPartner[$this->inv['flip']['Approve']];
                    $this->SendEmail = $SellerPartner[$this->inv['flip']['SendEmail']];
                } else {
                    $this->inv['messageerror'] = $this->_trans('validation.norecord');
                }
            } else {
                $this->inv['messageerror'] = $this->_trans('validation.norecord');
            }
        }

        return $this->addnewedit();
    }

    private function addnewedit()
    {
        $request     = \Request::instance()->request->all();
        $requestfile = \Request::file();

        $this->inv['SellerPartnerID'] = $this->SellerPartnerID; $this->inv['errorSellerPartnerID'] = $this->errorSellerPartnerID;
        $this->inv['CompanyName'] = $this->CompanyName; $this->inv['errorCompanyName'] = $this->errorCompanyName;
        $this->inv['FullName'] = $this->FullName; $this->inv['errorFullName'] = $this->errorFullName;
        $this->inv['Email'] = $this->Email; $this->inv['errorEmail'] = $this->errorEmail;
        $this->inv['Phone'] = $this->Phone; $this->inv['errorPhone'] = $this->errorPhone;
        $this->inv['Website'] = $this->Website; $this->inv['errorWebsite'] = $this->errorWebsite;
        $this->inv['Note'] = $this->Note; $this->inv['errorNote'] = $this->errorNote;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['Approve'] = $this->Approve; $this->inv['errorApprove'] = $this->errorApprove;
        $this->inv['SendEmail'] = $this->SendEmail; $this->inv['errorSendEmail'] = $this->errorSendEmail;

        return $this->_showview(["new"]);
    }

    private function views($views = ["defaultview", "dashboard.masterdata.sellerpartnerview"])
    {
        $this->_loaddbclass(['SellerPartner']);

        $result = $this->SellerPartner->leftjoin([
            ['seller', 'seller.SellerPartnerID', '=', 'seller_partner.ID']
        ])->selectraw('
            seller.IsActive,
            seller_partner.*
        ')->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        if (isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if (!count($result['data'])) {
            $this->inv['messageerror'] = $this->_trans('validation.norecord');
        } else {
            for ($i = 0; $i < count($result['data']); $i++) {
                $check = '';
                $checkemail = 'disabled';
                if ($result['data'][$i][$this->inv['flip']['Approve']] == 1) {
                    $checkemail = '';
                    $check = 'checked disabled';
                }

                $result['data'][$i][$this->inv['flip']['Approve']] = '<input type="checkbox" data-size="small" class="make-switch Approve ' . $result['data'][$i][$this->inv['flip']['SellerPartnerID']] . '" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" ' . $check . ' rel="' . $this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['Approve'][0].' for '.$result['data'][$i][$this->inv['flip']['FullName']]]) . '">';

                $SendEmail = 'Send';
                if($result['data'][$i][$this->inv['flip']['SendEmail']] == 1)
                    $SendEmail = 'Resend';

                if($result['data'][$i]['IsActive'] == 1)
                    $checkemail = 'disabled';

                $result['data'][$i][$this->inv['flip']['SendEmail']] = '<a class="btn btn-sm default" onclick="SendEmail(\''. $result['data'][$i][$this->inv['flip']['SellerPartnerID']] .'\')" '.$checkemail.' >
                        '.$SendEmail.' <i class="fa fa-send-o"></i>
                        </a>';

                $result['data'][$i][$this->inv['flip']['CreatedDate']] = $this->_datetimeforhtml($result['data'][$i][$this->inv['flip']['CreatedDate']], 'red');
            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}