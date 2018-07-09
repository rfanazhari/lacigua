<?php
namespace App\Modules\dashboard\Http\Controllers\masterproduct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class productController extends Controller
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
        'ColorHexa' => 'ColorHexa',
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
        'CountPDSV' => 'CountPDSV',
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
        'SKUSeller' => ['SKU Seller', true],
        'Name' => ['Name', true],
        'NameShow' => ['Name Show'],
        'ModelType' => ['Model Type', true],
        'CategoryName' => ['Category Name', true],
        'SubCategoryName' => ['Sub Category Name', true],
        'TypeProduct' => ['Type Product', true],
        'ColorName' => ['Color Name'],
        'ColorHexa' => ['Color Hexa'],
        'Description' => ['Description'],
        'SizingDetail' => ['Sizing Detail'],
        'SellingPrice' => ['Selling Price'],
        'SalePrice' => ['Sale Price'],
        'Weight' => ['Weight'],
        'ProductGender' => ['Product Gender'],
        'CompositionMaterial' => ['Composition Material'],
        'CareLabel' => ['Care Label'],
        'Measurement' => ['Measurement'],
        'Popularity' => ['Popularity'],
        'StatusNew' => ['Status New'],
        'StatusSale' => ['Status Sale'],
        'Image1' => ['Image 1'],
        'Image2' => ['Image 2'],
        'Image3' => ['Image 3'],
        'Image4' => ['Image 4'],
        'Image5' => ['Image 5'],
        'ProductLinkGroup' => ['Product Link'],
        'CountPDSV' => ['Size Variant', true],
        'IsActive' => ['Is Active', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'permalink' => ['permalink'],
        'StyleList' => ['Style'],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/product/';
    var $objectkey = '', $ProductID = '', $errorProductID = '', $SellerID = '', $errorSellerID = '', $BrandID = '', $errorBrandID = '', $ModelType = '', $errorModelType = '', $CategoryID = '', $errorCategoryID = '', $SubCategoryID = '', $errorSubCategoryID = '', $TypeProduct = '', $errorTypeProduct = '', $ColorID = '', $errorColorID = '', $GroupSizeID = '', $errorGroupSizeID = '', $Name = '', $errorName = '', $NameShow = '', $errorNameShow = '', $Description = '', $errorDescription = '', $SizingDetail = '', $errorSizingDetail = '', $SellingPrice = '', $errorSellingPrice = '', $SalePrice = '', $errorSalePrice = '', $Weight = '', $errorWeight = '', $SKUPrinciple = '', $errorSKUPrinciple = '', $SKUSeller = '', $errorSKUSeller = '', $ProductGender = '', $errorProductGender = '', $CompositionMaterial = '', $errorCompositionMaterial = '', $CareLabel = '', $errorCareLabel = '', $Measurement = '', $errorMeasurement = '', $Popularity = '', $errorPopularity = '', $StatusNew = '', $errorStatusNew = '', $StatusSale = '', $errorStatusSale = '', $Image1 = '', $errorImage1 = '', $Image1filetype = '', $Image2 = '', $errorImage2 = '', $Image2filetype = '', $Image3 = '', $errorImage3 = '', $Image3filetype = '', $Image4 = '', $errorImage4 = '', $Image4filetype = '', $Image5 = '', $errorImage5 = '', $Image5filetype = '', $ProductLinkGroup = '', $errorProductLinkGroup = '', $ProductLinkDisplay = '', $IsActive = '', $errorIsActive = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '', $permalink = '', $errorpermalink = '', $StyleList = '', $errorStyleList = '', $lastid = '';

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
            if(isset($this->inv['getproductid'])) {
                $addurl = 'productid_'.$this->inv['getproductid'].'/';
                $getproductid = explode('-', $this->inv['getproductid']);
                $arraywhere = [['product.ID', '!=', end($getproductid)]];
            }
            if(isset($this->inv['getSellerID'])) {
                $arraywhere = [['product.SellerID', '=', $this->inv['getSellerID']]];
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
            $this->_loaddbclass([ 'Product', 'Brand', 'Category', 'SubCategory', 'SizeVariant' ]);
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
                $this->_loaddbclass([ 'Product' ]);

                $Product = $this->Product->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($Product) {
                    $this->ProductID = $Product[$this->inv['flip']['ProductID']];
                    $this->SellerID = $Product[$this->inv['flip']['SellerID']];
                    $this->BrandID = $Product[$this->inv['flip']['BrandID']];
                    $this->ModelType = $Product[$this->inv['flip']['ModelType']];
                    $this->CategoryID = $Product[$this->inv['flip']['CategoryID']];
                    $this->SubCategoryID = $Product[$this->inv['flip']['SubCategoryID']];
                    $this->TypeProduct = $Product[$this->inv['flip']['TypeProduct']];
                    $this->ColorID = $Product[$this->inv['flip']['ColorID']];
                    $this->GroupSizeID = $Product[$this->inv['flip']['GroupSizeID']];
                    $this->Name = $Product[$this->inv['flip']['Name']];
                    $this->NameShow = $Product[$this->inv['flip']['NameShow']];
                    $this->Description = $Product[$this->inv['flip']['Description']];
                    $this->SizingDetail = $Product[$this->inv['flip']['SizingDetail']];
                    $this->SellingPrice = $Product[$this->inv['flip']['SellingPrice']];
                    $this->SalePrice = $Product[$this->inv['flip']['SalePrice']];
                    $this->Weight = $Product[$this->inv['flip']['Weight']];
                    $this->SKUPrinciple = $Product[$this->inv['flip']['SKUPrinciple']];
                    $this->SKUSeller = $Product[$this->inv['flip']['SKUSeller']];
                    $this->ProductGender = $Product[$this->inv['flip']['ProductGender']];
                    $this->CompositionMaterial = $Product[$this->inv['flip']['CompositionMaterial']];
                    $this->CareLabel = $Product[$this->inv['flip']['CareLabel']];
                    $this->Measurement = $Product[$this->inv['flip']['Measurement']];
                    $this->Popularity = $Product[$this->inv['flip']['Popularity']];
                    $this->StatusNew = $Product[$this->inv['flip']['StatusNew']];
                    $this->StatusSale = $Product[$this->inv['flip']['StatusSale']];

                    if($Product[$this->inv['flip']['Image1']])
                        $this->Image1 = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'medium_'.$Product[$this->inv['flip']['Image1']]; 
                    
                    if($Product[$this->inv['flip']['Image2']])
                        $this->Image2 = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'medium_'.$Product[$this->inv['flip']['Image2']]; 
                    
                    if($Product[$this->inv['flip']['Image3']])
                        $this->Image3 = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'medium_'.$Product[$this->inv['flip']['Image3']]; 
                    
                    if($Product[$this->inv['flip']['Image4']])
                        $this->Image4 = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'medium_'.$Product[$this->inv['flip']['Image4']]; 
                    
                    if($Product[$this->inv['flip']['Image5']])
                        $this->Image5 = $this->inv['basesite'].str_replace('/resources/', '', $this->pathimage).
                    'medium_'.$Product[$this->inv['flip']['Image5']]; 

                    $this->_loaddbclass([ 'ProductLink' ]);
                    $ProductLink = $this->ProductLink->where([['ProductID', '=', $this->ProductID]])->first();
                    if($ProductLink && $this->inv['action'] != 'copy') {
                        $this->_loaddbclass([ 'ProductLink' ]);
                        $ProductLink = $this->ProductLink->leftjoin([
                            ['product as p', 'p.ID', '=', 'product_link.ProductID']
                        ])->where([['ProductLinkGroup', '=', $ProductLink->ProductLinkGroup],['ProductID', '!=', $this->ProductID]])->first();
                        if($ProductLink) {
                            $this->ProductLinkGroup = $ProductLink->ProductID;
                            $this->ProductLinkDisplay = $ProductLink->SKUPrinciple.' - '.$ProductLink->Name;
                        }
                    }
                    
                    $this->IsActive = $Product[$this->inv['flip']['IsActive']];
                    $this->Status = $Product[$this->inv['flip']['Status']];
                    $this->CreatedDate = $Product[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $Product[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $Product[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $Product[$this->inv['flip']['UpdatedBy']];
                    $this->permalink = $Product[$this->inv['flip']['permalink']];

                    $this->_loaddbclass(['ProductDetailStyle']);

                    $this->StyleList = $this->ProductDetailStyle->where([['ProductID','=',$Product[$this->inv['flip']['ProductID']]]])->pluck('StyleID')->toArray();
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
        $this->_loaddbclass([ 'Product', 'Category', 'SubCategory',  'ProductDetailStyle' ]);

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
                    ['value' => $this->_trans('dashboard.masterproduct.Product.SellerName')]
                );
            }

            $this->BrandID = $request['BrandID'];
            if(empty($this->BrandID)) {
                $this->errorBrandID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.BrandName')]
                );
            }
            
            $this->ModelType = $request['ModelType'];
            if(empty($this->ModelType)) {
                $this->errorModelType = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.ModelType')]
                );
            }

            $this->CategoryID = $request['CategoryID'];
            if(empty($this->CategoryID)) {
                $this->errorCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.CategoryName')]
                );
            }

            $this->SKUSeller = $request['SKUSeller'];
            if(empty($this->SKUSeller)) {
                $this->errorSKUSeller = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.SKUSeller')]
                );
            }

            $Product = $this->Product->where([[$this->inv['flip']['SellerID'],'=',$this->SellerID],[$this->inv['flip']['BrandID'],'=',$this->BrandID],[$this->inv['flip']['ModelType'],'=',$this->ModelType],[$this->inv['flip']['CategoryID'],'=',$this->CategoryID],[$this->inv['flip']['SKUSeller'],'=',$this->SKUSeller],['Status','=',0]])->first();

            if($Product) {
                if(isset($request['addnew']) && $Product->SellerID == $this->SellerID && $Product->BrandID == $this->BrandID && $Product->ModelType == $this->ModelType && $Product->CategoryID == $this->CategoryID && $Product->SKUSeller == $this->SKUSeller) {
                    if(!$this->errorSKUSeller) {
                        $this->errorSKUSeller = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.masterproduct.Product.SKUSeller')]
                        );
                    }
                } else {
                    if ($Product[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorSKUSeller) {
                            $this->errorSKUSeller = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.masterproduct.Product.SKUSeller')]
                            );
                        }
                    }
                }
            }

            $this->Name = $request['Name'];
            if(empty($this->Name)) {
                $this->errorName = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Name')]
                );
            }

            $SubCategory = $this->SubCategory->where([['IDCategory','=',$this->CategoryID]])->get()->count();
            if($SubCategory > 0) {
                $this->SubCategoryID = $request['SubCategoryID'];
                if(empty($this->SubCategoryID)) {
                    $this->errorSubCategoryID = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.masterproduct.Product.SubCategoryName')]
                    );
                }
            }

            if(empty($this->CategoryID) && empty($this->SubCategoryID)) {
                $this->errorCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.CategoryName')]
                );
                $this->errorSubCategoryID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.SubCategoryName')]
                );
            }

            $this->TypeProduct = $request['TypeProduct'];

            if($this->TypeProduct == 0) {
                $this->GroupSizeID = $request['GroupSizeID'];
                if(empty($this->GroupSizeID)) {
                    $this->errorGroupSizeID = $this->_trans('validation.mandatory', 
                        ['value' => $this->_trans('dashboard.masterproduct.Product.GroupSizeName')]
                    );
                }
            }
            
            $this->ColorID = $request['ColorID'];
            if(empty($this->ColorID)) {
                $this->errorColorID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.productsize.ColorName')]
                );
            }

            $this->NameShow = $request['NameShow'];
            if(empty($this->NameShow)) {
                $this->errorNameShow = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.NameShow')]
                );
            }

            $this->Description = $request['Description'];
            if(empty($this->Description)) {
                $this->errorDescription = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Description')]
                );
            }

            $this->SizingDetail = $request['SizingDetail'];
            if(empty($this->SizingDetail)) {
                $this->errorSizingDetail = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.SizingDetail')]
                );
            }

            $this->StatusNew = $request['StatusNew'];
            if(!is_numeric($this->StatusNew)) {
                $this->errorStatusNew = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.StatusNew')]
                );
            }

            $this->StatusSale = $request['StatusSale'];
            if(!is_numeric($this->StatusSale)) {
                $this->errorStatusSale = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.StatusSale')]
                );
            }

            $this->SellingPrice = $request['SellingPrice'];
            if(empty($this->SellingPrice)) {
                $this->errorSellingPrice = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.SellingPrice')]
                );
            }

            $this->SalePrice = $request['SalePrice'];
            if($this->StatusSale && empty($this->SalePrice)) {
                $this->errorSalePrice = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.SalePrice')]
                );
            }

            $this->Weight = $request['Weight'];
            if(empty($this->Weight)) {
                $this->errorWeight = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Weight')]
                );
            }

            $this->ProductGender = $request['ProductGender'];
            if(!is_numeric($this->ProductGender)) {
                $this->errorProductGender = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.ProductGender')]
                );
            }

            $this->CompositionMaterial = $request['CompositionMaterial'];

            $this->CareLabel = $request['CareLabel'];

            $this->Measurement = $request['Measurement'];
            if(empty($this->Measurement)) {
                $this->errorMeasurement = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Measurement')]
                );
            }

            if(isset($requestfile['Image1'])) $this->Image1 = $requestfile['Image1'];
            else $this->Image1 = '';
            if(empty($this->Image1) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image1']])) {
                $this->errorImage1 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image1')]
                );
            }
            if($this->Image1 && !$this->_checkimage($this->Image1, $this->Image1filetype)) {
                $this->errorImage1 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image1')]
                );
            }

            if(isset($requestfile['Image2'])) $this->Image2 = $requestfile['Image2'];
            else $this->Image2 = '';
            if(empty($this->Image2) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image2']])) {
                $this->errorImage2 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image2')]
                );
            }
            if($this->Image2 && !$this->_checkimage($this->Image2, $this->Image2filetype)) {
                $this->errorImage2 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image2')]
                );
            }

            if(isset($requestfile['Image3'])) $this->Image3 = $requestfile['Image3'];
            else $this->Image3 = '';
            if(empty($this->Image3) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image3']])) {
                $this->errorImage3 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image3')]
                );
            }
            if($this->Image3 && !$this->_checkimage($this->Image3, $this->Image3filetype)) {
                $this->errorImage3 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image3')]
                );
            }

            if(isset($requestfile['Image4'])) $this->Image4 = $requestfile['Image4'];
            else $this->Image4 = '';
            if(empty($this->Image4) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image4']])) {
                $this->errorImage4 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image4')]
                );
            }
            if($this->Image4 && !$this->_checkimage($this->Image4, $this->Image4filetype)) {
                $this->errorImage4 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image4')]
                );
            }

            if(isset($requestfile['Image5'])) $this->Image5 = $requestfile['Image5'];
            else $this->Image5 = '';
            if(empty($this->Image5) && !(isset($request['edit']) && $GetProduct[$this->inv['flip']['Image5']])) {
                $this->errorImage5 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image5')]
                );
            }
            if($this->Image5 && !$this->_checkimage($this->Image5, $this->Image5filetype)) {
                $this->errorImage5 = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.Image5')]
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
                                    ['value' => $this->_trans('dashboard.masterproduct.Product.ProductLinkGroup')]
                                );
                            }
                        }
                    }
                }
            }

            if(isset($request['StyleList'])) $this->StyleList = $request['StyleList'];
            else {
                $this->errorStyleList = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.masterproduct.Product.StyleList')]
                );
            }

            if(!$this->inv['messageerror'] && !$this->errorProductID && !$this->errorSellerID && !$this->errorBrandID && !$this->errorModelType && !$this->errorCategoryID && !$this->errorSubCategoryID && !$this->errorTypeProduct && !$this->errorColorID && !$this->errorGroupSizeID && !$this->errorName && !$this->errorNameShow && !$this->errorDescription && !$this->errorSizingDetail && !$this->errorSellingPrice && !$this->errorStyleList && !$this->errorSalePrice && !$this->errorWeight && !$this->errorSKUPrinciple && !$this->errorSKUSeller && !$this->errorProductGender && !$this->errorCompositionMaterial && !$this->errorCareLabel && !$this->errorMeasurement && !$this->errorPopularity && !$this->errorStatusNew && !$this->errorStatusSale && !$this->errorImage1 && !$this->errorImage2 && !$this->errorImage3 && !$this->errorImage4 && !$this->errorImage5 && !$this->errorProductLinkGroup && !$this->errorIsActive && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy && !$this->errorpermalink) 
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
                    \Session::put('messagesuccess', "Saving $this->Name Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $Product = $this->Product->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $Product->update($array);
                    
                    $this->_dblog('edit', $this, $this->Name);
                    \Session::put('messagesuccess', "Update $this->Name Completed !");
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

                return $this->_redirect(get_class());
            }
        }

        $this->_loaddbclass([ 'Seller','Brand','SubCategory','Color','Style','GroupSize']);
        
        $this->arrSeller = $this->Seller->where([['Status','=',0],['IsActive','=',1]])->orderBy('FullName','ASC')->get()->toArray();
        $this->inv['arrSeller'] = $this->arrSeller;

        $arrStyle = $this->Style->get()->toArray();
        $this->inv['arrStyle'] = $arrStyle;

        if(empty($this->SellerID)) {
            $this->inv['arrBrand'] = [];
        } else {
            $this->arrBrand = $this->Brand->where([['SellerID','=',$this->SellerID],['Status','=',0],['IsActive','=',1]])->orderBy('Name','ASC')->get()->toArray();
            $this->inv['arrBrand'] = $this->arrBrand;
        }

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

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass(['Product','ProductLink']);

            foreach($this->inv['delete'] as $val) {
                $Product = $this->Product->where([[$this->objectkey,'=',$val]])->first();
                if($Product) {
                    $this->ProductID = $Product[$this->inv['flip']['ProductID']];
                    $this->Name = $Product[$this->inv['flip']['Name']];
                    
                    $array[$this->inv['flip']['IsActive']] = 0;
                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['permalink']] = '';
                    
                    if($Product[$this->inv['flip']['Image1']]) {
                        @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image1']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image1']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image1']]);
                    }

                    if($Product[$this->inv['flip']['Image2']]) {
                        @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image2']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image2']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image2']]);
                    }

                    if($Product[$this->inv['flip']['Image3']]) {
                        @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image3']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image3']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image3']]);
                    }

                    if($Product[$this->inv['flip']['Image4']]) {
                        @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image4']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image4']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image4']]);
                    }

                    if($Product[$this->inv['flip']['Image5']]) {
                        @unlink(base_path().$this->pathimage.$Product[$this->inv['flip']['Image5']]);
                        @unlink(base_path().$this->pathimage.'medium_'.$Product[$this->inv['flip']['Image5']]);
                        @unlink(base_path().$this->pathimage.'small_'.$Product[$this->inv['flip']['Image5']]);
                    }

                    $ProductLink = $this->ProductLink->where([['ProductID', '=', $this->ProductID]])->first();
                    if($ProductLink) {
                        $ProductLink->delete();
                    }

                    $Product->update($array);

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
        $arrTypeProduct = [
            '0' => 'Fashion',
            '1' => 'Beauty',
        ];

        $this->_loaddbclass([ 'Product' ]);

        $result = $this->Product->leftJoin([
            ['seller','product.SellerID','=','seller.ID'],
            ['brand','product.BrandID','=','brand.ID'],
            ['category','product.CategoryID','=','category.ID'],
            ['sub_category','product.SubCategoryID','=','sub_category.ID'],
            ['colors','product.ColorID','=','colors.ID'],
        ])->select([
            'seller.FullName as SellerName',
            'brand.Name as BrandName',
            'category.Name as CategoryName',
            'sub_category.Name as SubCategoryName',
            'colors.Name as ColorName',
            'colors.Hexa as ColorHexa',
            \DB::raw('(select count(product_detail_size_variant.ID) from product_detail_size_variant where product.ID = product_detail_size_variant.ProductID and product_detail_size_variant.Status = 0) as CountPDSV'),
            'product.*'
        ])->where(array_merge([['product.Status','=',0]], $arraywhere))->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        $this->inv['flip']['SellerName'] = 'seller.Name';
        $this->inv['flip']['BrandName'] = 'brand.Name';
        $this->inv['flip']['CategoryName'] = 'category.Name';
        $this->inv['flip']['SubCategoryName'] = 'sub_category.Name';
        $this->inv['flip']['ModelType'] = 'product.ModelType';
        $this->inv['flip']['ColorName'] = 'colors.Name';
        $this->inv['flip']['CountPDSV'] = \DB::raw('(select count(product_detail_size_variant.ID) from product_detail_size_variant where product.ID = product_detail_size_variant.ProductID) as CountPDSV');

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['SellerName'] = 'SellerName';
        $this->inv['flip']['BrandName'] = 'BrandName';
        $this->inv['flip']['CategoryName'] = 'CategoryName';
        $this->inv['flip']['SubCategoryName'] = 'SubCategoryName';
        $this->inv['flip']['ModelType'] = 'ModelType';
        $this->inv['flip']['ColorName'] = 'ColorName';
        $this->inv['flip']['CountPDSV'] = 'CountPDSV';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            for($i = 0; $i < count($result['data']); $i++) {
                if($result['data'][$i][$this->inv['flip']['StatusNew']])
                    $result['data'][$i][$this->inv['flip']['Name']] = '<span class="label label-sm label-info">New</span> '.$result['data'][$i][$this->inv['flip']['Name']];
                if($result['data'][$i][$this->inv['flip']['StatusSale']])
                    $result['data'][$i][$this->inv['flip']['Name']] = '<span class="label label-sm label-danger">Sale</span> '.$result['data'][$i][$this->inv['flip']['Name']];

                if($result['data'][$i][$this->inv['flip']['Image1']] == '') {
                    $result['data'][$i][$this->inv['flip']['SKUPrinciple']] = '<span class="img-tool label label-sm label-info" style="background-color:red;" data-toggle="tooltip" data-placement="right" data-html="true" title="<img src=\''.$this->inv['basesite'] . 'assets/frontend/images/material/noimage.jpg\' width=\'100%\' height=\'100%\' />">'.$result['data'][$i][$this->inv['flip']['SKUPrinciple']].'</span>';
                } else {
                    $result['data'][$i][$this->inv['flip']['SKUPrinciple']] = '<span class="img-tool" data-toggle="tooltip" data-placement="right" data-html="true" title="<img src=\''.$this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) .
                        'medium_'.$result['data'][$i][$this->inv['flip']['Image1']].'\' width=\'100%\' height=\'100%\' />">'.$result['data'][$i][$this->inv['flip']['SKUPrinciple']].'</span>';
                }

                if($result['data'][$i][$this->inv['flip']['ColorHexa']] == '#FFFFFF') $color = 'black';
                else $color = 'white';

                $result['data'][$i][$this->inv['flip']['TypeProduct']] = '<span class="label label-sm label-info" style="background-color:'.$result['data'][$i][$this->inv['flip']['ColorHexa']].';color:'.$color.'">'.$arrTypeProduct[$result['data'][$i][$this->inv['flip']['TypeProduct']]].'</span>';
                
                if($result['data'][$i][$this->inv['flip']['CountPDSV']]) $result['data'][$i][$this->inv['flip']['CountPDSV']] = '<span class="label label-sm label-success">Ready</span>';
                else $result['data'][$i][$this->inv['flip']['CountPDSV']] = '<span class="label label-sm label-danger">Not Ready</span>';

                $checkactive = '';
                if($result['data'][$i][$this->inv['flip']['IsActive']] == 1)
                    $checkactive = 'checked';
                $result['data'][$i][$this->inv['flip']['IsActive']] = '<input type="checkbox" data-size="small" class="make-switch IsActive '.$result['data'][$i][$this->inv['flip']['ProductID']].'" data-on-text="Yes" data-off-text="No" data-on-color="success" data-off-color="danger" '.$checkactive.' rel="Anda yakin ingin merubah status ?">';
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}