<?php
namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public $model = 'Customer';
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => false,
        'refresh'   => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'CustomerID',
        'ReferralCustomerID' => 'ReferralCustomerID',
        'CustomerUniqueID' => 'CustomerUniqueID',
        'FirstName' => 'FirstName',
        'LastName' => 'LastName',
        'FullName' => 'FullName',
        'Email' => 'Email',
        'Gender' => 'Gender',
        'Mobile' => 'Mobile',
        'Phone' => 'Phone',
        'DOB' => 'DOB',
        'Username' => 'Username',
        'Password' => 'Password',
        'DetailAddress' => 'DetailAddress',
        'IsActive' => 'IsActive',
        'Status' => 'Status',
        'LastLogin' => 'LastLogin',
        'CreatedDate' => 'CreatedDate',
        'CreatedBy' => 'CreatedBy',
        'UpdatedDate' => 'UpdatedDate',
        'UpdatedBy' => 'UpdatedBy',
        'permalink' => 'permalink',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
       'CustomerID' => ['Customer ID'],
       'ReferralCustomerID' => ['Referal Customer'],
       'CustomerUniqueID' => ['Customer Unique', true],
       'FirstName' => ['First Name'],
       'LastName' => ['Last Name'],
       'FullName' => ['Full Name', true],
       'Email' => ['Email', true],
       'Gender' => ['Gender', true],
       'Mobile' => ['Mobile', true],
       'Phone' => ['Phone'],
       'DOB' => ['DOB'],
       'Username' => ['Username', true],
       'Password' => ['Password'],
       'DetailAddress' => ['DetailAddress'],
       'IsActive' => ['IsActive'],
       'Status' => ['Status'],
       'LastLogin' => ['Last Login'],
       'CreatedDate' => ['Created Date'],
       'CreatedBy' => ['Created By'],
       'UpdatedDate' => ['Updated Date'],
       'UpdatedBy' => ['Updated By'],
       'permalink' => ['permalink'],
    ];

    var $objectkey = '', $CustomerID = '', $errorCustomerID = '', $ReferralCustomerID = '', $errorReferralCustomerID = '', $CustomerUniqueID = '', $errorCustomerUniqueID = '', $FirstName = '', $errorFirstName = '', $LastName = '', $errorLastName = '', $FullName = '', $errorFullName = '', $Email = '', $errorEmail = '', $Gender = '', $errorGender = '', $Mobile = '', $errorMobile = '', $Phone = '', $errorPhone = '', $DOB = '', $errorDOB = '', $Username = '', $errorUsername = '', $Password = '', $errorPassword = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $LastLogin = '', $errorLastLogin = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                $id = $request['value'];

                $this->_loaddbclass([ 'Customer' ]);

                $Customer = $this->Customer->where([['ID','=',$id]])->first();

                if($Customer) {
                    $IsActive = 1;
                    if($Customer->IsActive == 1) $IsActive = 0;
                    $array[$this->inv['flip']['IsActive']] = $IsActive;
                    $Customer->update($array);

                    die('OK');
                } else die('Error');
                break;
            }
        }
    }

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->views();
    }
    
    public function addnew()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->addnewedit();
    }
    
    public function detail()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->getdata();
    }

    private function getdata() {
        if (isset($this->inv['getid'])) {
            if(!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass([ $this->model, 'CustomerAddress', 'CustomerCc' ]);

                $Customer = $this->Customer->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Customer) {

                    $this->CustomerID = $Customer[$this->inv['flip']['CustomerID']];
                    $this->ReferralCustomerID = $Customer[$this->inv['flip']['ReferralCustomerID']];
                    $this->CustomerUniqueID = $Customer[$this->inv['flip']['CustomerUniqueID']];
                    $this->FirstName = $Customer[$this->inv['flip']['FirstName']];
                    $this->LastName = $Customer[$this->inv['flip']['LastName']];
                    $this->FullName = $Customer[$this->inv['flip']['FullName']];
                    $this->Email = $Customer[$this->inv['flip']['Email']];
                    $this->Gender = $Customer[$this->inv['flip']['Gender']];
                    $this->Mobile = $Customer[$this->inv['flip']['Mobile']];
                    $this->Phone = $Customer[$this->inv['flip']['Phone']];
                    $this->DOB = $Customer[$this->inv['flip']['DOB']];
                    $this->Username = $Customer[$this->inv['flip']['Username']];
                    $this->Password = $Customer[$this->inv['flip']['Password']];
                    $this->IsActive = $Customer[$this->inv['flip']['IsActive']];
                    $this->Status = $Customer[$this->inv['flip']['Status']];
                    $this->LastLogin = $Customer[$this->inv['flip']['LastLogin']];
                    $this->CreatedDate = $Customer[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Customer[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Customer[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Customer[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $Customer[$this->inv['flip']['permalink']];

                } else {
                    $this->inv['messageerror'] = $this->_trans('validation.norecord');
                }
            } else {
                $this->inv['messageerror'] = $this->_trans('validation.norecord');
            }
        }

        return $this->addnewedit();
    }

    private function addnewedit() {
        $request = \Request::instance()->request->all();
        $requestfile = \Request::file();

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([ $this->model ]);

            if(isset($request['edit'])) {
                $Customer = $this->Customer->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Customer) {
                    $this->_redirect('404');
                }
            }

            //handling error
            if(!$this->inv['messageerror'] && !$this->errorCustomerID && !$this->errorReferralCustomerID && !$this->errorCustomerUniqueID && !$this->errorFirstName && !$this->errorLastName && !$this->errorFullName && !$this->errorEmail && !$this->errorGender && !$this->errorMobile && !$this->errorPhone && !$this->errorDOB && !$this->errorUsername && !$this->errorPassword && !$this->errorIsActive && !$this->errorStatus && !$this->errorLastLogin && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {

                $array = array(

                    $this->inv['flip']['CustomerID'] => $this->CustomerID,
                    $this->inv['flip']['ReferralCustomerID'] => $this->ReferralCustomerID,
                    $this->inv['flip']['CustomerUniqueID'] => $this->CustomerUniqueID,
                    $this->inv['flip']['FirstName'] => $this->FirstName,
                    $this->inv['flip']['LastName'] => $this->LastName,
                    $this->inv['flip']['FullName'] => $this->FullName,
                    $this->inv['flip']['Email'] => $this->Email,
                    $this->inv['flip']['Gender'] => $this->Gender,
                    $this->inv['flip']['Mobile'] => $this->Mobile,
                    $this->inv['flip']['Phone'] => $this->Phone,
                    $this->inv['flip']['DOB'] => $this->_dateformysql($this->DOB),
                    $this->inv['flip']['Username'] => $this->Username,
                    $this->inv['flip']['Password'] => $this->Password,
                    $this->inv['flip']['IsActive'] => $this->IsActive,
                    $this->inv['flip']['Status'] => $this->Status,
                    $this->inv['flip']['LastLogin'] => $this->LastLogin,
                    $this->inv['flip']['CreatedDate'] => $this->CreatedDate,
                    $this->inv['flip']['CreatedBy'] => $this->CreatedBy,
                    $this->inv['flip']['UpdatedDate'] => $this->UpdatedDate,
                    $this->inv['flip']['UpdatedBy'] => $this->UpdatedBy,
                    $this->inv['flip']['permalink'] => $this->_permalink($this->FullName),
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {

                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $Customer = $this->Customer->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->CustomerName);
                    \Session::put('messagesuccess', "Saving $this->CustomerName Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Customer = $this->Customer->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Customer->update($array);
                    
                    $this->_dblog('edit', $this, $this->CustomerName);
                    \Session::put('messagesuccess', "Update $this->CustomerName Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        if($this->ReferralCustomerID){
            $Referal = $this->Customer->where([[$this->inv['flip']['ReferralCustomerID'],'=',$this->ReferralCustomerID]])->first();
             $this->inv['Referal'] = $Referal->FullName;
        }
        else{

             $this->inv['Referal'] = '';
        }
        
        if($this->CustomerID) {
            $this->_loaddbclass([ 'CustomerAddress' ]);
            $Address = $this->CustomerAddress->leftJoin([
                ['province','province.ID','=','customer_address.ProvinceID'],
                ['city','city.ID','=','customer_address.CityID'],
                ['district','district.ID','=','customer_address.DistrictID'],
            ])->select([
                'province.Name as ProvinceName',
                'city.Name as CityName',
                'district.Name as DistrictName',
                'customer_address.*'
            ])->where([
                ['CustomerID','=',$this->CustomerID]
            ])->get()->toArray();

            $this->inv['Address'] = $Address;
        }
        
        if($this->CustomerID) {
            $this->_loaddbclass([ 'CustomerCc' ]);

            $CC = $this->CustomerCc->leftJoin([
                ['customer','customer.ID','=','customer_cc.CustomerID'],
            ])->where([
                ['CustomerID','=',$this->CustomerID]
            ])->get()->toArray();

             $this->inv['CC'] = $CC;
        }

        $this->inv['CustomerID'] = $this->CustomerID; $this->inv['errorCustomerID'] = $this->errorCustomerID;
        $this->inv['ReferralCustomerID'] = $this->ReferralCustomerID; $this->inv['errorReferralCustomerID'] = $this->errorReferralCustomerID;
        $this->inv['CustomerUniqueID'] = $this->CustomerUniqueID; $this->inv['errorCustomerUniqueID'] = $this->errorCustomerUniqueID;
        $this->inv['FirstName'] = $this->FirstName; $this->inv['errorFirstName'] = $this->errorFirstName;
        $this->inv['LastName'] = $this->LastName; $this->inv['errorLastName'] = $this->errorLastName;
        $this->inv['FullName'] = $this->FullName; $this->inv['errorFullName'] = $this->errorFullName;
        $this->inv['Email'] = $this->Email; $this->inv['errorEmail'] = $this->errorEmail;
        $this->inv['Gender'] = $this->Gender; $this->inv['errorGender'] = $this->errorGender;
        $this->inv['Mobile'] = $this->Mobile; $this->inv['errorMobile'] = $this->errorMobile;
        $this->inv['Phone'] = $this->Phone; $this->inv['errorPhone'] = $this->errorPhone;
        if(!empty($this->DOB))
        $this->inv['DOB'] = $this->_dateforhtml($this->DOB); $this->inv['errorDOB'] = $this->errorDOB;
        $this->inv['Username'] = $this->Username; $this->inv['errorUsername'] = $this->errorUsername;
        $this->inv['Password'] = $this->Password; $this->inv['errorPassword'] = $this->errorPassword;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['LastLogin'] = $this->LastLogin; $this->inv['errorLastLogin'] = $this->errorLastLogin;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;

        $this->_loaddbclass([ 'Country','Province','City' ]);
        $this->arrCountry = $this->Country->getmodel()->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrCountry'] = $this->arrCountry;

        $this->arrProvince = $this->Province->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrProvince'] = $this->arrProvince;

        $this->arrCity = $this->City->where([['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        $this->inv['arrCity'] = $this->arrCity;

        $arrGender = [
            '0' => 'Female',
            '1' => 'Male'
        ];
        $this->inv['arrGender'] = $arrGender;

        return $this->_showview(["new"]);
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ $this->model ]);

        $result = $this->Customer->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {

                $check = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $check = 'checked';
                
                $gender = '';
                if($result['data'][$i][$this->inv['flip']['Gender']] == 1) {
                    $gender = 'Female';
                } else {
                    $gender = 'Male';
                }
                $result['data'][$i][$this->inv['flip']['Gender']] = $gender;

                $referal = '';
                if(!empty($result['data'][$i][$this->inv['flip']['ReferralCustomerID']])){
                    $Referal = $this->Customer->where([[$this->inv['flip']['ReferralCustomerID'],'=',$result['data'][$i][$this->inv['flip']['CustomerID']]]])->first();
                    if(!$Referal) {
                        $referal = $Referal->FullName;
                    }
                }

                $result['data'][$i][$this->inv['flip']['ReferralCustomerID']] = $referal;

                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['CustomerID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$check.' rel="'.$this->_trans('dashboard.defaultview.buttonchangeonoff', ['value' => $this->inv['alias']['IsActive'][0]]).'">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}