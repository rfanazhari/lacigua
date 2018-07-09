<?php

namespace App\Modules\dashboard\Http\Controllers\managefaq;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class faqController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => true,
        'refresh'   => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'FaqID',
        'Name' => 'Name',
        'Image' => 'Image',
        'IsActive' => 'IsActive',
        'Status' => 'Status',
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
        'FaqID' => ['Faq ID'],
        'Name' => ['Name', true],
        'Image' => ['Image', true, '', 'image'],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'permalink' => ['permalink'],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/faq/';
    var $objectkey = '', $FaqID = '', $errorFaqID = '', $Name = '', $errorName = '', $Image = '', $errorImage = '', $Imagefiletype = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                $id = $request['value'];

                $this->_loaddbclass([ 'Faq' ]);

                $Faq = $this->Faq->where([['ID','=',$id]])->first();

                if($Faq) {
                    $IsActive = 1;
                    if($Faq->IsActive == 1) $IsActive = 0;
                    $array[$this->inv['flip']['IsActive']] = $IsActive;
                    $Faq->update($array);

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
    
    public function edit()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->getdata();
    }

    private function getdata() {
        if (isset($this->inv['getid'])) {
            if(!$this->_checkpermalink($this->inv['getid'])) {
                $this->_loaddbclass([ 'Faq' ]);

                $Faq = $this->Faq->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Faq) {
                    $this->FaqID = $Faq[$this->inv['flip']['FaqID']];
                    $this->Name = $Faq[$this->inv['flip']['Name']];

                    if ($Faq[$this->inv['flip']['Image']]) {
                        $this->Image = $this->inv['basesite'] . str_replace('/resources/', '', $this->pathimage) . $Faq[$this->inv['flip']['Image']];
                    }

                    $this->IsActive = $Faq[$this->inv['flip']['IsActive']];
                    $this->Status = $Faq[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Faq[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Faq[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Faq[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Faq[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $Faq[$this->inv['flip']['permalink']];
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
            $this->_loaddbclass([ 'Faq' ]);

            if(isset($request['edit'])) {
                $Faq = $this->Faq->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Faq) {
                    $this->_redirect('404');
                }
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managefaq.Faq.Name')]
                );
            }

            if(isset($requestfile['Image'])) $this->Image = $requestfile['Image'];
            else $this->Image = '';
            if(empty($this->Image) && !(isset($request['edit']) && $Faq[$this->inv['flip']['Image']])) {
                $this->errorImage = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managefaq.Faq.Image')]
                );
            }
            if($this->Image && !$this->_checkimage($this->Image, $this->Imagefiletype)) {
                $this->errorImage = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.managefaq.Faq.Image')]
                );
            }

            if(!$this->inv['messageerror'] && !$this->errorFaqID && !$this->errorName && !$this->errorImage && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {

                $array = array(
                    $this->inv['flip']['FaqID'] => $this->FaqID,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['permalink'] => $this->_permalink($this->Name),
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $Faq = $this->Faq->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Faq = $this->Faq->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Faq->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }


                if ($this->Image) {
                    $imagename = 'faq_' . $Faq[$this->inv['flip']['FaqID']] . $this->Imagefiletype;
                    $array[$this->inv['flip']['Image']] = $imagename;
                    $Faq->update($array);
                    list($width, $height) = getimagesize($this->Image->GetPathName());

                    $this->_imagetofolder($this->Image, base_path() . $this->pathimage, $imagename, $width, $height);
                    $this->_imagetofolder($this->Image, base_path() . $this->pathimage, 'medium_' . $imagename, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Image, base_path() . $this->pathimage, 'small_' . $imagename, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['FaqID'] = $this->FaqID; $this->inv['errorFaqID'] = $this->errorFaqID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['Image'] = $this->Image; $this->inv['errorImage'] = $this->errorImage;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass(['Faq']);

            foreach($this->inv['delete'] as $val) {
                $Faq = $this->Faq->where([[$this->objectkey,'=',$val]])->first();
                if($Faq) {
                    $this->Name = $Faq[$this->inv['flip']['Name']];
                    
                    if ($Faq->Image) {
                        @unlink(base_path() . $this->pathimage . $Faq->Image);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $Faq->Image);
                        @unlink(base_path() . $this->pathimage . 'small_' . $Faq->Image);
                    }

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['permalink']] = '';

                    $Faq->update($array);

                    $br = "";
                    if(end($this->inv['delete']) != $val) $br = "<br/>";

                    $this->_dblog('delete', $this, $this->Name);
                    $this->inv['messagesuccess'] .= "Delete $this->Name Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'Faq' ]);

        $result = $this->Faq->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                if ($result['data'][$i][$this->inv['flip']['Image']]) {
                    $result['data'][$i][$this->inv['flip']['Image']] =
                    $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) . $result['data'][$i][$this->inv['flip']['Image']];
                }

                $checkactive = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $checkactive = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['FaqID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$checkactive.' rel="Anda yakin ingin merubah status ?">';
            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}