<?php
namespace App\Modules\dashboard\Http\Controllers\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class addaproductController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => false,
        'addnew'    => false,
        'refresh'   => true,
        'uploadbulkproduct' => true,
        'uploadbulkimage' => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'ProductID',
        'SellerID' => 'SellerID',
        'SellerName' => 'SellerName',
        'BrandID' => 'BrandID',
        'BrandName' => 'BrandName',
        'ModelType' => 'ModelType',
        'CategoryID' => 'CategoryID',
        'CategoryName' => 'CategoryName',
        'SubCategoryID' => 'SubCategoryID',
        'SubCategoryName' => 'SubCategoryName',
        'TypeProduct' => 'TypeProduct',
        'ColorID' => 'ColorID',
        'ColorName' => 'ColorName',
        'GroupSizeID' => 'GroupSizeID',
        'GroupSizeName' => 'GroupSizeName',
        'Name' => 'Name',
        'NameShow' => 'NameShow',
        'Description' => 'Description',
        'SizingDetail' => 'SizingDetail',
        'SellingPrice' => 'SellingPrice',
        'SalePrice' => 'SalePrice',
        'Weight' => 'Weight',
        'SKUPrinciple' => 'SKUPrinciple',
        'SKUSeller' => 'SKUSeller',
        'ProductGender' => 'ProductGender',
        'CompositionMaterial' => 'CompositionMaterial',
        'CareLabel' => 'CareLabel',
        'Measurement' => 'Measurement',
        'Popularity' => 'Popularity',
        'StatusNew' => 'StatusNew',
        'StatusSale' => 'StatusSale',
        'Image1' => 'Image1',
        'Image2' => 'Image2',
        'Image3' => 'Image3',
        'Image4' => 'Image4',
        'Image5' => 'Image5',
        'ProductLinkGroup' => 'ProductLinkGroup',
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
        'ProductID' => ['Product ID'],
        'SellerID' => ['Seller ID'],
        'SellerName' => ['Seller Name'],
        'BrandID' => ['Brand ID'],
        'BrandName' => ['Brand Name'],
        'CategoryID' => ['Category ID'],
        'SubCategoryID' => ['Sub Category ID'],
        'ColorID' => ['Color ID'],
        'GroupSizeID' => ['Group Size ID'],
        'GroupSizeName' => ['Group Size Name'],
        'SKUPrinciple' => ['Product Code', true],
        'Name' => ['Name'],
        'NameShow' => ['Name Show', true],
        'ModelType' => ['Model Type', true],
        'CategoryName' => ['Category Name', true],
        'SubCategoryName' => ['Sub Category Name', true],
        'TypeProduct' => ['Type Product', true],
        'ColorName' => ['Color Name', true],
        'Description' => ['Description'],
        'SizingDetail' => ['Sizing Detail'],
        'SellingPrice' => ['Selling Price'],
        'SalePrice' => ['Sale Price'],
        'Weight' => ['Weight'],
        'SKUSeller' => ['SKU Seller'],
        'ProductGender' => ['Product Gender'],
        'CompositionMaterial' => ['Composition Material'],
        'CareLabel' => ['Care Label'],
        'Measurement' => ['Measurement'],
        'Popularity' => ['Popularity'],
        'StatusNew' => ['Status New'],
        'StatusSale' => ['Status Sale'],
        'Image1' => ['Image 1', true, '', 'image'],
        'Image2' => ['Image 2'],
        'Image3' => ['Image 3'],
        'Image4' => ['Image 4'],
        'Image5' => ['Image 5'],
        'ProductLinkGroup' => ['Product Link'],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'permalink' => ['permalink'],
        'StyleList' => ['Style'],
        'uploadbulkproduct' => ['Upload Bulk Product'],
        'uploadbulkimage' => ['Upload Bulk Image'],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/product/';
    var $objectkey = '', $ProductID = '', $errorProductID = '', $SellerID = '', $errorSellerID = '', $BrandID = '', $errorBrandID = '', $ModelType = '', $errorModelType = '', $CategoryID = '', $errorCategoryID = '', $SubCategoryID = '', $errorSubCategoryID = '', $TypeProduct = '', $errorTypeProduct = '', $ColorID = '', $errorColorID = '', $GroupSizeID = '', $errorGroupSizeID = '', $Name = '', $errorName = '', $NameShow = '', $errorNameShow = '', $Description = '', $errorDescription = '', $SizingDetail = '', $errorSizingDetail = '', $SellingPrice = '', $errorSellingPrice = '', $SalePrice = '', $errorSalePrice = '', $Weight = '', $errorWeight = '', $SKUPrinciple = '', $errorSKUPrinciple = '', $SKUSeller = '', $errorSKUSeller = '', $ProductGender = '', $errorProductGender = '', $CompositionMaterial = '', $errorCompositionMaterial = '', $CareLabel = '', $errorCareLabel = '', $Measurement = '', $errorMeasurement = '', $Popularity = '', $errorPopularity = '', $StatusNew = '', $errorStatusNew = '', $StatusSale = '', $errorStatusSale = '', $Image1 = '', $errorImage1 = '', $Image1filetype = '', $Image2 = '', $errorImage2 = '', $Image2filetype = '', $Image3 = '', $errorImage3 = '', $Image3filetype = '', $Image4 = '', $errorImage4 = '', $Image4filetype = '', $Image5 = '', $errorImage5 = '', $Image5filetype = '', $ProductLinkGroup = '', $errorProductLinkGroup = '', $ProductLinkDisplay = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '', $StyleList = '', $errorStyleList = '', $lastid = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            $this->_loaddbclass([ 'Product', 'Brand', 'Category', 'SubCategory' ]);
            switch($request['ajaxpost']) {
                case 'setactive' :
                        $id = $request['value'];
                        $Product = $this->Product->where([['ID','=',$id]])->first();
                        if($Product) {
                            $this->Name = $Product[$this->inv['flip']['Name']];

                            $IsActive = 1;
                            if($Product->IsActive == 1) $IsActive = 0;

                            $userdata =  \Session::get('userdata');
                            $userid =  $userdata['uuserid'];

                            $array[$this->inv['flip']['IsActive']] = $IsActive;
                            $array[$this->inv['flip']['UpdatedDate']] = new \DateTime('now');
                            $array[$this->inv['flip']['UpdatedBy']] = $userid;

                            $Product->update($array);

                            if($IsActive) $IsActive = 'Active';
                            else $IsActive = 'Non Active';

                            $this->_dblog('edit', $this, 'Set '.$IsActive.' '.$this->Name);

                            die('OK');
                        } else die('Error');
                    break;
                case 'getBrand' :
                        $SellerID = $request['SellerID'];
                        if($SellerID) {
                            $Brand = $this->Brand->where([['SellerID','=',$SellerID]])->get()->toArray();
                            die(json_encode(['response' => 'OK','data' => $Brand], JSON_FORCE_OBJECT));
                        } else die(json_encode(['response' => 'Error'], JSON_FORCE_OBJECT));
                    break;
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
                case 'deleteImage1' :
                    $id = $request['value'];
                    $Product = $this->Product->where([['ID','=',$id]])->first();
                    if($Product) {
                        if($Product[$this->inv['flip']['Image1']]) {
                            @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image1']]);
                            @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image1']]);
                            @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image1']]);
                            $Product->update([$this->inv['flip']['Image1'] => '']);
                        }
                    }
                    break;
                case 'deleteImage2' :
                    $id = $request['value'];
                    $Product = $this->Product->where([['ID','=',$id]])->first();
                    if($Product) {
                        if($Product[$this->inv['flip']['Image2']]) {
                            @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image2']]);
                            @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image2']]);
                            @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image2']]);
                            $Product->update([$this->inv['flip']['Image2'] => '']);
                        }
                    }
                    break;
                case 'deleteImage3' :
                    $id = $request['value'];
                    $Product = $this->Product->where([['ID','=',$id]])->first();
                    if($Product) {
                        if($Product[$this->inv['flip']['Image3']]) {
                            @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image3']]);
                            @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image3']]);
                            @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image3']]);
                            $Product->update([$this->inv['flip']['Image3'] => '']);
                        }
                    }
                    break;
                case 'deleteImage4' :
                    $id = $request['value'];
                    $Product = $this->Product->where([['ID','=',$id]])->first();
                    if($Product) {
                        if($Product[$this->inv['flip']['Image4']]) {
                            @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image4']]);
                            @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image4']]);
                            @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image4']]);
                            $Product->update([$this->inv['flip']['Image4'] => '']);
                        }
                    }
                    break;
                case 'deleteImage5' :
                    $id = $request['value'];
                    $Product = $this->Product->where([['ID','=',$id]])->first();
                    if($Product) {
                        if($Product[$this->inv['flip']['Image5']]) {
                            @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image5']]);
                            @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image5']]);
                            @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image5']]);
                            $Product->update([$this->inv['flip']['Image5'] => '']);
                        }
                    }
                    break;
            }
        }
    }

    public function index()
    {
        // $this->_debugvar();
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->addnewedit();
    }
    
    public function addnew()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->addnewedit();
    }
    
    private function addnewedit() {
        $request = \Request::instance()->request->all();
        $requestfile = \Request::file();
        $this->_loaddbclass([ 'Product', 'Category', 'SubCategory', 'ProductDetailStyle' ]);

        if (isset($request['addnew']) || isset($request['edit'])) {
            $this->_loaddbclass([ 'Product' ]);

            if(isset($request['edit'])) {
                $GetProduct = $this->Product->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$GetProduct) {
                    $this->_redirect('404');
                }
            }

            $this->SellerID = $request['SellerID'];
            if(empty($this->SellerID)) {
                $this->errorSellerID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.SellerName')]
                );
            }

            $this->BrandID = $request['BrandID'];
            if(empty($this->BrandID)) {
                $this->errorBrandID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.BrandName')]
                );
            }
            
            $this->ModelType = $request['ModelType'];
            if(empty($this->ModelType)) {
                $this->errorModelType = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.ModelType')]
                );
            }

            $this->CategoryID = $request['CategoryID'];
            if(empty($this->CategoryID)) {
                $this->errorCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.CategoryName')]
                );
            }

            $this->SKUSeller = $request['SKUSeller'];
            if(empty($this->SKUSeller)) {
                $this->errorSKUSeller = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.SKUSeller')]
                );
            }

            $Product = $this->Product->where([[$this->inv['flip']['SellerID'],'=',$this->SellerID],[$this->inv['flip']['BrandID'],'=',$this->BrandID],[$this->inv['flip']['ModelType'],'=',$this->ModelType],[$this->inv['flip']['CategoryID'],'=',$this->CategoryID],[$this->inv['flip']['SKUSeller'],'=',$this->SKUSeller],['Status','=',0]])->first();

            if($Product) {
                if(isset($request['addnew']) && $Product->SellerID == $this->SellerID && $Product->BrandID == $this->BrandID && $Product->ModelType == $this->ModelType && $Product->CategoryID == $this->CategoryID && $Product->SKUSeller == $this->SKUSeller) {
                    if(!$this->errorSKUSeller) {
                        $this->errorSKUSeller = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.products.Product.SKUSeller')]
                        );
                    }
                } else {
                    if ($Product[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorSKUSeller) {
                            $this->errorSKUSeller = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.products.Product.SKUSeller')]
                            );
                        }
                    }
                }
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Name')]
                );
            }

            $SubCategory = $this->SubCategory->where([['IDCategory','=',$this->CategoryID]])->get()->count();
            if($SubCategory > 0) {
                $this->SubCategoryID = $request['SubCategoryID'];
                if(empty($this->SubCategoryID)) {
                    $this->errorSubCategoryID = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.products.productsize.SubCategoryName')]
                    );
                }
            }

            if(empty($this->CategoryID) && empty($this->SubCategoryID)) {
                $this->errorCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.CategoryName')]
                );
                $this->errorSubCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.SubCategoryName')]
                );
            }

            $this->TypeProduct = $request['TypeProduct'];

            if($this->TypeProduct == 0) {
                $this->GroupSizeID = $request['GroupSizeID'];
                if(empty($this->GroupSizeID)) {
                    $this->errorGroupSizeID = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.products.Product.GroupSizeName')]
                    );
                }
            }

            $this->ColorID = $request['ColorID'];
            if(empty($this->ColorID)) {
                $this->errorColorID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.productsize.ColorName')]
                );
            }

            $this->NameShow = $request['NameShow'];
            if(empty($this->NameShow)) {
                $this->errorNameShow = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.NameShow')]
                );
            }

            $this->Description = $request['Description'];
            if(empty($this->Description)) {
                $this->errorDescription = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Description')]
                );
            }

            $this->SizingDetail = $request['SizingDetail'];
            if(empty($this->SizingDetail)) {
                $this->errorSizingDetail = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.SizingDetail')]
                );
            }

            $this->StatusNew = $request['StatusNew'];
            if(!is_numeric($this->StatusNew)) {
                $this->errorStatusNew = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.StatusNew')]
                );
            }

            $this->StatusSale = $request['StatusSale'];
            if(!is_numeric($this->StatusSale)) {
                $this->errorStatusSale = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.StatusSale')]
                );
            }

            $this->SellingPrice = $request['SellingPrice'];
            if(empty($this->SellingPrice)) {
                $this->errorSellingPrice = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.SellingPrice')]
                );
            }

            $this->SalePrice = $request['SalePrice'];
            if($this->StatusSale && empty($this->SalePrice)) {
                $this->errorSalePrice = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.SalePrice')]
                );
            }

            $this->Weight = $request['Weight'];
            if(empty($this->Weight)) {
                $this->errorWeight = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Weight')]
                );
            }

            $this->ProductGender = $request['ProductGender'];
            if(!is_numeric($this->ProductGender)) {
                $this->errorProductGender = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.ProductGender')]
                );
            }

            $this->CompositionMaterial = $request['CompositionMaterial'];

            $this->CareLabel = $request['CareLabel'];

            $this->Measurement = $request['Measurement'];
            if(empty($this->Measurement)) {
                $this->errorMeasurement = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Measurement')]
                );
            }

            if(isset($requestfile['Image1'])) $this->Image1 = $requestfile['Image1'];
            else $this->Image1 = '';
            if(empty($this->Image1) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image1']])) {
                $this->errorImage1 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image1')]
                );
            }
            if($this->Image1 && !$this->_checkimage($this->Image1, $this->Image1filetype)) {
                $this->errorImage1 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image1')]
                );
            }

            if(isset($requestfile['Image2'])) $this->Image2 = $requestfile['Image2'];
            else $this->Image2 = '';
            if(empty($this->Image2) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image2']])) {
                $this->errorImage2 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image2')]
                );
            }
            if($this->Image2 && !$this->_checkimage($this->Image2, $this->Image2filetype)) {
                $this->errorImage2 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image2')]
                );
            }

            if(isset($requestfile['Image3'])) $this->Image3 = $requestfile['Image3'];
            else $this->Image3 = '';
            if(empty($this->Image3) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image3']])) {
                $this->errorImage3 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image3')]
                );
            }
            if($this->Image3 && !$this->_checkimage($this->Image3, $this->Image3filetype)) {
                $this->errorImage3 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image3')]
                );
            }

            if(isset($requestfile['Image4'])) $this->Image4 = $requestfile['Image4'];
            else $this->Image4 = '';
            if(empty($this->Image4) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image4']])) {
                $this->errorImage4 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image4')]
                );
            }
            if($this->Image4 && !$this->_checkimage($this->Image4, $this->Image4filetype)) {
                $this->errorImage4 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image4')]
                );
            }

            if(isset($requestfile['Image5'])) $this->Image5 = $requestfile['Image5'];
            else $this->Image5 = '';
            if(empty($this->Image5) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image5']])) {
                $this->errorImage5 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image5')]
                );
            }
            if($this->Image5 && !$this->_checkimage($this->Image5, $this->Image5filetype)) {
                $this->errorImage5 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.Image5')]
                );
            }

            if(isset($request['ProductLinkGroup'])) $this->ProductLinkGroup = $request['ProductLinkGroup'];

            $this->_loaddbclass([ 'ProductLink' ]);

            if($this->ProductLinkGroup) {
                $ProductLink = $this->ProductLink->where([['ProductID', '=', $this->ProductLinkGroup]])->first();
                if($ProductLink) {
                    $this->_loaddbclass([ 'ProductLink' ]);
                    $tmpProductLink = $this->ProductLink->leftjoin([
                        ['product as p', 'p.ID', '=', 'product_link.ProductID']
                    ])->where([['ProductLinkGroup', '=', $ProductLink->ProductLinkGroup]])->pluck('ColorID')->toArray();
                    if(count($tmpProductLink)) {
                        if(isset($request['addnew']) && in_array($this->ColorID, $tmpProductLink)) {
                            if(!$this->errorProductLinkGroup) {
                                $this->errorProductLinkGroup = $this->_trans('validation.already', 
                                    ['value' => $this->_trans('dashboard.products.Product.ProductLinkGroup')]
                                );
                            }
                        }
                    }
                }
            }

            if(isset($request['StyleList'])) $this->StyleList = $request['StyleList'];
            else {
                $this->errorStyleList = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.Product.StyleList')]
                );
            }

            if(!$this->inv['messageerror'] && !$this->errorProductID && !$this->errorSellerID && !$this->errorBrandID && !$this->errorModelType && !$this->errorCategoryID && !$this->errorSubCategoryID && !$this->errorColorID && !$this->errorGroupSizeID && !$this->errorName && !$this->errorNameShow && !$this->errorDescription && !$this->errorSizingDetail && !$this->errorSellingPrice && !$this->errorStyleList && !$this->errorSalePrice && !$this->errorWeight && !$this->errorSKUPrinciple && !$this->errorSKUSeller && !$this->errorProductGender && !$this->errorCompositionMaterial && !$this->errorCareLabel && !$this->errorMeasurement && !$this->errorPopularity && !$this->errorStatusNew && !$this->errorStatusSale && !$this->errorImage1 && !$this->errorImage2 && !$this->errorImage3 && !$this->errorImage4 && !$this->errorImage5 && !$this->errorProductLinkGroup && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) 
            {
                $array = array(
                    $this->inv['flip']['ProductID'] => $this->ProductID,
                    $this->inv['flip']['SellerID'] => $this->SellerID,
                    $this->inv['flip']['BrandID'] => $this->BrandID,
                    $this->inv['flip']['ModelType'] => $this->ModelType,
                    $this->inv['flip']['CategoryID'] => $this->CategoryID,
                    $this->inv['flip']['SubCategoryID'] => $this->SubCategoryID,
                    $this->inv['flip']['TypeProduct'] => $this->TypeProduct,
                    $this->inv['flip']['ColorID'] => $this->ColorID,
                    $this->inv['flip']['GroupSizeID'] => $this->GroupSizeID,
                    $this->inv['flip']['Name'] => $this->Name,
                    $this->inv['flip']['NameShow'] => $this->NameShow,
                    $this->inv['flip']['Description'] => $this->Description,
                    $this->inv['flip']['SizingDetail'] => $this->SizingDetail,
                    'CurrencyCode' => 'IDR',
                    $this->inv['flip']['SellingPrice'] => $this->SellingPrice,
                    $this->inv['flip']['SalePrice'] => $this->SalePrice,
                    $this->inv['flip']['Weight'] => $this->Weight,
                    $this->inv['flip']['SKUSeller'] => $this->SKUSeller,
                    $this->inv['flip']['ProductGender'] => $this->ProductGender,
                    $this->inv['flip']['CompositionMaterial'] => $this->CompositionMaterial,
                    $this->inv['flip']['CareLabel'] => $this->CareLabel,
                    $this->inv['flip']['Measurement'] => $this->Measurement,
                    $this->inv['flip']['StatusNew'] => $this->StatusNew,
                    $this->inv['flip']['StatusSale'] => $this->StatusSale,
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                if(isset($request['addnew'])) {
                    $SKUPrinciple = $this->_dbgetlastincrement(env('DB_DATABASE'), 'product');
                    $SKUPrinciple = 'LP'.date("ymdhms").sprintf('%03d', $SKUPrinciple);
                    $array[$this->inv['flip']['SKUPrinciple']] = $SKUPrinciple;
                    $array[$this->inv['flip']['IsActive']] = 1;
                    $array[$this->inv['flip']['Status']] = 0;

                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $Product = $this->Product->creates($array);
                    
                    $this->_dblog('addnew', $this, $this->Name);
                    $this->inv['messagesuccess'] = "Saving $this->Name Completed !";
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Product = $this->Product->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Product->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    $this->inv['messagesuccess'] = "Update $this->Name Completed !";
                }

                if($this->Image1) {
                    $Image1 = 'Image1_'.$Product[$this->inv['flip']['ProductID']].$this->Image1filetype;
                    $array[$this->inv['flip']['Image1']] = $Image1;
                    $width = 570;
                    $height = 850;
                    $this->_imagetofolder($this->Image1, base_path().$this->pathimage, $Image1, $width, $height);
                    $this->_imagetofolder($this->Image1, base_path().$this->pathimage, 'medium_'.$Image1, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Image1, base_path().$this->pathimage, 'small_'.$Image1, $width / 6, $height / 6);
                }

                if($this->Image2) {
                    $Image2 = 'Image2_'.$Product[$this->inv['flip']['ProductID']].$this->Image2filetype;
                    $array[$this->inv['flip']['Image2']] = $Image2;
                    $width = 570;
                    $height = 850;
                    $this->_imagetofolder($this->Image2, base_path().$this->pathimage, $Image2, $width, $height);
                    $this->_imagetofolder($this->Image2, base_path().$this->pathimage, 'medium_'.$Image2, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Image2, base_path().$this->pathimage, 'small_'.$Image2, $width / 6, $height / 6);
                }

                if($this->Image3) {
                    $Image3 = 'Image3_'.$Product[$this->inv['flip']['ProductID']].$this->Image3filetype;
                    $array[$this->inv['flip']['Image3']] = $Image3;
                    $width = 570;
                    $height = 850;
                    $this->_imagetofolder($this->Image3, base_path().$this->pathimage, $Image3, $width, $height);
                    $this->_imagetofolder($this->Image3, base_path().$this->pathimage, 'medium_'.$Image3, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Image3, base_path().$this->pathimage, 'small_'.$Image3, $width / 6, $height / 6);
                }

                if($this->Image4) {
                    $Image4 = 'Image4_'.$Product[$this->inv['flip']['ProductID']].$this->Image4filetype;
                    $array[$this->inv['flip']['Image4']] = $Image4;
                    $width = 570;
                    $height = 850;
                    $this->_imagetofolder($this->Image4, base_path().$this->pathimage, $Image4, $width, $height);
                    $this->_imagetofolder($this->Image4, base_path().$this->pathimage, 'medium_'.$Image4, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Image4, base_path().$this->pathimage, 'small_'.$Image4, $width / 6, $height / 6);
                }

                if($this->Image5) {
                    $Image5 = 'Image5_'.$Product[$this->inv['flip']['ProductID']].$this->Image5filetype;
                    $array[$this->inv['flip']['Image5']] = $Image5;
                    $width = 570;
                    $height = 850;
                    $this->_imagetofolder($this->Image5, base_path().$this->pathimage, $Image5, $width, $height);
                    $this->_imagetofolder($this->Image5, base_path().$this->pathimage, 'medium_'.$Image5, $width / 3, $height / 3);
                    $this->_imagetofolder($this->Image5, base_path().$this->pathimage, 'small_'.$Image5, $width / 6, $height / 6);
                }

                $array[$this->inv['flip']['permalink']] = $this->_permalink($this->Name.' '.$Product->ID);
                $Product->update($array);

                $this->_loaddbclass([ 'ProductLink' ]);
                if($this->ProductLinkGroup) {
                    $ProductLink = $this->ProductLink->where([['ProductID', '=', $this->ProductLinkGroup]])->first();
                    if($ProductLink) {
                        $this->_loaddbclass([ 'ProductLink' ]);
                        $tmpProductLink = $this->ProductLink->where([['ProductID', '=', $this->ProductID]])->first();
                        if($tmpProductLink) {
                            if(isset($request['addnew'])) {
                                $array = [
                                    'ProductID' => $Product[$this->inv['flip']['ProductID']],
                                    'ProductLinkGroup' => $ProductLink->ProductLinkGroup
                                ];
                                $this->ProductLink->creates($array);
                            } else {
                                $tmpProductLink->update(['ProductLink','=',$ProductLink->ProductLinkGroup]);
                            }
                        } else {
                            $array = [
                                'ProductID' => $Product[$this->inv['flip']['ProductID']],
                                'ProductLinkGroup' => $ProductLink->ProductLinkGroup
                            ];
                            $this->ProductLink->creates($array);
                        }
                    } else {
                        $ProductLinkGroup = strtoupper(uniqid());
                        $array = [
                            [
                                'ProductID' => $Product[$this->inv['flip']['ProductID']],
                                'ProductLinkGroup' => $ProductLinkGroup
                            ],
                            [
                                'ProductID' => $this->ProductLinkGroup,
                                'ProductLinkGroup' => $ProductLinkGroup
                            ],
                        ];

                        $this->ProductLink->inserts($array);
                    }
                } else {
                    $ProductLinkGroup = strtoupper(uniqid());
                    $ProductLink = $this->ProductLink->where([['ProductID', '=', $this->ProductID]])->first();
                    if($ProductLink) {
                        $ProductLink->update(['ProductLinkGroup' => $ProductLinkGroup]);
                    } else {
                        $array = [
                            'ProductID' => $Product[$this->inv['flip']['ProductID']],
                            'ProductLinkGroup' => $ProductLinkGroup
                        ];
                        $this->ProductLink->creates($array);
                    }
                }

                foreach($this->ProductDetailStyle->where([['ProductID','=',$Product[$this->inv['flip']['ProductID']]]])->get() as $obj) {
                    $obj->delete();
                }

                $arrayStyle = [];
                foreach ($this->StyleList as $key) {
                    $arrayStyle[] = [
                        'ProductID' => $Product[$this->inv['flip']['ProductID']],
                        'StyleID' => $key
                    ];
                }

                $this->ProductDetailStyle->inserts($arrayStyle);

                foreach ($request as $key => $value) {
                    $this->$key = '';
                }
            }
        }

        $this->_loaddbclass([ 'Seller','Brand','SubCategory','Color','Style','GroupSize']);
        
        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        $this->arrSeller = $this->Seller->where([['Status','=',0],['IsActive','=',1]]);
        if($Seller) {
            $this->arrSeller = $this->arrSeller->where([['idGroup', '=', $Seller->idGroup]]);
            $this->SellerID = $Seller->ID;
        }
        $this->arrSeller = $this->arrSeller->orderBy('FullName','ASC')->get()->toArray();
        $this->inv['arrSeller'] = $this->arrSeller;

        $arrStyle = $this->Style->get()->toArray();
        $this->inv['arrStyle'] = $arrStyle;

        if($Seller) {
            $this->arrBrand = $this->Brand->where([['SellerID','=',$Seller->ID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
        } else {
            $this->arrBrand = [];
        }
        $this->inv['arrBrand'] = $this->arrBrand;

        if(!$this->ModelType) $this->ModelType = 'WOMEN';

        $arrModelType = [
            'WOMEN' => 'WOMEN',
            'MEN' => 'MEN',
            'KIDS' => 'KIDS',
        ];
        $this->inv['arrModelType'] = $arrModelType;

        $arrTypeProduct = [
            '0' => 'Fashion',
            '1' => 'Beauty',
        ];
        $this->inv['arrTypeProduct'] = $arrTypeProduct;
        
        $arrStatusNew = [
            '1' => 'Active',
            '0' => 'Not Active',
        ];
        $this->inv['arrStatusNew'] = $arrStatusNew;

        $arrStatusSale = [
            '1' => 'Active',
            '0' => 'Not Active',
        ];
        $this->inv['arrStatusSale'] = $arrStatusSale;

        $this->inv['arrCategory'] = $this->Category->where([['Status','=',0],['ModelType','=',$this->ModelType]])->get()->toArray();

        if(!empty($this->CategoryID)) {
            $this->inv['arrSubCategory'] = $this->SubCategory->where([['Status','=',0],['IDCategory','=', $this->CategoryID]])->get()->toArray();
        } else {
            $this->inv['arrSubCategory'] = [];
        }

        $this->inv['arrColor'] = $this->Color->where([['Status','=',0],['IsActive','=',1]])->get()->toArray();

        $arrProductGender = [
            '0' => 'All',
            '1' => 'Male',
            '2' => 'Female',
            '3' => 'Kids',
        ];
        $this->inv['arrProductGender'] = $arrProductGender;
        $this->inv['arrGroupSize'] = $this->GroupSize->where([['Status','=',0]])->get()->toArray();
        
        $this->_loaddbclass([ 'Product' ]);
        $this->inv['arrProduct'] = $this->Product->where([['IsActive','=',1],['Status','=',0]])->get()->toArray();

        $this->inv['ProductID'] = $this->ProductID; $this->inv['errorProductID'] = $this->errorProductID;
        $this->inv['SellerID'] = $this->SellerID; $this->inv['errorSellerID'] = $this->errorSellerID;
        $this->inv['BrandID'] = $this->BrandID; $this->inv['errorBrandID'] = $this->errorBrandID;
        $this->inv['ModelType'] = $this->ModelType; $this->inv['errorModelType'] = $this->errorModelType;
        $this->inv['CategoryID'] = $this->CategoryID; $this->inv['errorCategoryID'] = $this->errorCategoryID;
        $this->inv['SubCategoryID'] = $this->SubCategoryID; $this->inv['errorSubCategoryID'] = $this->errorSubCategoryID;
        $this->inv['TypeProduct'] = $this->TypeProduct; $this->inv['errorTypeProduct'] = $this->errorTypeProduct;
        $this->inv['ColorID'] = $this->ColorID; $this->inv['errorColorID'] = $this->errorColorID;
        $this->inv['GroupSizeID'] = $this->GroupSizeID; $this->inv['errorGroupSizeID'] = $this->errorGroupSizeID;
        $this->inv['Name'] = $this->Name; $this->inv['errorName'] = $this->errorName;
        $this->inv['NameShow'] = $this->NameShow; $this->inv['errorNameShow'] = $this->errorNameShow;
        $this->inv['Description'] = $this->Description; $this->inv['errorDescription'] = $this->errorDescription;
        $this->inv['SizingDetail'] = $this->SizingDetail; $this->inv['errorSizingDetail'] = $this->errorSizingDetail;
        $this->inv['SellingPrice'] = $this->SellingPrice; $this->inv['errorSellingPrice'] = $this->errorSellingPrice;
        $this->inv['SalePrice'] = $this->SalePrice; $this->inv['errorSalePrice'] = $this->errorSalePrice;
        $this->inv['Weight'] = $this->Weight; $this->inv['errorWeight'] = $this->errorWeight;
        $this->inv['SKUPrinciple'] = $this->SKUPrinciple; $this->inv['errorSKUPrinciple'] = $this->errorSKUPrinciple;
        $this->inv['SKUSeller'] = $this->SKUSeller; $this->inv['errorSKUSeller'] = $this->errorSKUSeller;
        $this->inv['ProductGender'] = $this->ProductGender; $this->inv['errorProductGender'] = $this->errorProductGender;
        $this->inv['CompositionMaterial'] = $this->CompositionMaterial; $this->inv['errorCompositionMaterial'] = $this->errorCompositionMaterial;
        $this->inv['CareLabel'] = $this->CareLabel; $this->inv['errorCareLabel'] = $this->errorCareLabel;
        $this->inv['Measurement'] = $this->Measurement; $this->inv['errorMeasurement'] = $this->errorMeasurement;
        $this->inv['Popularity'] = $this->Popularity; $this->inv['errorPopularity'] = $this->errorPopularity;
        $this->inv['StatusNew'] = $this->StatusNew; $this->inv['errorStatusNew'] = $this->errorStatusNew;
        $this->inv['StatusSale'] = $this->StatusSale; $this->inv['errorStatusSale'] = $this->errorStatusSale;
        $this->inv['Image1'] = $this->Image1; $this->inv['errorImage1'] = $this->errorImage1;
        $this->inv['Image2'] = $this->Image2; $this->inv['errorImage2'] = $this->errorImage2;
        $this->inv['Image3'] = $this->Image3; $this->inv['errorImage3'] = $this->errorImage3;
        $this->inv['Image4'] = $this->Image4; $this->inv['errorImage4'] = $this->errorImage4;
        $this->inv['Image5'] = $this->Image5; $this->inv['errorImage5'] = $this->errorImage5;
        $this->inv['ProductLinkGroup'] = $this->ProductLinkGroup; $this->inv['errorProductLinkGroup'] = $this->errorProductLinkGroup;
        $this->inv['ProductLinkDisplay'] = $this->ProductLinkDisplay;
        $this->inv['IsActive'] = $this->IsActive; $this->inv['errorIsActive'] = $this->errorIsActive;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;
        $this->inv['permalink'] = $this->permalink; $this->inv['errorpermalink'] = $this->errorpermalink;
        $this->inv['StyleList'] = $this->StyleList; $this->inv['errorStyleList'] = $this->errorStyleList;

        return $this->_showview(["new"]);
    }

    public function uploadbulkproduct()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);
        $uploadbulkproduct = $erroruploadbulkproduct = '';

        $requestfile = \Request::file();

        if(isset($requestfile['uploadbulkproduct'])) {
            $uploadbulkproduct = $requestfile['uploadbulkproduct'];

            $uploadbulkproductname = $uploadbulkproduct->getPathName();
            $objPHPExcel = new \PHPExcel();

            try {
                $inputFileType = \PHPExcel_IOFactory::identify($uploadbulkproductname);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($uploadbulkproductname);
            } catch(Exception $e) {
                $erroruploadbulkproduct = 'Error loading file "'.pathinfo($uploadbulkproductname,PATHINFO_BASENAME).'": '.$e->getMessage();
            }

            $sheet = $objPHPExcel->getSheet(0);
            
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();

            $firstrow = $sheet->rangeToArray('A1'.':'.$highestColumn.'1');
            if(count($firstrow) == 1) $firstrow = $firstrow[0];

            if(!in_array($firstrow[1], [1,2,3,4])) {
                $this->inv['messageerror'] = 'Type not found !';
            } else if($highestRow < 3) {
                $this->inv['messageerror'] = 'Data not found !';
            } else {
                switch ($firstrow[1]) {
                    case 1:
                        $arraytitle = [
                            'SellerUniqueID' => 'Seller Code *',
                            'BrandID' => 'Brand ID *',
                            'MCSID' => 'MCS ID *',
                            'ColorID' => 'Color ID *',
                            'GroupSizeID' => 'Group Size ID *',
                            'SKUSeller' => 'SKU Seller *',
                            'Name' => 'Name *',
                            'NameShow' => 'Name Show *',
                            'Weight' => 'Weight *',
                            'SellingPrice' => 'Selling Price *',
                            'ProductGender' => 'Product Gender *',
                            'Measurement' => 'Measurement *',
                            'CompositionMaterial' => 'Composition Material',
                            'CareLabel' => 'Care Label',
                            'StatusNew' => 'Status New *',
                            'Description' => 'Description *',
                            'SizingDetail' => 'Sizing Detail *',
                            'Style' => 'Style *',
                            'ProductLink' => 'Product Link',
                        ];
                    break;
                    case 2:
                        $arraytitle = [
                            'SellerUniqueID' => 'Seller Code *',
                            'BrandID' => 'Brand ID *',
                            'MCSID' => 'MCS ID *',
                            'ColorID' => 'Color ID *',
                            'SKUSeller' => 'SKU Seller *',
                            'Name' => 'Name *',
                            'NameShow' => 'Name Show *',
                            'Weight' => 'Weight *',
                            'SellingPrice' => 'Selling Price *',
                            'ProductGender' => 'Product Gender *',
                            'Measurement' => 'Measurement *',
                            'CompositionMaterial' => 'Composition Material',
                            'CareLabel' => 'Care Label',
                            'StatusNew' => 'Status New *',
                            'Description' => 'Description *',
                            'SizingDetail' => 'Sizing Detail *',
                            'Style' => 'Style *',
                        ];
                    break;
                    case 3:
                        $arraytitle = [
                            'SellerUniqueID' => 'Seller Code *',
                            'BrandID' => 'Brand ID *',
                            'MCSID' => 'MCS ID *',
                            'ColorID' => 'Color ID *',
                            'GroupSizeID' => 'Group Size ID *',
                            'SKUSeller' => 'SKU Seller *',
                            'Name' => 'Name *',
                            'NameShow' => 'Name Show *',
                            'Weight' => 'Weight *',
                            'SellingPrice' => 'Selling Price *',
                            'SalePrice' => 'Sale Price *',
                            'ProductGender' => 'Product Gender *',
                            'Measurement' => 'Measurement *',
                            'CompositionMaterial' => 'Composition Material',
                            'CareLabel' => 'Care Label',
                            'Description' => 'Description *',
                            'SizingDetail' => 'Sizing Detail *',
                            'Style' => 'Style *',
                            'ProductLink' => 'Product Link',
                        ];
                    break;
                    case 4:
                        $arraytitle = [
                            'SellerUniqueID' => 'Seller Code *',
                            'BrandID' => 'Brand ID *',
                            'MCSID' => 'MCS ID *',
                            'ColorID' => 'Color ID *',
                            'SKUSeller' => 'SKU Seller *',
                            'Name' => 'Name *',
                            'NameShow' => 'Name Show *',
                            'Weight' => 'Weight *',
                            'SellingPrice' => 'Selling Price *',
                            'SalePrice' => 'Sale Price *',
                            'ProductGender' => 'Product Gender *',
                            'Measurement' => 'Measurement *',
                            'CompositionMaterial' => 'Composition Material',
                            'CareLabel' => 'Care Label',
                            'Description' => 'Description *',
                            'SizingDetail' => 'Sizing Detail *',
                            'Style' => 'Style *',
                        ];
                    break;
                };

                $this->_loaddbclass(['Seller','Brand','Category','SubCategory','GroupSize','Color','Style']);
                
                $array = array_keys($arraytitle);
                for ($row = 3; $row <= $highestRow; $row++) {
                    $rowdata = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                    if(count($rowdata) == 1) $rowdata = $rowdata[0];
                    if(count($rowdata) < count($array)) $this->inv['messageerror'] .= 'Excel Error : Row '.($row-1).' is not completed column !<br/>';

                    $arrayresult = [];
                    $index = 0;
                    foreach ($rowdata as $key => $value) {
                        $arrayresult[$array[$index]] = $value;
                        $index++;
                    }

                    if($firstrow[1] == 1 || $firstrow[1] == 2) {
                        $arrayresult['StatusSale'] = 0;
                        $arrayresult['SalePrice'] = 0;
                    } else {
                        $arrayresult['StatusSale'] = 1;
                        $arrayresult['StatusNew'] = 0;
                    }

                    if($firstrow[1] == 2 || $firstrow[1] == 4) {
                        $arrayresult['TypeProduct'] = 1;
                    } else {
                        $arrayresult['TypeProduct'] = 0;
                    }

                    $arrayresult['CurrencyCode'] = 'IDR';

                    $SellerUniqueID = $arrayresult['SellerUniqueID'];
                    $SellerData = $this->Seller->where([[$array[0], '=', $SellerUniqueID]])->first();
                    $SellerSession = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();

                    if($SellerUniqueID && $SellerData && $SellerSession && $SellerData->SellerUniqueID == $SellerSession->SellerUniqueID) {
                        $arrayresult['SellerID'] = $SellerData->ID;
                        unset($arrayresult['SellerUniqueID']);
                        $BrandID = $arrayresult['BrandID'];
                        $Brand = $this->Brand->where([['ID', '=', ltrim($BrandID, 'B')]])->first();

                        if($BrandID && substr($BrandID, 0, 1) == 'B' && $Brand && $Brand->SellerID == $SellerSession->ID) {
                            $arrayresult['BrandID'] = $Brand->ID;
                            $MCSID = $arrayresult['MCSID'];

                            $ModelType = '';
                            switch ($MCSID[0]) {
                                case 'K':
                                    $ModelType = 'KIDS';
                                break;
                                case 'M':
                                    $ModelType = 'MEN';
                                break;
                                case 'W':
                                    $ModelType = 'WOMEN';
                                break;
                            }

                            $CategoryID = $SubCategoryID = 0;
                            list($CategoryID, $SubCategoryID) = explode('-', ltrim($MCSID, $MCSID[0]));

                            $Category = $this->Category->where([['ModelType', '=', $ModelType],['ID', '=', $CategoryID]])->first();

                            if($SubCategoryID)
                                $SubCategory = $this->SubCategory->where([['IDCategory', '=', $CategoryID],['ID', '=', $SubCategoryID]])->first();

                            if($MCSID && $ModelType && $Category && ($SubCategoryID && $SubCategory)) {
                                $arrayresult['ModelType'] = $ModelType;
                                $arrayresult['CategoryID'] = $CategoryID;
                                $arrayresult['SubCategoryID'] = $SubCategoryID;
                                unset($arrayresult['MCSID']);

                                if($firstrow[1] == 1 || $firstrow[1] == 3) {
                                    $GroupSizeID = $arrayresult['GroupSizeID'];
                                    $GroupSize = $this->GroupSize->where([['ID', '=', ltrim($GroupSizeID, 'G')]])->first();
                                }

                                if((($firstrow[1] == 1 || $firstrow[1] == 3) && $GroupSizeID && substr($GroupSizeID, 0, 1) == 'G' && $GroupSize) || $firstrow[1] != 1 && $firstrow[1] != 3) {
                                    if($firstrow[1] == 1 || $firstrow[1] == 3) {
                                        $arrayresult['GroupSizeID'] = $GroupSize->ID;
                                    }
                                    
                                    $ColorID = $arrayresult['ColorID'];
                                    $Color = $this->Color->where([['ID', '=', ltrim($ColorID, 'C')]])->first();

                                    if($ColorID && substr($ColorID, 0, 1) == 'C') {
                                        $arrayresult['ColorID'] = $Color->ID;
                                        $SKUSeller = $arrayresult['SKUSeller'];
                                        if($SKUSeller) {
                                            $this->_loaddbclass(['Product']);

                                            $SKUSellerProduct = $this->Product->where([['SellerID','=',$arrayresult['SellerID']],['BrandID','=',$arrayresult['BrandID']],['ModelType','=',$arrayresult['ModelType']],['CategoryID','=',$arrayresult['CategoryID']],['SKUSeller','=',$arrayresult['SKUSeller']],['Status','=',0]])->first();

                                            if(!($SKUSellerProduct && $SKUSellerProduct->SellerID == $SellerSession->ID && $SKUSellerProduct->BrandID == $arrayresult['BrandID'] && $SKUSellerProduct->ModelType == $arrayresult['ModelType'] && $SKUSellerProduct->CategoryID == $arrayresult['CategoryID'] && $SKUSellerProduct->SKUSeller == $arrayresult['SKUSeller'])) {

                                                $Name = $arrayresult['Name'];

                                                if($Name) {
                                                    $NameShow = $arrayresult['NameShow'];
                                                    if($NameShow) {
                                                        $Weight = $arrayresult['Weight'];
                                                        if(is_numeric($Weight)) {
                                                            $SellingPrice = $arrayresult['SellingPrice'];
                                                            if(is_numeric($SellingPrice)) {
                                                                $ProductGender = $arrayresult['ProductGender'];
                                                                if(is_numeric($ProductGender)) {
                                                                    $Measurement = $arrayresult['Measurement'];
                                                                    if($Measurement) {
                                                                        $CompositionMaterial = $arrayresult['CompositionMaterial'];
                                                                        $CareLabel = $arrayresult['CareLabel'];
                                                                        $StatusNew = $arrayresult['StatusNew'];
                                                                        if(is_numeric($StatusNew)) {
                            $StatusSale = $arrayresult['StatusSale'];
                            if(is_numeric($StatusSale)) {
                                $SalePrice = $arrayresult['SalePrice'];
                                if($StatusSale == 0 || ($StatusSale == 1 && is_numeric($SalePrice))) {
                                    if($StatusSale == 0) $arrayresult['SalePrice'] = '0';
                                    $Description = $arrayresult['Description'];
                                    if($Description) {
                                        $SizingDetail = $arrayresult['SizingDetail'];
                                        if($SizingDetail) {
                            $Style = $arrayresult['Style'];
                            if($Style) {
                                $StyleList = explode(',', $Style);
                                $ArrStyleList = [];
                                foreach ($StyleList as $StyleID) {
                                    $Style = $this->Style->where([['ID', '=', ltrim($StyleID, 'S')]])->first();

                                    if($StyleID && substr($StyleID, 0, 1) == 'S' && $StyleID) {
                                        $ArrStyleList[] = $Style->ID;
                                    }
                                }
                                if(count($StyleList) == count($ArrStyleList)) {
                                    $Style = $arrayresult['Style'];
                                    unset($arrayresult['Style']);

                                    $newarray = $arrayresult;

                                    $this->_loaddbclass(['Product','ProductLink','ProductDetailStyle']);
                                    
                                    // $Product = $this->Product->where([['SellerID','=',$newarray['SellerID']],['BrandID','=',$newarray['BrandID']],['ModelType','=',$newarray['ModelType']],['CategoryID','=',$newarray['CategoryID']],['Name','=',$newarray['Name']],['Status','=',0]])->first();

                                    $checkerror = false;
                                    // if($Product) {
                                    //     if($Product->SellerID == $SellerSession->ID && $Product->BrandID == $newarray['BrandID'] && $Product->ModelType == $newarray['ModelType'] && $Product->CategoryID == $newarray['CategoryID'] && $Product->Name == $newarray['Name']) {
                                    //         $checkerror = true;
                                    //     } else $checkerror = false;
                                    // } else $checkerror = false;

                                    if(!$checkerror) {
                                        $userdata =  \Session::get('userdata');
                                        $userid =  $userdata['uuserid'];
                                        
                                        $SKUPrinciple = $this->_dbgetlastincrement(env('DB_DATABASE'), 'product');
                                        $SKUPrinciple = 'LP'.date("ymdhms").sprintf('%03d', $SKUPrinciple);
                                        $newarray['SKUPrinciple'] = $SKUPrinciple;
                                        $newarray['IsActive'] = 1;
                                        $newarray['Status'] = 0;
                                        $newarray['CreatedDate'] = new \DateTime("now");
                                        $newarray['CreatedBy'] = $userid;

                                        $Product = $this->Product->creates($newarray);
                                        
                                        $this->_dblog('addnew', $this, 'Success : SKU '.$newarray['SKUSeller'].' - '.$SKUPrinciple.', Row '.($row-1).' !');
                                        $this->inv['messagesuccess'] .= 'Success Saving : SKU '.$newarray['SKUSeller'].' - '.$SKUPrinciple.', Row '.($row-1).' !<br/>';
                                        
                                        $newarray['permalink'] = $this->_permalink($newarray['Name'].' '.$Product->ID);
                                        $Product->update($newarray);

                                        if($firstrow[1] == 1 || $firstrow[1] == 3) {
                                            $this->_loaddbclass([ 'ProductLink' ]);
                                            if($newarray['ProductLink']) {
                                                $tmpProduct = $this->Product->where([['SKUSeller','=',$newarray['ProductLink']]])->first();
                                                $ProductLink = $this->ProductLink->where([['ProductID', '=', $tmpProduct->ID]])->first();
                                                if($ProductLink) {
                                                    $this->_loaddbclass([ 'ProductLink' ]);
                                                    $tmpProductLink = $this->ProductLink->where([['ProductID', '=', $Product->ID]])->first();
                                                    if($tmpProductLink) {
                                                        $tmpProductLink->update(['ProductLink','=',$ProductLink->ProductLinkGroup]);
                                                    } else {
                                                        $arraylink = [
                                                            'ProductID' => $Product->ID,
                                                            'ProductLinkGroup' => $ProductLink->ProductLinkGroup
                                                        ];
                                                        $this->ProductLink->creates($arraylink);
                                                    }
                                                } else {
                                                    $ProductLinkGroup = strtoupper(uniqid());
                                                    $arraylink = [
                                                        [
                                                            'ProductID' => $Product->ID,
                                                            'ProductLinkGroup' => $ProductLinkGroup
                                                        ],
                                                        [
                                                            'ProductID' => $tmpProduct->ID,
                                                            'ProductLinkGroup' => $ProductLinkGroup
                                                        ],
                                                    ];

                                                    $this->ProductLink->inserts($arraylink);
                                                }
                                            } else {
                                                $ProductLinkGroup = strtoupper(uniqid());
                                                $ProductLink = $this->ProductLink->where([['ProductID', '=', $Product->ID]])->first();
                                                if($ProductLink) {
                                                    $ProductLink->update(['ProductLinkGroup' => $ProductLinkGroup]);
                                                } else {
                                                    $arraylink = [
                                                        'ProductID' => $Product->ID,
                                                        'ProductLinkGroup' => $ProductLinkGroup
                                                    ];
                                                    $this->ProductLink->creates($arraylink);
                                                }
                                            }
                                        }

                                        foreach($this->ProductDetailStyle->where([['ProductID','=',$Product->ID]])->get() as $obj) {
                                            $obj->delete();
                                        }

                                        $arrayStyle = [];
                                        foreach ($ArrStyleList as $key) {
                                            $arrayStyle[] = [
                                                'ProductID' => $Product->ID,
                                                'StyleID' => $key
                                            ];
                                        }

                                        $this->ProductDetailStyle->inserts($arrayStyle);
                                    } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Name']).' duplicated !<br/>';
                                } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Style']).' error !<br/>';
                            } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Style']).' error !<br/>';
                                        } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['SizingDetail']).' error !<br/>';
                                    } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Description']).' error !<br/>';
                                } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['SalePrice']).' error !<br/>';
                            } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['StatusSale']).' error !<br/>';
                                                                        } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['StatusNew']).' error !<br/>';
                                                                    } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Measurement']).' error !<br/>';
                                                                } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['ProductGender']).' error !<br/>';
                                                            } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['SellingPrice']).' error !<br/>';
                                                        } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Weight']).' error !<br/>';
                                                    } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['NameShow']).' error !<br/>';
                                                } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Name']).' error !<br/>';
                                            } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$SKUSeller.' Duplicated, Row '.($row-1).' error !<br/>';
                                        } else $this->inv['messageerror'] .= 'Excel Error : SKU None, Row '.($row-1).' error !<br/>';
                                    } else $this->inv['messageerror'] .= 'Excel Error : ColorID '.$arrayresult['ColorID'].', Row '.($row-1).' error !<br/>';
                                } else $this->inv['messageerror'] .= 'Excel Error : GroupSizeID '.$arrayresult['GroupSizeID'].', Row '.($row-1).' error !<br/>';
                            } else $this->inv['messageerror'] .= 'Excel Error : MSCID '.$arrayresult['MCSID'].', Row '.($row-1).' error !<br/>';
                        } else $this->inv['messageerror'] .= 'Excel Error : BrandID '.$arrayresult['BrandID'].', Row '.($row-1).' error !<br/>';
                    } else $this->inv['messageerror'] .= 'Excel Error : SellerCode '.$arrayresult['SellerUniqueID'].', Row '.($row-1).' error !<br/>';
                }
                $this->inv['messagesuccess'] = rtrim($this->inv['messagesuccess'], '<br/>');
                $this->inv['messageerror'] = rtrim($this->inv['messageerror'], '<br/>');
            }
        }

        $this->inv['uploadbulkproduct'] = $uploadbulkproduct; $this->inv['erroruploadbulkproduct'] = $erroruploadbulkproduct;
        return $this->_showview(["dashboard.products.uploadbulkproduct"]);
    }

    public function uploadbulkimage()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);
        $uploadbulkimage = $erroruploadbulkimage = '';

        $arraytitle = [
            'SKUSeller' => 'SKU Seller *',
            'Image1' => 'Image 1 *',
            'Image2' => 'Image 2 *',
            'Image3' => 'Image 3 *',
            'Image4' => 'Image 4 *',
            'Image5' => 'Image 5 *',
        ];

        $requestfile = \Request::file();

        if(isset($requestfile['uploadbulkimage'])) {
            $uploadbulkimage = $requestfile['uploadbulkimage'];

            $uploadbulkproductname = $uploadbulkimage->getPathName();
            $objPHPExcel = new \PHPExcel();

            try {
                $inputFileType = \PHPExcel_IOFactory::identify($uploadbulkproductname);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($uploadbulkproductname);
            } catch(Exception $e) {
                $erroruploadbulkproduct = 'Error loading file "'.pathinfo($uploadbulkproductname,PATHINFO_BASENAME).'": '.$e->getMessage();
            }

            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();

            $array = array_keys($arraytitle);
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowdata = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                if(count($rowdata) == 1) $rowdata = $rowdata[0];
                if(count($rowdata) < count($array)) $this->inv['messageerror'] .= 'Excel Error : Row '.($row-1).' is not completed column !<br/>';

                $arrayresult = [];
                $index = 0;
                foreach ($rowdata as $key => $value) {
                    $arrayresult[$array[$index]] = $value;
                    $index++;
                }

                $this->_loaddbclass(['Product']);

                $SKUSeller = $arrayresult['SKUSeller'];
                $ProductData = $this->Product->where([['SKUSeller', '=', $SKUSeller]])->first();
                if($ProductData) {
                    $Image1 = $arrayresult['Image1'];
                    $Image1filetype = '';
                    if($Image1 && $this->_checkimageurl($Image1, $Image1, $Image1filetype)) {
                        $Image2 = $arrayresult['Image2'];
                        $Image2filetype = '';
                        if($Image2 && $this->_checkimageurl($Image2, $Image2, $Image2filetype)) {
                            $Image3 = $arrayresult['Image3'];
                            $Image3filetype = '';
                            if(!$Image3 || ($Image3 && $this->_checkimageurl($Image3, $Image3, $Image3filetype))) {
                                $Image4 = $arrayresult['Image4'];
                                $Image4filetype = '';
                                if(!$Image4 || ($Image4 && $this->_checkimageurl($Image4, $Image4, $Image4filetype))) {
                                    $Image5 = $arrayresult['Image5'];
                                    $Image5filetype = '';
                                    if(!$Image5 || ($Image5 && $this->_checkimageurl($Image5, $Image5, $Image5filetype))) {
                                        $newarray = $arrayresult;

                                        if($newarray['Image1']) {
                                            $Image1Name = 'Image1_'.$ProductData->ID.$Image1filetype;
                                            $newarray['Image1'] = $Image1Name;
                                            $width = 570;
                                            $height = 850;
                                            $this->_imageurltofolder($Image1, base_path().$this->pathimage, $Image1Name, $width, $height);
                                            $this->_imageurltofolder($Image1, base_path().$this->pathimage, 'medium_'.$Image1Name, $width / 3, $height / 3);
                                            $this->_imageurltofolder($Image1, base_path().$this->pathimage, 'small_'.$Image1Name, $width / 6, $height / 6);
                                        }

                                        if($newarray['Image2']) {
                                            $Image2Name = 'Image2_'.$ProductData->ID.$Image2filetype;
                                            $newarray['Image2'] = $Image2Name;
                                            $width = 570;
                                            $height = 850;
                                            $this->_imageurltofolder($Image2, base_path().$this->pathimage, $Image2Name, $width, $height);
                                            $this->_imageurltofolder($Image2, base_path().$this->pathimage, 'medium_'.$Image2Name, $width / 3, $height / 3);
                                            $this->_imageurltofolder($Image2, base_path().$this->pathimage, 'small_'.$Image2Name, $width / 6, $height / 6);
                                        }

                                        if($newarray['Image3']) {
                                            $Image3Name = 'Image3_'.$ProductData->ID.$Image3filetype;
                                            $newarray['Image3'] = $Image3Name;
                                            $width = 570;
                                            $height = 850;
                                            $this->_imageurltofolder($Image3, base_path().$this->pathimage, $Image3Name, $width, $height);
                                            $this->_imageurltofolder($Image3, base_path().$this->pathimage, 'medium_'.$Image3Name, $width / 3, $height / 3);
                                            $this->_imageurltofolder($Image3, base_path().$this->pathimage, 'small_'.$Image3Name, $width / 6, $height / 6);
                                        }

                                        if($newarray['Image4']) {
                                            $Image4Name = 'Image4_'.$ProductData->ID.$Image4filetype;
                                            $newarray['Image4'] = $Image4Name;
                                            $width = 570;
                                            $height = 850;
                                            $this->_imageurltofolder($Image4, base_path().$this->pathimage, $Image4Name, $width, $height);
                                            $this->_imageurltofolder($Image4, base_path().$this->pathimage, 'medium_'.$Image4Name, $width / 3, $height / 3);
                                            $this->_imageurltofolder($Image4, base_path().$this->pathimage, 'small_'.$Image4Name, $width / 6, $height / 6);
                                        }

                                        if($newarray['Image5']) {
                                            $Image5Name = 'Image5_'.$ProductData->ID.$Image5filetype;
                                            $newarray['Image5'] = $Image5Name;
                                            $width = 570;
                                            $height = 850;
                                            $this->_imageurltofolder($Image5, base_path().$this->pathimage, $Image5Name, $width, $height);
                                            $this->_imageurltofolder($Image5, base_path().$this->pathimage, 'medium_'.$Image5Name, $width / 3, $height / 3);
                                            $this->_imageurltofolder($Image5, base_path().$this->pathimage, 'small_'.$Image5Name, $width / 6, $height / 6);
                                        }

                                        $userdata =  \Session::get('userdata');
                                        $userid =  $userdata['uuserid'];
                                        
                                        $newarray['UpdatedDate'] = new \DateTime("now");
                                        $newarray['UpdatedBy'] = $userid;

                                        $this->_dblog('addnew', $this, 'Success : SKU '.$newarray['SKUSeller'].' - '.$SKUSeller.', Row '.($row-1).' !');
                                        $this->inv['messagesuccess'] .= 'Success Saving : SKU '.$newarray['SKUSeller'].' - '.$SKUSeller.', Row '.($row-1).' !<br/>';

                                        $ProductData->update($newarray);
                                    } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Image5']).' error !<br/>';
                                } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Image4']).' error !<br/>';
                            } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Image3']).' error !<br/>';
                        } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Image2']).' error !<br/>';
                    } else $this->inv['messageerror'] .= 'Excel Error : SKU '.$arrayresult['SKUSeller'].', Row '.($row-1).', Note : '.str_replace(' *', '', $arraytitle['Image1']).' error !<br/>';

                } else $this->inv['messageerror'] .= 'Excel Error : SKUSeller '.$arrayresult['SKUSeller'].', Row '.($row-1).' Data not found !<br/>';
            }
            $this->inv['messagesuccess'] = rtrim($this->inv['messagesuccess'], '<br/>');
            $this->inv['messageerror'] = rtrim($this->inv['messageerror'], '<br/>');
        }

        $this->inv['uploadbulkimage'] = $uploadbulkimage; $this->inv['erroruploadbulkimage'] = $erroruploadbulkimage;
        return $this->_showview(["dashboard.products.uploadbulkimage"]);
    }
}