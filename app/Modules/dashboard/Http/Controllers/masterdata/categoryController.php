<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class categoryController extends Controller
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
        'ID' => 'CategoryID',
        'ModelType' => 'ModelType',
        'CategoryImage' => 'CategoryImage',
        'Name' => 'Name',
        'ShowOnHeader' => 'ShowOnHeader',
        'ColumnMode' => 'ColumnMode',
        'ShowOnSubHeader' => 'ShowOnSubHeader',
        'Priority' => 'Priority',
        'IsActive' => 'IsActive',
        'Favorite' => 'Favorite',
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
        'CategoryID' => ['Category ID'],
        'ModelType' => ['Model Type', true],
        'CategoryImage' => ['Category Image', true],
        'Name' => ['Category Name', true],
        'ShowOnHeader' => ['Show On Header', true],
        'ColumnMode' => ['Column Mode', true],
        'ShowOnSubHeader' => ['Show On Sub Header', true],
        'Priority' => ['Priority', true],
        'IsActive' => ['Is Active', true],
        'Favorite' => ['Favorite'],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'permalink' => ['permalink'],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/category/';
    var $objectkey = '', $CategoryID = '', $errorCategoryID = '', $ModelType = '', $errorModelType = '', $Name = '', $errorName = '', $CategoryImage = '', $CategoryImagefiletype= '',$errorCategoryImage = '', $ShowOnHeader = '', $errorShowOnHeader = '', $Priority = '', $errorPriority = '', $ColumnMode = '', $errorColumnMode = '', $ShowOnSubHeader = '', $errorShowOnSubHeader = '', $Favorite = '', $errorFavorite = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '';
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            $id = $request['value'];
            $this->_loaddbclass([ 'Category' ]);
            $Category = $this->Category->where([['ID','=',$id]])->first();
            
            switch($request['ajaxpost']) {
                case 'setactive' :
                    if($Category) {
                        $IsActive = 1;
                        if($Category->IsActive == 1) $IsActive = 0;
                        $array[$this->inv['flip']['IsActive']] = $IsActive;
                        $Category->update($array);

                        die('OK');
                    } else die('Error');
                break;
                case 'setonheader' :
                    if($Category) {
                        $ShowOnHeader = 1;
                        if($Category->ShowOnHeader == 1) $ShowOnHeader = 0;
                        $array[$this->inv['flip']['ShowOnHeader']] = $ShowOnHeader;
                        $Category->update($array);

                        die('OK');
                    } else die('Error');
                break;
                case 'setonsubheader' :
                    if($Category) {
                        $ShowOnSubHeader = 1;
                        if($Category->ShowOnSubHeader == 1) $ShowOnSubHeader = 0;
                        $array[$this->inv['flip']['ShowOnSubHeader']] = $ShowOnSubHeader;
                        $Category->update($array);

                        die('OK');
                    } else die('Error');
                break;
                case 'deleteCategoryImage' :
                    if($Category[$this->inv['flip']['CategoryImage']]) {
                        @unlink(base_path().$this->pathimage.$Category[$this->inv['flip']['CategoryImage']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Category[$this->inv['flip']['CategoryImage']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Category[$this->inv['flip']['CategoryImage']]);
                        $Category->update([$this->inv['flip']['CategoryImage'] => '']);
                    }
                    exit;
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
                $this->_loaddbclass([ 'Category' ]);

                $Category = $this->Category->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Category) {
                    $this->CategoryID = $Category[$this->inv['flip']['CategoryID']];
                    $this->ModelType = $Category[$this->inv['flip']['ModelType']];
                    $this->Name = $Category[$this->inv['flip']['Name']];

                    if($Category[$this->inv['flip']['CategoryImage']])
                        $this->CategoryImage = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'medium_'.$Category[$this->inv['flip']['CategoryImage']];

                    $this->ShowOnHeader = $Category[$this->inv['flip']['ShowOnHeader']];
                    $this->Priority = $Category[$this->inv['flip']['Priority']];
                    $this->ColumnMode = $Category[$this->inv['flip']['ColumnMode']];
                    $this->ShowOnSubHeader = $Category[$this->inv['flip']['ShowOnSubHeader']];
                    $this->Favorite = $Category[$this->inv['flip']['Favorite']];
                    $this->IsActive = $Category[$this->inv['flip']['IsActive']];
                    $this->Status = $Category[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Category[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Category[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Category[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Category[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $Category[$this->inv['flip']['permalink']];

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
            $this->_loaddbclass([ 'Category' ]);

            if(isset($request['edit'])) {
                $Category = $this->Category->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$Category) {
                    $this->_redirect('404');
                }
            }
            
            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.category.Name')]
                );
            }

            $this->ModelType = $request['ModelType'];
            if(empty($this->ModelType)) {
                $this->errorModelType = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.category.ModelType')]
                );
            }

            $Uniq = $this->Category->where([
                [$this->inv['flip']['Name'],'=',$this->Name],
                [$this->inv['flip']['ModelType'],'=',$this->ModelType],
            ])->first();

            if($Uniq) {
                if(isset($request['addnew'])) {
                    if(!$this->errorName) {
                        $this->errorName = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.category.Name')]
                        );
                    }
                } else {
                    if ($Uniq[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorName) {
                            $this->errorName = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.category.Name')]
                            );
                        }
                    }
                }
            }

            if(isset($requestfile['CategoryImage'])) $this->CategoryImage = $requestfile['CategoryImage'];
            else $this->CategoryImage = '';
            if(empty($this->CategoryImage) && !(isset($request['edit']) && $Category[$this->inv['flip']['CategoryImage']])) {
                $this->errorCategoryImage = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.category.CategoryImage')]
                );
            }
            if($this->CategoryImage && !$this->_checkimage($this->CategoryImage, $this->CategoryImagefiletype)) {
                $this->errorCategoryImage = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.category.CategoryImage')]
                );
            }

            $this->ShowOnHeader = $request['ShowOnHeader'];
            if(!is_numeric($this->ShowOnHeader)) {
                $this->errorShowOnHeader = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.category.ShowOnHeader')]
                );
            }

            $this->ColumnMode = $request['ColumnMode'];
            if(empty($this->ColumnMode)) {
                $this->errorColumnMode = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.category.ColumnMode')]
                );
            }

            $this->ShowOnSubHeader = $request['ShowOnSubHeader'];
            if(!is_numeric($this->ShowOnSubHeader)) {
                $this->errorShowOnSubHeader = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('backend.masterdata.category.ShowOnSubHeader')]
                );
            }

            //handling error
            if(!$this->errorCategoryID && !$this->errorModelType && !$this->errorName && !$this->errorCategoryImage && !$this->errorShowOnHeader && !$this->errorPriority && !$this->errorColumnMode && !$this->errorShowOnSubHeader && !$this->errorFavorite && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) {

                $Category = $this->Category->where([['ModelType','=',$this->ModelType],['IsActive','=',1],['Status','=',0]])->orderBy('Priority','desc')->first();

                $array = array(
                    $this->inv['flip']['CategoryID'] => $this->CategoryID,
                    $this->inv['flip']['ModelType'] => $this->ModelType,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['ShowOnHeader'] => $this->ShowOnHeader,
                    $this->inv['flip']['Priority'] => ($Category->Priority + 1),
                    $this->inv['flip']['ColumnMode'] => $this->ColumnMode,
                    $this->inv['flip']['ShowOnSubHeader'] => $this->ShowOnSubHeader,
                    $this->inv['flip']['permalink'] => $this->_permalink($this->ModelType.' '.$this->Name),
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $Category = $this->Category->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Name);
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {

                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Category = $this->Category->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Category->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
                }

                if($this->CategoryImage) {
                    $ImageName = 'CategoryImage_'.$Category[$this->inv['flip']['CategoryID']].$this->CategoryImagefiletype;
                    $array[$this->inv['flip']['CategoryImage']] = $ImageName;
                    $Category->update($array);
                    list($width, $height) = getimagesize($this->CategoryImage->GetPathName());
                    $this->_imagetofolderratio($this->CategoryImage, base_path().$this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolderratio($this->CategoryImage, base_path().$this->pathimage, 'medium_'.$ImageName, $width / 3, $height / 3);
                    $this->_imagetofolderratio($this->CategoryImage, base_path().$this->pathimage, 'small_'.$ImageName, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }
        
        $this->inv['CategoryID'] = $this->CategoryID; $this->inv['errorCategoryID'] = $this->errorCategoryID;
        $this->inv['ModelType'] = $this->ModelType; $this->inv['errorModelType'] = $this->errorModelType;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['CategoryImage'] = $this->CategoryImage; $this->inv['errorCategoryImage'] = $this->errorCategoryImage;
        $this->inv['ShowOnHeader'] = $this->ShowOnHeader; $this->inv['errorShowOnHeader'] = $this->errorShowOnHeader;
        $this->inv['Priority'] = $this->Priority; $this->inv['errorPriority'] = $this->errorPriority;
        $this->inv['ColumnMode'] = $this->ColumnMode; $this->inv['errorColumnMode'] = $this->errorColumnMode;
        $this->inv['ShowOnSubHeader'] = $this->ShowOnSubHeader; $this->inv['errorShowOnSubHeader'] = $this->errorShowOnSubHeader;
        $this->inv['Favorite'] = $this->Favorite; $this->inv['errorFavorite'] = $this->errorFavorite;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;

        $arrModelType = [
            'WOMEN' => 'WOMEN',
            'MEN' => 'MEN',
            'KIDS' => 'KIDS',
        ];
        $this->inv['arrModelType'] = $arrModelType;

        $arrShowOnHeader = [
            '1' => 'Yes',
            '0' => 'No',
        ];
        $this->inv['arrShowOnHeader'] = $arrShowOnHeader;
        $arrShowOnSubHeader = [
            '1' => 'Yes',
            '0' => 'No',
        ];
        $this->inv['arrShowOnSubHeader'] = $arrShowOnSubHeader;
        $arrColumnMode = [
            '1' => 'Left',
            '2' => 'Center',
            '3' => 'Right',
        ];
        $this->inv['arrColumnMode'] = $arrColumnMode;

        return $this->_showview(["new"]);
    }

    public function priority()
    {
        $url = $this->_accessdata($this, __FUNCTION__, $this->access);
        if($url) return $this->_redirect($url);
        
        if(isset($this->inv['getset'])) {
            list($function, $id) = explode('.', $this->inv['getset']);

            $this->_loaddbclass([ 'Category' ]);

            $CategoryOld = $this->Category->where([['ID','=',$id]])->first();

            if($CategoryOld) {
                $ModelType = $CategoryOld->ModelType;
                $ColumnMode = $CategoryOld->ColumnMode;
                $PriorityOld = $CategoryOld->Priority;

                if($function == 'up') {
                    $CategoryNew = $this->Category->where([
                        ['ModelType','=',$ModelType],
                        ['ColumnMode','=',$ColumnMode],
                        ['Priority','<',$PriorityOld]
                    ])->orderBy('Priority', 'DESC');
                } else {
                    $CategoryNew = $this->Category->where([
                        ['ModelType','=',$ModelType],
                        ['ColumnMode','=',$ColumnMode],
                        ['Priority','>',$PriorityOld]
                    ])->orderBy('Priority', 'ASC');
                }

                $CategoryNew = $CategoryNew->first();

                if($CategoryNew) {
                    $PriorityNew = $CategoryNew->Priority;

                    $array = array( 'Priority' => $PriorityOld );
                    $CategoryNew->update($array);
                    $array = array( 'Priority' => $PriorityNew );
                    $CategoryOld->update($array);
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
            $this->_loaddbclass([ 'Category' ]);

            $Category = $this->Category->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
            if($Category) {
                $this->Name = $Category[$this->inv['flip']['Name']];

                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['permalink']] = '';

                if($Category[$this->inv['flip']['CategoryImage']]) {
                    @unlink(base_path().$this->pathimage.$Category[$this->inv['flip']['CategoryImage']]);
                    @unlink(base_path().$this->pathimage.'medium_'.$Category[$this->inv['flip']['CategoryImage']]);
                    @unlink(base_path().$this->pathimage.'small_'.$Category[$this->inv['flip']['CategoryImage']]);
                }

                $Category->update($array);

                $this->_dblog('delete', $this, $this->Name);
                $this->inv['messagesuccess'] .= "Delete $this->Name Completed !";
            }
        }

        return $this->views();
    }

    private function views($views = ["dashboard.masterdata.productlistcategory"]) {
        $this->_loaddbclass([ 'Category' ]);

        $result = $this->Category->where([['Status','=',0]])   
        ->orderByRaw("case ModelType when 'WOMAN' then 1 when 'MEN' then 2 when 'KIDS' then 3 END")
        ->orderBy('ModelType','DESC')->orderBy('ColumnMode','ASC')->orderBy('Priority','ASC');

        $this->inv['flip']['ModelType'] = 'category.ModelType';
        
        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);
        $this->inv['flip']['ModelType'] = 'ModelType';

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            $arrColumnMode = [
                '1' => 'Left',
                '2' => 'Center',
                '3' => 'Right',
            ];

            for($i = 0; $i < count($result['data']); $i++) {
                $result['data'][$i][$this->inv['flip']['ColumnMode']] = $arrColumnMode[$result['data'][$i][$this->inv['flip']['ColumnMode']]];
            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}