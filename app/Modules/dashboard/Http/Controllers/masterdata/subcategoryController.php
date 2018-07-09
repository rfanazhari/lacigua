<?php
namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class subcategoryController extends Controller
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
        'ID' => 'SubCategoryID',
        'IDCategory' => 'IDCategory',
        'ModelType' => 'ModelType',
        'NameCategory' => 'NameCategory',
        'Name' => 'Name',
        'ShowOnHeader' => 'ShowOnHeader',
        'Priority' => 'Priority',
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
        'SubCategoryID' => ['Sub Category ID'],
        'IDCategory' => ['Category ID'],
        'ModelType' => ['Model Type', true],
        'NameCategory' => ['Category Name', true],
        'Name' => ['Name', true],
        'ShowOnHeader' => ['Show On Header', true],
        'Priority' => ['Priority', true],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'permalink' => ['Permalink'],
    ];

    var $objectkey = '', $SubCategoryID = '', $errorSubCategoryID = '', $IDCategory = '', $errorIDCategory = '',$ShowOnHeader = '', $errorShowOnHeader = '', $Priority = '', $errorPriority = '', $Name = '', $errorName = '', $Status = '', $errorStatus = '', $IsActive = '', $errorIsActive = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '',$permalink = '', $errorpermalink = '';
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {

            $id = $request['value'];
            $this->_loaddbclass([ 'SubCategory' ]);
            $SubCategory = $this->SubCategory->where([['ID','=',$id]])->first();
            switch($request['ajaxpost']) {   
                case 'setactive' :
                    if($SubCategory) {
                        $IsActive = 1;
                        if($SubCategory->IsActive == 1) $IsActive = 0;
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $SubCategory->update($array);

                        die('OK');
                    } else die('Error');
                break;
                case 'setonheader' :
                    if($SubCategory) {
                        $ShowOnHeader = 1;
                        if($SubCategory->ShowOnHeader == 1) $ShowOnHeader = 0;
                        $array[$this->inv['flip']['ShowOnHeader']] = $ShowOnHeader;
                        $SubCategory->update($array);

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
                $this->_loaddbclass([ 'SubCategory' ]);


                $SubCategory = $this->SubCategory->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($SubCategory) {
                    $this->SubCategoryID = $SubCategory[$this->inv['flip']['SubCategoryID']];
                    $this->IDCategory = $SubCategory[$this->inv['flip']['IDCategory']];
                    $this->Name = $SubCategory[$this->inv['flip']['Name']];
                    $this->ShowOnHeader = $SubCategory[$this->inv['flip']['ShowOnHeader']];
                    $this->Priority = $SubCategory[$this->inv['flip']['Priority']];
                    $this->IsActive = $SubCategory[$this->inv['flip']['IsActive']];
                    $this->Status = $SubCategory[$this->inv['flip']['Status']];
                    $this->CreatedDate = $SubCategory[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $SubCategory[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $SubCategory[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $SubCategory[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $SubCategory[$this->inv['flip']['permalink']];
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
        $this->_loaddbclass([ 'Category', 'SubCategory' ]);

        if (isset($request['addnew']) || isset($request['edit'])) {

            if(isset($request['edit'])) {
                $SubCategory = $this->SubCategory->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$SubCategory) {
                    $this->_redirect('404');
                }
            }
            
            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.subcategory.Name')]
                );
            }

            $this->IDCategory = $request['IDCategory'];
            if(empty($this->IDCategory)) {

                $this->errorIDCategory = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.subcategory.IDCategory')]
                );
            }

            $this->ShowOnHeader = $request['ShowOnHeader'];
            if(!is_numeric($this->ShowOnHeader)) {
                $this->errorShowOnHeader = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.productcategory.ShowOnHeader')]
                );
            }

            $Uniq = $this->SubCategory->where([
                [$this->inv['flip']['Name'],'=',$this->Name],
                [$this->inv['flip']['IDCategory'],'=',$this->IDCategory],
                [$this->inv['flip']['Status'],'=',0],
            ])->first();

            if($Uniq) {
                if(isset($request['addnew'])) {
                    if(!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.subcategory.Name')]
                        );
                    }
                } else {
                    if ($Uniq[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.subcategory.Name')]
                            );
                        }
                    }
                }
            }

            //handling error
            if(!$this->inv['messageerror'] && !$this->errorSubCategoryID && !$this->errorIDCategory && !$this->errorName && !$this->errorStatus && !$this->errorShowOnHeader && !$this->errorPriority && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {

                $Category = $this->Category->where([['ID','=',$this->IDCategory ]])->first();
                $CategoryPermalink = $Category->permalink;
                
                $SubCategory = $this->SubCategory->where([['IDCategory','=',$this->IDCategory],['IsActive','=',1],['Status','=',0]])->orderBy('Priority','desc')->first();

                $array = array(
                    $this->inv['flip']['SubCategoryID'] => $this->SubCategoryID,
                    $this->inv['flip']['IDCategory'] => $this->IDCategory,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['ShowOnHeader'] => $this->ShowOnHeader,
                    $this->inv['flip']['Priority'] => ($SubCategory->Priority + 1),
                    $this->inv['flip']['permalink'] => $this->_permalink($CategoryPermalink.' '.$this->Name),
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    
                    $SubCategory = $this->SubCategory->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $SubCategory = $this->SubCategory->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $SubCategory->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                return $this->_redirect(get_class());
            }
        }
        
        $this->inv['arrCategory'] = $this->Category->where([['Status','=',0],['IsActive','=',1]])->orderByRaw("case ModelType when 'WOMAN' then 1 when 'MEN' then 2 when 'KIDS' then 3 END")
        ->orderBy('ModelType','DESC')->orderBy('ColumnMode','ASC')->orderBy('Priority','ASC')->get()->toArray();
        $this->inv['SubCategoryID'] = $this->SubCategoryID; $this->inv['errorSubCategoryID'] = $this->errorSubCategoryID;
        $this->inv['IDCategory'] = $this->IDCategory; $this->inv['errorIDCategory'] = $this->errorIDCategory;
        $this->inv['ShowOnHeader'] = $this->ShowOnHeader; $this->inv['errorShowOnHeader'] = $this->errorShowOnHeader;
        $this->inv['Priority'] = $this->Priority; $this->inv['errorPriority'] = $this->errorPriority;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;

        $arrShowOnHeader = [
            '1' => 'Yes',
            '0' => 'No',
        ];
        $this->inv['arrShowOnHeader'] = $arrShowOnHeader;

        return $this->_showview(["new"]);
    }

    public function priority()
    {
        $url = $this->_accessdata($this, __FUNCTION__, $this->access);
        if($url) return $this->_redirect($url);
        
        if(isset($this->inv['getset'])) {
            list($function, $id) = explode('.', $this->inv['getset']);

            $this->_loaddbclass([ 'SubCategory' ]);

            $SubCategoryOld = $this->SubCategory->where([['ID','=',$id]])->first();

            if($SubCategoryOld) {
                $IDCategory = $SubCategoryOld->IDCategory;
                $PriorityOld = $SubCategoryOld->Priority;

                if($function == 'up') {
                    $SubCategoryNew = $this->SubCategory->where([
                        ['IDCategory','=',$IDCategory],
                        ['Priority','<',$PriorityOld]
                    ])->orderBy('Priority', 'DESC');
                } else {
                    $SubCategoryNew = $this->SubCategory->where([
                        ['IDCategory','=',$IDCategory],
                        ['Priority','>',$PriorityOld]
                    ])->orderBy('Priority', 'ASC');
                }

                $SubCategoryNew = $SubCategoryNew->first();

                if($SubCategoryNew) {
                    $PriorityNew = $SubCategoryNew->Priority;

                    $array = array( 'Priority' => $PriorityOld );
                    $SubCategoryNew->update($array);
                    $array = array( 'Priority' => $PriorityNew );
                    $SubCategoryOld->update($array);
                }
            }
        }

        return $this->views();
        //return redirect(url()->current());
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['getid'])) {
            $this->_loaddbclass([ 'SubCategory' ]);

            $SubCategory = $this->SubCategory->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
            if($SubCategory) {
                $this->Name = $SubCategory[$this->inv['flip']['Name']];

                $array[$this->inv['flip']['IsActive']] = 0;
                $array[$this->inv['flip']['Status']] = 1;
                $array[$this->inv['flip']['permalink']] = '';

                $SubCategory->update($array);

                $this->_dblog('delete', $this, $this->Name);
                $this->inv['messagesuccess'] .= "Delete $this->Name Completed !";
            }
        }

        return $this->views();
    }

    private function views($views = ["dashboard.masterdata.productlistsubcategory"]) {
        $this->_loaddbclass([ 'SubCategory' ]);

        $result = $this->SubCategory->leftJoin([
            ['category','category.ID','=','sub_category.IDCategory'],
        ])->select([
            'category.Name as NameCategory',
            'category.ModelType',
            'sub_category.*'
        ])->where([['sub_category.Status','=',0]])->orderByRaw("case ModelType when 'WOMAN' then 1 when 'MEN' then 2 when 'KIDS' then 3 END")  
        ->orderBy('ModelType','DESC')->orderBy('category.ColumnMode','ASC')->orderBy('category.Priority','ASC')->orderBy('sub_category.Priority','asc');

        $this->inv['flip']['NameCategory'] = 'category.Name';
        $this->inv['flip']['ModelType'] = 'category.ModelType';
        $this->inv['flip']['Name'] = 'sub_category.Name';
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        
        $this->inv['flip']['NameCategory'] = 'NameCategory';
        $this->inv['flip']['ModelType'] = 'ModelType';
        $this->inv['flip']['Name'] = 'Name';

        $result = $result->get()->toArray();

        if(!count($result)) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            $this->inv['result']['data'] = $result;
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}