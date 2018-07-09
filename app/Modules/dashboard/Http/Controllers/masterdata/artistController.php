<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class artistController extends Controller
{

    public $model = 'Artist';
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
        'ID' => 'ArtistID',
        'Name' => 'Name',
        'Banner' => 'Banner',
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
        'ArtistID' => ['Artist ID'],
        'Name' => ['Artist Name', true],
        'Banner' => ['Banner', true],
        'IsActive' => ['IsActive', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Update Date'],
        'UpdatedBy' => ['Update By'],
        'permalink' => ['Permalink'],
    ];

    //var $pathimage = '/resources/assets/backend/images/userdetail/'; //kalau  gak ada image remark aja (buat path images)
    //var $pathArtist= '/resources/assets/frontend/image/artist/'; //kalau  gak ada image remark aja (buat path BankLogo)
    var $objectkey = '', $ArtistID = '', $errorArtistID = '', $Name = '', $errorName = '',$Banner = '', $errorBanner = '', $Status = '', $errorStatus = '',$IsActive = '', $errorIsActive = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';
    
    //var $optmenu = []; // buat transaksi, klo gak ada transaksi remark aja

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case 'setactive' :
                $id = $request['value'];

                $this->_loaddbclass([ 'Artist' ]);

                $Artist = $this->Artist->where([['ID','=',$id]])->first();

                if($Artist) {
                    $IsActive = 1;
                    if($Artist->IsActive == 1) $IsActive = 0;
                    $array[$this->inv['flip']['IsActive']] = $IsActive;
                    $Artist->update($array);

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
                $this->_loaddbclass([ $this->model ]);

                $Artist = $this->Artist->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Artist) {
                    $this->ArtistID = $Artist[$this->inv['flip']['ArtistID']];
                    $this->Name = $Artist[$this->inv['flip']['Name']];
                    $this->Banner = $Artist[$this->inv['flip']['Banner']];
                    $this->IsActive = $Artist[$this->inv['flip']['IsActive']];
                    $this->Status = $Artist[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Artist[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Artist[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Artist[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Artist[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $Artist[$this->inv['flip']['permalink']];

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
                $Artist = $this->Artist->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Artist) {
                    $this->_redirect('404');
                }
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Artist.Name')]
                );
            }

            $this->Banner = $request['Banner'];
            if(empty($this->Banner)) {
                $this->errorBanner = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Artist.Banner')]
                );
            }

            //handling error
            if(!$this->inv['messageerror'] && !$this->errorArtistID && !$this->errorName && !$this->errorBanner && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {

                $array = array(
                    $this->inv['flip']['ArtistID'] => $this->ArtistID,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['Banner'] => $this->Banner,
                    $this->inv['flip']['IsActive'] => $this->IsActive,
                    $this->inv['flip']['Status'] => $this->Status,
                    $this->inv['flip']['CreatedDate'] => $this->CreatedDate,
                    $this->inv['flip']['CreatedBy'] => $this->CreatedBy,
                    $this->inv['flip']['UpdatedDate'] => $this->UpdatedDate,
                    $this->inv['flip']['UpdatedBy'] => $this->UpdatedBy,
                    $this->inv['flip']['permalink'] => $this->_permalink($this->Name),
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $Artist = $this->Artist->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Artist = $this->Artist->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Artist->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->inv['ArtistID'] = $this->ArtistID; $this->inv['errorArtistID'] = $this->errorArtistID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['Banner'] = $this->Banner; $this->inv['errorBanner'] = $this->errorBanner;
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
            $this->_loaddbclass([$this->model]);

            foreach($this->inv['delete'] as $val) {
                $Artist = $this->Artist->where([[$this->objectkey,'=',$val]])->first();
                if($Artist) {
                    $this->Name = $Artist[$this->inv['flip']['Name']];
                    
                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['permalink']] = '';

                    $Artist->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->Name);
                    $this->inv['messagesuccess'] .= "Delete $this->Name Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ $this->model ]);

        $result = $this->Artist->where([['Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {

            for($i = 0; $i < count($result['data']); $i++) {
                $checkactive = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $checkactive = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['ArtistID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$checkactive.' rel="Anda yakin ingin merubah status ?">';
            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}