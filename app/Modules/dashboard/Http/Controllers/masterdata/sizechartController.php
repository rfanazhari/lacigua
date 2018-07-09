<?php

namespace App\Modules\dashboard\Http\Controllers\masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class sizechartController extends Controller
{

    public $model = 'SizeChart';
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
		'ID' => 'SizeChartID',
        'GroupSizeID' => 'GroupSizeID',
        'GroupSizeName' => 'GroupSizeName',
        'ModelType' => 'ModelType',
        'CategoryID' => 'CategoryID',
        'CategoryName' => 'CategoryName',
        'SubCategoryID' => 'SubCategoryID',
        'SubCategoryName' => 'SubCategoryName',
        'Image' => 'Image',
        'Status' => 'Status',
        'CreatedDate' => 'CreatedDate',
        'CreatedBy' => 'CreatedBy',
        'UpdatedDate' => 'UpdatedDate',
        'UpdatedBy' => 'UpdatedBy',
        'idfunction' => 'ID',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'SizeChartID' => ['Size ID'],
        'GroupSizeID' => ['Group Size ID'],
        'GroupSizeName' => ['Group Size Name', true],
        'ModelType' => ['Model Type', true],
        'CategoryID' => ['Category ID'],
        'CategoryName' => ['Category Name', true],
        'SubCategoryID' => ['Sub Category ID'],
        'SubCategoryName' => ['Sub Category Name', true],
        'Image' => ['Size Chart', true, '', 'image'],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/sizechart/';
    var $objectkey = '', $SizeChartID = '', $errorSizeChartID = '', $GroupSizeID = '', $errorGroupSizeID = '', $CategoryID = '', $errorCategoryID = '', $SubCategoryID = '', $errorSubCategoryID = '', $Image = '', $errorImage = '', $Imagefiletype = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';
    
    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            $this->_loaddbclass([ 'SizeChart', 'Category', 'SubCategory' ]);
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
                case 'deleteImage' :
                    if($SizeChart[$this->inv['flip']['Image']]) {
                        @unlink(base_path().$this->pathimage.$SizeChart[$this->inv['flip']['Image']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$SizeChart[$this->inv['flip']['Image']]);
                        @unlink(base_path().$this->pathimage.'small_'.$SizeChart[$this->inv['flip']['Image']]);
                        $SizeChart->update([$this->inv['flip']['Image'] => '']);
                    }
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
                
                $SizeChart = $this->SizeChart->leftJoin([
                    ['category','category.ID','=','size_chart.CategoryID'],
                ])->select([
                    'category.ModelType',
                    'category.Name as CategoryName',
                    'size_chart.*'
                ])->where([['size_chart.'.$this->objectkey,'=',$this->inv['getid']]])->first();

                if($SizeChart) {
                   	$this->SizeChartID = $SizeChart[$this->inv['flip']['SizeChartID']];
                    $this->GroupSizeID = $SizeChart[$this->inv['flip']['GroupSizeID']];
                    $this->ModelType = $SizeChart[$this->inv['flip']['ModelType']];
                    $this->CategoryID = $SizeChart[$this->inv['flip']['CategoryID']];
                    $this->SubCategoryID = $SizeChart[$this->inv['flip']['SubCategoryID']];

                    if($SizeChart[$this->inv['flip']['Image']])
                        $this->Image = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'medium_'.$SizeChart[$this->inv['flip']['Image']]; 
                    
                    $this->Status = $SizeChart[$this->inv['flip']['Status']];
                    $this->CreatedDate = $SizeChart[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $SizeChart[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $SizeChart[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $SizeChart[$this->inv['flip']['UpdatedBy']];

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
                $SizeChart = $this->SizeChart->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$SizeChart) {
                    $this->_redirect('404');
                }
            }

            $this->CategoryID = $request['CategoryID'];
            if(empty($this->CategoryID)) {
                $this->errorCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.productsize.CategoryName')]
                );
            }

            $this->SubCategoryID = $request['SubCategoryID'];
            if(empty($this->CategoryID) && empty($this->SubCategoryID)) {
                $this->errorSubCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.productsize.SubCategoryName')]
                );
            }

            $SubCategory = $this->SubCategory->where([['IDCategory','=',$this->CategoryID]])->get()->count();
            if($SubCategory > 0){
                $this->SubCategoryID = $request['SubCategoryID'];
                if(empty($this->SubCategoryID)) {
                    $this->errorSubCategoryID = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.masterdata.productsize.SubCategoryName')]
                    );
                }    
            }

            $this->GroupSizeID = $request['GroupSizeID'];
            if(empty($this->GroupSizeID)) {
                $this->errorGroupSizeID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.productsize.GroupSizeID')]
                );
            }

            $Uniq = $this->SizeChart->where([
                [$this->inv['flip']['GroupSizeID'],'=',$this->GroupSizeID],
                [$this->inv['flip']['CategoryID'],'=',$this->CategoryID],
                [$this->inv['flip']['SubCategoryID'],'=',$this->SubCategoryID],
                [$this->inv['flip']['Status'],'=',0],
            ])->first();

            if($Uniq) {
                if(isset($request['addnew'])) {
                    if(!$this->errorGroupSizeID) {
                        $this->errorGroupSizeID = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterdata.Size.GroupSizeID')]
                        );
                    }
                } else {
                    if ($Uniq[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorGroupSizeID) {
                            $this->errorGroupSizeID = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterdata.Size.GroupSizeID')]
                            );
                        }
                    }
                }
            }

            if(isset($requestfile['Image'])) $this->Image = $requestfile['Image'];
            else $this->Image = '';
            if(empty($this->Image) && !(isset($request['edit']) && $SizeChart[$this->inv['flip']['Image']])) {
                $this->errorImage = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.Image')]
                );
            }
            if($this->Image && !$this->_checkimage($this->Image, $this->Imagefiletype)) {
                $this->errorImage = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterdata.Brand.Image')]
                );
            }

            //handling error
            if(!$this->inv['messageerror'] && !$this->errorSizeChartID && !$this->errorGroupSizeID && !$this->errorCategoryID && !$this->errorSubCategoryID && !$this->errorImage && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy) {
                
                $array = array(
                    $this->inv['flip']['SizeChartID'] => $this->SizeChartID,
                    $this->inv['flip']['GroupSizeID'] => $this->GroupSizeID,
                    $this->inv['flip']['CategoryID'] => $this->CategoryID,
                    $this->inv['flip']['SubCategoryID'] => $this->SubCategoryID,
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                $Name = '';
                $GroupSize = $this->GroupSize->where([['ID', '=', $this->GroupSizeID]])->first();
                if(isset($GroupSize->Name)) $Name = $GroupSize->Name;
                $Category = $this->Category->where([['ID', '=', $this->CategoryID]])->first();
                if(isset($Category->Name)) $Name .= ' '.$Category->Name;
                $SubCategory = $this->SubCategory->where([['ID', '=', $this->SubCategoryID]])->first();
                if(isset($SubCategory->Name)) $Name .= ' '.$SubCategory->Name;
                $Name .= ' Size Chart';

                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    $array[$this->inv['flip']['Status']] = 0;
                    
                    $SizeChart = $this->SizeChart->creates($array);
                    
                    $this->_dblog('addnew', $this, $Name);
                    \Session::put('messagesuccess', "Saving $Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $SizeChart = $this->SizeChart->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $SizeChart->update($array);
                    
                    $this->_dblog('edit', $this, $Name);
                    \Session::put('messagesuccess', "Update $Name Completed !");
                }

                if($this->Image) {
                    $ImageName = 'Image_'.$SizeChart[$this->inv['flip']['SizeChartID']].$this->Imagefiletype;
                    $array[$this->inv['flip']['Image']] = $ImageName;
                    $SizeChart->update($array);
                    list($width, $height) = getimagesize($this->Image->GetPathName());
                    $this->_imagetofolderratio($this->Image, base_path().$this->pathimage, $ImageName, $width, $height);
                    $this->_imagetofolderratio($this->Image, base_path().$this->pathimage, 'medium_'.$ImageName, $width / 3, $height / 3);
                    $this->_imagetofolderratio($this->Image, base_path().$this->pathimage, 'small_'.$ImageName, $width / 6, $height / 6);
                }

                return $this->_redirect(get_class());
            }
        }
       
        $this->inv['SizeChartID'] = $this->SizeChartID; $this->inv['errorSizeChartID'] = $this->errorSizeChartID;
        $this->inv['GroupSizeID'] = $this->GroupSizeID; $this->inv['errorGroupSizeID'] = $this->errorGroupSizeID;
        $this->inv['CategoryID'] = $this->CategoryID; $this->inv['errorCategoryID'] = $this->errorCategoryID;
        $this->inv['SubCategoryID'] = $this->SubCategoryID; $this->inv['errorSubCategoryID'] = $this->errorSubCategoryID;
        $this->inv['Image'] = $this->Image; $this->inv['errorImage'] = $this->errorImage;
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

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass([ $this->model, 'GroupSize', 'Category', 'SubCategory' ]);

            foreach($this->inv['delete'] as $val) {
                $SizeChart = $this->SizeChart->where([[$this->objectkey,'=',$val]])->first();
                if($SizeChart) {
                    $this->GroupSizeID = $SizeChart[$this->inv['flip']['GroupSizeID']];
                    $this->CategoryID = $SizeChart[$this->inv['flip']['CategoryID']];
                    $this->SubCategoryID = $SizeChart[$this->inv['flip']['SubCategoryID']];
                    
	                $Name = '';
	                $GroupSize = $this->GroupSize->where([['ID', '=', $this->GroupSizeID]])->first();
	                if(isset($GroupSize->Name)) $Name = $GroupSize->Name;
	                $Category = $this->Category->where([['ID', '=', $this->CategoryID]])->first();
	                if(isset($Category->Name)) $Name .= ' '.$Category->Name;
	                $SubCategory = $this->SubCategory->where([['ID', '=', $this->SubCategoryID]])->first();
	                if(isset($SubCategory->Name)) $Name .= ' '.$SubCategory->Name;
	                $Name .= ' Size Chart';

	                if ($SizeChart->Image) {
                        @unlink(base_path() . $this->pathimage . $SizeChart->Image);
                        @unlink(base_path() . $this->pathimage . 'medium_' . $SizeChart->Image);
                        @unlink(base_path() . $this->pathimage . 'small_' . $SizeChart->Image);
                    }

                    $array[$this->inv['flip']['Status']] = 1;
                    $SizeChart->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $Name);
                    $this->inv['messagesuccess'] .= "Delete $Name Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ $this->model ]);

        $result = $this->SizeChart->leftJoin([
            ['category','category.ID','=','size_chart.CategoryID'],
            ['sub_category','sub_category.ID','=','size_chart.SubCategoryID'],
            ['group_size','group_size.ID','=','size_chart.GroupSizeID'],
        ])->select([
            'size_chart.*',
            'category.Name as CategoryName', 
            'category.ModelType', 
            'sub_category.Name as SubCategoryName',
            'group_size.Name as GroupSizeName',
        ])->where([['size_chart.Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        $this->inv['flip']['GroupSizeName'] = 'group_size.Name';
        $this->inv['flip']['SubCategoryName'] = 'sub_category.Name';
        $this->inv['flip']['CategoryName'] = 'category.Name';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['GroupSizeName'] = 'GroupSizeName';
        $this->inv['flip']['SubCategoryName'] = 'SubCategoryName';
        $this->inv['flip']['CategoryName'] = 'CategoryName';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
        	for ($i = 0; $i < count($result['data']); $i++) {
                if ($result['data'][$i][$this->inv['flip']['Image']]) {
                    $result['data'][$i][$this->inv['flip']['Image']] =
                    $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) .
                        'small_' . $result['data'][$i][$this->inv['flip']['Image']];
                }
            }

            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}