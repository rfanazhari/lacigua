<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class sizevariantController extends Controller
{
    public $model = 'SizeVariant';
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
        'ID' => 'SizeVariantID',
        'Type' => 'Type',
        'ModelType' => 'ModelType',
        'CategoryID' => 'CategoryID',
        'CategoryName' => 'CategoryName',
        'SubCategoryID' => 'SubCategoryID',
        'SubCategoryName' => 'SubCategoryName',
        'GroupSizeID' => 'GroupSizeID',
        'GroupSizeName' => 'GroupSizeName',
        'Name' => 'Name',
        'Status' => 'Status',
        'CreatedDate' => 'CreatedDate',
        'CreatedBy' => 'CreatedBy',
        'UpdatedDate' => 'UpdatedDate',
        'UpdatedBy' => 'UpdatedBy',
        'SizeLinkID' => 'SizeLinkID',
        'idfunction' => 'ID',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'SizeVariantID' => ['Size ID'],
        'Type' => ['Type', true],
        'ModelType' => ['Model Type', true],
        'CategoryID' => ['Category ID'],
        'CategoryName' => ['Category', true],
        'SubCategoryID' => ['Sub Category ID'],
        'SubCategoryName' => ['Sub Category', true],
        'GroupSizeID' => ['Group Size ID'],
        'GroupSizeName' => ['Group Size', true],
        'Name' => ['Name', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'SizeLinkID' => ['Size Link'],
    ];

    var $objectkey = '', $SizeVariantID = '', $errorSizeID = '', $Type = '', $errorType = '', $GroupSizeID = '', $errorGroupSizeID = '', $CategoryID = '', $errorCategoryID = '', $SubCategoryID = '', $errorSubCategoryID = '', $Name = '', $errorName = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $SizeLinkID = '', $errorSizeLinkID = '';
    
    public function popup()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['gettype']) && isset($this->inv['getid'])) {
            $this->inv['header']['menus'] = false;
            $this->inv['header']['addnew'] = false;
            $this->inv['alias']['IsActive'][1] = false;
            $addurl = '';
            $arraywhere = [];
            if(isset($this->inv['getgroupsizeid'])) {
                $addurl = 'groupsizeid_'.$this->inv['getgroupsizeid'].'/';
                $arraywhere = [['size_variant.GroupSizeID', '!=', $this->inv['getgroupsizeid']]];
            }
            $this->inv['extlink'] .= '/popup/'.$addurl.'id_'.$this->inv['getid'].'/type_'.$this->inv['gettype'];
            $this->inv['popuptype'] = $this->inv['gettype'];

            return $this->views(["defaultpopup"], $arraywhere);
        } else {
            return $this->_redirect('404');
        }
    }
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            $this->_loaddbclass([ 'Category', 'SubCategory' ]);
            switch($request['ajaxpost']) {
                case 'getCategory' :
                    $ModelType = $request['ModelType'];
                    if($ModelType) {
                        $Category = $this->Category->where([['ModelType','=',$ModelType]])->get()->toArray();
                        die(json_encode(['response' => 'OK','data' => $Category], JSON_FORCE_OBJECT));
                    } else die(json_encode(['response' => 'Error'], JSON_FORCE_OBJECT));
                break;
                case 'getSubCategory' :
                    $Category = $request['Category'];
                    if($Category) {
                        $SubCategory = $this->SubCategory->where([['IDCategory','=',$Category]])->get()->toArray();
                        die(json_encode(['response' => 'OK','data' => $SubCategory], JSON_FORCE_OBJECT));
                    } else die(json_encode(['response' => 'Error'], JSON_FORCE_OBJECT));
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
                
                $SizeVariant = $this->SizeVariant->leftJoin([
                    ['category','category.ID','=','size_variant.CategoryID'],
                ])->select([
                    'category.ModelType',
                    'category.Name as CategoryName',
                    'size_variant.*'
                ])->where([['size_variant.'.$this->objectkey,'=',$this->inv['getid']]])->first();

                if($SizeVariant) {
                    $this->SizeVariantID = $SizeVariant[$this->inv['flip']['SizeVariantID']];
                    $this->Type = $SizeVariant[$this->inv['flip']['Type']];
                    $this->GroupSizeID = $SizeVariant[$this->inv['flip']['GroupSizeID']];
                    $this->ModelType = $SizeVariant[$this->inv['flip']['ModelType']];
                    $this->CategoryID = $SizeVariant[$this->inv['flip']['CategoryID']];
                    $this->SubCategoryID = $SizeVariant[$this->inv['flip']['SubCategoryID']];
                    $this->Name = $SizeVariant[$this->inv['flip']['Name']];
                    $this->Status = $SizeVariant[$this->inv['flip']['Status']];
                    $this->CreatedDate = $SizeVariant[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $SizeVariant[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $SizeVariant[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $SizeVariant[$this->inv['flip']['UpdatedBy']];
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
        $this->_loaddbclass([ $this->model, 'GroupSize', 'Category', 'SubCategory' ]);

        if (isset($request['addnew']) || isset($request['edit'])) {
            if(isset($request['edit'])) {
                $SizeVariant = $this->SizeVariant->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$SizeVariant) {
                    $this->_redirect('404');
                }
            }

            $this->ModelType = $request['ModelType'];

            $this->CategoryID = $request['CategoryID'];
            if(empty($this->CategoryID)) {
                $this->errorCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.sizevariant.CategoryName')]
                );
            }

            $this->SubCategoryID = $request['SubCategoryID'];
            if(empty($this->CategoryID) && empty($this->SubCategoryID)) {
                $this->errorSubCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.sizevariant.SubCategoryName')]
                );
            }

            $SubCategory = $this->SubCategory->where([['IDCategory','=',$this->CategoryID]])->get()->count();
            if($SubCategory > 0){
                $this->SubCategoryID = $request['SubCategoryID'];
                if(empty($this->SubCategoryID)) {
                    $this->errorSubCategoryID = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.masterdata.sizevariant.SubCategoryName')]
                    );
                }    
            }

            $this->Type = $request['Type'];
            if(!is_numeric($this->Type)) {
                $this->errorType = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.sizevariant.Type')]
                );
            }

            if($this->Type == 0) {
                $this->GroupSizeID = $request['GroupSizeID'];
                if(empty($this->GroupSizeID)) {
                    $this->errorGroupSizeID = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.masterdata.sizevariant.GroupSizeID')]
                    );
                }
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.sizevariant.Name')]
                );
            }

            $Uniq = $this->SizeVariant->where([
                [$this->inv['flip']['Type'],'=',$this->Type],
                [$this->inv['flip']['GroupSizeID'],'=',$this->GroupSizeID],
                [$this->inv['flip']['ModelType'],'=',$this->ModelType],
                [$this->inv['flip']['CategoryID'],'=',$this->CategoryID],
                [$this->inv['flip']['SubCategoryID'],'=',$this->SubCategoryID],
                [$this->inv['flip']['Name'],'=',$this->Name],
            ])->first();

            if($Uniq) {
                if(isset($request['addnew'])) {
                    if(!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.SizeVariant.Name')]
                        );
                    }
                } else {
                    if ($Uniq[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.SizeVariant.Name')]
                            );
                        }
                    }
                }
            }

            if(isset($request['SizeLinkID'])) $this->SizeLinkID = $request['SizeLinkID'];

            if(!$this->inv['messageerror'] && !$this->errorSizeID && !$this->errorType && !$this->errorGroupSizeID && !$this->errorCategoryID && !$this->errorSubCategoryID && !$this->errorName && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {
                $array = array(
                    $this->inv['flip']['SizeVariantID'] => $this->SizeVariantID,
                    $this->inv['flip']['Type'] => $this->Type,
                    $this->inv['flip']['GroupSizeID'] => $this->GroupSizeID,
                    $this->inv['flip']['ModelType'] => $this->ModelType,
                    $this->inv['flip']['CategoryID'] => $this->CategoryID,
                    $this->inv['flip']['SubCategoryID'] => $this->SubCategoryID,
                    $this->inv['flip']['Name'] => $this->Name,
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    $array[$this->inv['flip']['Status']] = 0;
                    
                    $SizeVariant = $this->SizeVariant->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $SizeVariant = $this->SizeVariant->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $SizeVariant->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                $this->_loaddbclass(['SizeLink']);

                foreach($this->SizeLink->where([['SizeVariantID','=',$SizeVariant[$this->inv['flip']['SizeVariantID']]]])->get() as $obj) {
                    $obj->delete();
                }

                if(isset($request['SizeLinkID'])) {
                    $array = [];
                    foreach ($this->SizeLinkID as $key) {
                        $key = explode('-', $key);
                        $array[] = [
                            'SizeVariantID' => $SizeVariant[$this->inv['flip']['SizeVariantID']],
                            'SizeVariantIDLink' => $key[0]
                        ];
                    }

                    $this->SizeLink->inserts($array);
                }

                return $this->_redirect(get_class());
            }
        }
       
        $this->inv['SizeVariantID'] = $this->SizeVariantID; $this->inv['errorSizeID'] = $this->errorSizeID;
        $this->inv['Type'] = $this->Type; $this->inv['errorType'] = $this->errorType;
        $this->inv['GroupSizeID'] = $this->GroupSizeID; $this->inv['errorGroupSizeID'] = $this->errorGroupSizeID;
        $this->inv['CategoryID'] = $this->CategoryID; $this->inv['errorCategoryID'] = $this->errorCategoryID;
        $this->inv['SubCategoryID'] = $this->SubCategoryID; $this->inv['errorSubCategoryID'] = $this->errorSubCategoryID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;

        $this->inv['arrGroupSize'] = $this->GroupSize->where([['Status','=',0]])->get()->toArray();
        if(!$this->ModelType) $this->ModelType = 'WOMEN';
        $this->inv['ModelType'] = $this->ModelType;

        $this->inv['arrCategory'] = $this->Category->where([['Status','=',0],['ModelType','=',$this->ModelType]])->get()->toArray();

        if(!empty($this->CategoryID)) {
            $this->inv['arrSubCategory'] = $this->SubCategory->where([['Status','=',0],['IDCategory','=', $this->CategoryID]])->get()->toArray();
        } else {
            $this->inv['arrSubCategory'] = [];
        }

        $arrModelType = [
            'WOMEN' => 'WOMEN',
            'MEN' => 'MEN',
            'KIDS' => 'KIDS',
        ];
        $this->inv['arrModelType'] = $arrModelType;

        $arrType = [
            0 => 'Fashion',
            1 => 'Beauty'
        ];
        $this->inv['arrType'] = $arrType;

        $arrSizeLink = [];
        if($this->SizeVariantID) {
            $this->_loaddbclass(['SizeLink']);
            $arrSizeLink = $this->SizeLink->leftjoin([
                ['size_variant as s', 's.ID', '=', 'size_link.SizeVariantIDLink'],
                ['group_size as gs', 'gs.ID', '=', 's.GroupSizeID'],
                ['category as c', 'c.ID', '=', 's.CategoryID'],
                ['sub_category as sc', 'sc.ID', '=', 's.SubCategoryID'],
            ])->selectraw('
                size_link.SizeVariantIDLink,
                gs.Name as GroupSizeName,
                s.ModelType,
                c.Name as CategoryName,
                sc.Name as SubCategoryName,
                s.Name as SizeName
            ')->where([['SizeVariantID', '=', $this->SizeVariantID]])->get();
        }

        $this->inv['arrSizeLink'] = $arrSizeLink;
        $this->inv['SizeLinkID'] = $this->SizeLinkID; $this->inv['errorSizeLinkID'] = $this->errorSizeLinkID;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([$this->model]);

            foreach($this->inv['delete'] as $val) {
                $SizeVariant = $this->SizeVariant->where([[$this->objectkey,'=',$val]])->first();
                if($SizeVariant) {
                    $this->Name = $SizeVariant[$this->inv['flip']['Name']];
                    
                    $array[$this->inv['flip']['Status']] = 1;

                    $SizeVariant->delete($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $this->Name);
                    $this->inv['messagesuccess'] .= "Delete $this->Name Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"], $arraywhere = []) {
        $arrType = [
            0 => 'Fashion',
            1 => 'Beauty'
        ];

        $this->_loaddbclass([ $this->model ]);

        $result = $this->SizeVariant->leftJoin([
            ['category','category.ID','=','size_variant.CategoryID'],
            ['sub_category','sub_category.ID','=','size_variant.SubCategoryID'],
            ['group_size','group_size.ID','=','size_variant.GroupSizeID'],
        ])->select([
            'size_variant.*',
            'category.Name as CategoryName',
            'sub_category.Name as SubCategoryName',
            'group_size.Name as GroupSizeName',
        ])->where(array_merge([['size_variant.Status','=',0]], $arraywhere))->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        $this->inv['flip']['GroupSizeName'] = 'group_size.Name';
        $this->inv['flip']['SubCategoryName'] = 'sub_category.Name';
        $this->inv['flip']['CategoryName'] = 'category.Name';
        $this->inv['flip']['ModelType'] = 'size_variant.ModelType';
        $this->inv['flip']['Name'] = 'size_variant.Name';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['GroupSizeName'] = 'GroupSizeName';
        $this->inv['flip']['SubCategoryName'] = 'SubCategoryName';
        $this->inv['flip']['CategoryName'] = 'CategoryName';
        $this->inv['flip']['ModelType'] = 'ModelType';
        $this->inv['flip']['Name'] = 'Name';

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                $result['data'][$i][$this->inv['flip']['Type']] = $arrType[$result['data'][$i][$this->inv['flip']['Type']]];
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}