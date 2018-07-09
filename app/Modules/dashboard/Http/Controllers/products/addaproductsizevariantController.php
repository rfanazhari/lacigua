<?php
namespace App\Modules\dashboard\Http\Controllers\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class addaproductsizevariantController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => true,
        'refresh'   => true,
        'downloadbulksizevariant' => true,
        'uploadbulksizevariant' => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'ProductDetailSizeID',
        'ProductID' => 'ProductID',
        'SKUPrinciple' => 'SKUPrinciple',
        'ProductName' => 'ProductName',
        'SizeVariantID' => 'SizeVariantID',
        'SizeVariantName' => 'SizeVariantName',
        'Qty' => 'Qty',
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
        'ProductDetailSizeID' => ['Product Detail Size Variant ID'],
        'ProductID' => ['Product ID'],
        'SKUPrinciple' => ['Product Code', true],
        'ProductName' => ['Product Name', true],
        'SizeVariantID' => ['Size Variant ID'],
        'SizeVariantName' => ['Size Variant Name', true],
        'Qty' => ['Qty', true],
        'Status' => ['Status'],
        'CreatedDate' => ['Created Date'],
        'CreatedBy' => ['Created By'],
        'UpdatedDate' => ['Updated Date'],
        'UpdatedBy' => ['Updated By'],
        'downloadbulksizevariant' => ['Download Bulk Size Variant'],
        'uploadbulksizevariant' => ['Upload Bulk Size Variant'],
    ];

    var $objectkey = '', $ProductDetailSizeID = '', $errorProductDetailSizeID = '', $ProductID = '', $errorProductID = '', $SizeVariantID = '', $errorSizeVariantID = '', $Qty = '', $errorQty = '', $Status = '', $errorStatus = '', $CreatedDate = '', $errorCreatedDate = '', $CreatedBy = '', $errorCreatedBy = '', $UpdatedDate = '', $errorUpdatedDate = '', $UpdatedBy = '', $errorUpdatedBy = '';

    public function ajaxpost()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) exit;

        $request = \Request::instance()->request->all();
        if(isset($request['ajaxpost'])) {
            switch($request['ajaxpost']) {
                case '_getsize' :
                    $this->_loaddbclass([ 'Product', 'SizeVariant' ]);
                    $id = $request['value'];
                    $Product = $this->Product->where([['ID','=',$id]])->first();
                    if($Product) {
                        $SizeVariant = [];

                        $Type = $Product->TypeProduct;
                        $GroupSizeID = $Product->GroupSizeID;
                        $ModelType = $Product->ModelType;
                        $CategoryID = $Product->CategoryID;
                        $SubCategoryID = $Product->SubCategoryID;

                        if($Type == 0) {
                            $SizeVariant = $this->SizeVariant->where([['Type','=',$Type],['GroupSizeID','=',$GroupSizeID],['ModelType','=',$ModelType],['CategoryID','=',$CategoryID],['SubCategoryID','=',$SubCategoryID],['Status','=',0]])->get();
                        } else {
                            $SizeVariant = $this->SizeVariant->where([['Type','=',$Type],['ModelType','=',$ModelType],['CategoryID','=',$CategoryID],['SubCategoryID','=',$SubCategoryID],['Status','=',0]])->get();
                        }

                        die(json_encode(['response' => 'OK','data' => $SizeVariant], JSON_FORCE_OBJECT));
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
                $this->_loaddbclass([ 'ProductDetailSizeVariant' ]);

                $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if($ProductDetailSizeVariant) {
                    $this->ProductDetailSizeID = $ProductDetailSizeVariant[$this->inv['flip']['ProductDetailSizeID']];
                    $this->ProductID = $ProductDetailSizeVariant[$this->inv['flip']['ProductID']];
                    $this->SizeVariantID = $ProductDetailSizeVariant[$this->inv['flip']['SizeVariantID']];
                    $this->Qty = $ProductDetailSizeVariant[$this->inv['flip']['Qty']];
                    $this->Status = $ProductDetailSizeVariant[$this->inv['flip']['Status']];
                    $this->CreatedDate = $ProductDetailSizeVariant[$this->inv['flip']['CreatedDate']];
                    $this->CreatedBy = $ProductDetailSizeVariant[$this->inv['flip']['CreatedBy']];
                    $this->UpdatedDate = $ProductDetailSizeVariant[$this->inv['flip']['UpdatedDate']];
                    $this->UpdatedBy = $ProductDetailSizeVariant[$this->inv['flip']['UpdatedBy']];
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
            $this->_loaddbclass([ 'ProductDetailSizeVariant' ]);

            if(isset($request['edit'])) {
                $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                if(!$ProductDetailSizeVariant) {
                    $this->_redirect('404');
                }
            }

            $this->ProductID = $request['ProductID'];
            if(empty($this->ProductID)) {
                $this->errorProductID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.addproductsize.ProductName')]
                );
            }

            $this->SizeVariantID = $request['SizeVariantID'];
            if(empty($this->SizeVariantID)) {
                $this->errorSizeVariantID = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.addproductsize.SizeVariantName')]
                );
            }

            $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->where([[$this->inv['flip']['ProductID'],'=',$this->ProductID],[$this->inv['flip']['SizeVariantID'],'=',$this->SizeVariantID],[$this->inv['flip']['Status'],'=',0]])->first();

            if($ProductDetailSizeVariant) {
                if(isset($request['addnew']) && $ProductDetailSizeVariant->ProductID == $this->ProductID && $ProductDetailSizeVariant->SizeVariantID == $this->SizeVariantID && $ProductDetailSizeVariant->Status == 0) {
                    if(!$this->errorSizeVariantID) {
                        $this->errorSizeVariantID = $this->_trans('validation.already', 
                            ['value' => $this->_trans('dashboard.products.addproductsize.SizeVariantName')]
                        );
                    }
                } else {
                    if ($ProductDetailSizeVariant[$this->objectkey] != $this->inv['getid']) {
                        if(!$this->errorSizeVariantID) {
                            $this->errorSizeVariantID = $this->_trans('validation.already', 
                                ['value' => $this->_trans('dashboard.products.addproductsize.SizeVariantName')]
                            );
                        }
                    }
                }
            }

            $this->Qty = $request['Qty'];
            if(!is_numeric($this->Qty)) {
                $this->errorQty = $this->_trans('validation.mandatory', 
                    ['value' => $this->_trans('dashboard.products.addproductsize.Qty')]
                );
            }
            
            if(!$this->inv['messageerror'] && !$this->errorProductDetailSizeID && !$this->errorProductID && !$this->errorSizeVariantID && !$this->errorQty && !$this->errorStatus && !$this->errorCreatedDate && !$this->errorCreatedBy && !$this->errorUpdatedDate && !$this->errorUpdatedBy)
            {
                $this->_loaddbclass([ 'Product', 'SizeVariant' ]);

                $Product = $this->Product->where([['ID','=',$this->ProductID]])->first();
                $SizeVariant = $this->SizeVariant->where([['ID','=',$this->SizeVariantID]])->first();

                $array = array(
                    $this->inv['flip']['ProductDetailSizeID'] => $this->ProductDetailSizeID,
                    $this->inv['flip']['ProductID'] => $this->ProductID,
                    $this->inv['flip']['SizeVariantID'] => $this->SizeVariantID,
                    $this->inv['flip']['Qty'] => $this->Qty,
                );

                $userdata =  \Session::get('userdata');
                $userid =  $userdata['uuserid'];
                
                $ProductName = $Product->Name;
                $SizeVariantName = $SizeVariant->Name;

                if(isset($request['addnew'])) {
                    $array[$this->inv['flip']['Status']] = 0;
                    $array[$this->inv['flip']['CreatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['CreatedBy']] = $userid;
                    
                    $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->creates($array);
                    
                    $this->_dblog('addnew', $this, $ProductName.' - '.$SizeVariantName.' : '.$this->Qty);
                    \Session::put('messagesuccess', "Saving $ProductName - $SizeVariantName : $this->Qty Completed !");
                } else {
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;

                    $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->where([[$this->objectkey,'=',$this->inv['getid']]])->first();
                    $ProductDetailSizeVariant->update($array);
                    
                    $this->_dblog('edit', $this, $ProductName.' - '.$SizeVariantName.' : '.$this->Qty);
                    \Session::put('messagesuccess', "Update $ProductName - $SizeVariantName : $this->Qty Completed !");
                }

                return $this->_redirect(get_class());
            }
        }

        $this->_loaddbclass([ 'Seller','Product','SizeVariant' ]);
        
        $arrProduct = $this->Product->where([['IsActive','=',1],['Status','=',0]]);
        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        if($Seller) {
            $arrProduct = $arrProduct->where([['product.SellerID', '=', $Seller->ID]]);
        }
        $this->inv['arrProduct'] = $arrProduct->get()->toArray();

        $arrSizeVariant = [];
        if($this->ProductID) {
            $Product = $this->Product->where([['ID','=',$this->ProductID]])->first();
            if($Product) {
                $Type = $Product->TypeProduct;
                $GroupSizeID = $Product->GroupSizeID;
                $ModelType = $Product->ModelType;
                $CategoryID = $Product->CategoryID;
                $SubCategoryID = $Product->SubCategoryID;

                if($Type == 0) {
                    $arrSizeVariant = $this->SizeVariant->where([['Type','=',$Type],['GroupSizeID','=',$GroupSizeID],['ModelType','=',$ModelType],['CategoryID','=',$CategoryID],['SubCategoryID','=',$SubCategoryID],['Status','=',0]])->get();
                } else {
                    $arrSizeVariant = $this->SizeVariant->where([['Type','=',$Type],['ModelType','=',$ModelType],['CategoryID','=',$CategoryID],['SubCategoryID','=',$SubCategoryID],['Status','=',0]])->get();
                }
            }
        }
        $this->inv['arrSizeVariant'] = $arrSizeVariant;

        $this->inv['ProductDetailSizeID'] = $this->ProductDetailSizeID; $this->inv['errorProductDetailSizeID'] = $this->errorProductDetailSizeID;
        $this->inv['ProductID'] = $this->ProductID; $this->inv['errorProductID'] = $this->errorProductID;
        $this->inv['SizeVariantID'] = $this->SizeVariantID; $this->inv['errorSizeVariantID'] = $this->errorSizeVariantID;
        $this->inv['Qty'] = $this->Qty; $this->inv['errorQty'] = $this->errorQty;
        $this->inv['Status'] = $this->Status; $this->inv['errorStatus'] = $this->errorStatus;
        $this->inv['CreatedDate'] = $this->CreatedDate; $this->inv['errorCreatedDate'] = $this->errorCreatedDate;
        $this->inv['CreatedBy'] = $this->CreatedBy; $this->inv['errorCreatedBy'] = $this->errorCreatedBy;
        $this->inv['UpdatedDate'] = $this->UpdatedDate; $this->inv['errorUpdatedDate'] = $this->errorUpdatedDate;
        $this->inv['UpdatedBy'] = $this->UpdatedBy; $this->inv['errorUpdatedBy'] = $this->errorUpdatedBy;

        return $this->_showview(["new"]);
    }

    public function delete()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if(isset($this->inv['delete']) && count($this->inv['delete'])) {
            $this->_loaddbclass(['ProductDetailSizeVariant', 'Product', 'SizeVariant']);

            $userdata =  \Session::get('userdata');
            $userid =  $userdata['uuserid'];
            
            foreach($this->inv['delete'] as $val) {
                $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->where([[$this->objectkey,'=',$val]])->first();
                if($ProductDetailSizeVariant) {
                    $this->Qty = $ProductDetailSizeVariant[$this->inv['flip']['Qty']];

                    $Product = $this->Product->where([['ID','=',$ProductDetailSizeVariant->ProductID]])->first();
                    $SizeVariant = $this->SizeVariant->where([['ID','=',$ProductDetailSizeVariant->SizeVariantID]])->first();

                    $ProductName = $Product->Name;
                    $SizeVariantName = $SizeVariant->Name;

                    $array[$this->inv['flip']['Status']] = 1;
                    $array[$this->inv['flip']['UpdatedDate']] = new \DateTime("now");
                    $array[$this->inv['flip']['UpdatedBy']] = $userid;
                    
                    $ProductDetailSizeVariant->update($array);

                    if(end($this->inv['delete']) != $val) $br = "<br/>";
                    else $br = "";

                    $this->_dblog('delete', $this, $ProductName.' - '.$SizeVariantName.' : '.$this->Qty);
                    $this->inv['messagesuccess'] .= "Delete $ProductName - $SizeVariantName : $this->Qty Completed !$br";
                }
            }
        }

        return $this->views();
    }

    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'Seller','ProductDetailSizeVariant' ]);

        $result = $this->ProductDetailSizeVariant->leftJoin([
            ['product as p','p.ID','=','product_detail_size_variant.ProductID'],
            ['size_variant as sv','sv.ID','=','product_detail_size_variant.SizeVariantID'],
        ])->select([
            'p.SKUPrinciple as SKUPrinciple',
            'p.Name as ProductName',
            'sv.Name as SizeVariantName',
            'product_detail_size_variant.*'
        ]);
        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        if($Seller) {
            $result = $result->where([['p.SellerID', '=', $Seller->ID]]);
        }
        $result = $result->where([['product_detail_size_variant.Status','=',0]])->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);
        
        $this->inv['flip']['ProductName'] = 'p.Name';
        $this->inv['flip']['SizeVariantName'] = 's.Name';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['ProductName'] = 'ProductName';
        $this->inv['flip']['SizeVariantName'] = 'SizeVariantName';
        
        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }

    public function downloadbulksizevariant()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        $this->_loaddbclass([ 'Seller','ProductDetailSizeVariant' ]);

        $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->leftJoin([
            ['product as p','p.ID','=','product_detail_size_variant.ProductID'],
            ['size_variant as sv','sv.ID','=','product_detail_size_variant.SizeVariantID'],
        ])->select([
            'p.SKUPrinciple as ProductCode',
            'p.NameShow as ProductName',
            'sv.ID as SizeVariantID',
            'sv.Name as SizeVariantName',
            'product_detail_size_variant.Qty as SizeVariantQty'
        ]);
        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        if($Seller) {
            $ProductDetailSizeVariant = $ProductDetailSizeVariant->where([['p.SellerID', '=', $Seller->ID]]);
        }
        $ProductDetailSizeVariant = $ProductDetailSizeVariant->where([['p.StatusSale','=',0],['p.Status','=',0],['product_detail_size_variant.Status','=',0]]);

        $ProductDetailSizeVariant = $ProductDetailSizeVariant;
        $tmpProductDetailSize = $ProductDetailSizeVariant;

        if($tmpProductDetailSize->get()) {
            $objPHPExcel = new \PHPExcel();

            $sheet = $objPHPExcel->setActiveSheetIndex(0);

            $arraytitle = [
                'ProductCode' => 'Product Code',
                'ProductName' => 'Product Name',
                'SizeVariantID' => 'Size Variant ID',
                'SizeVariantName' => 'Size Variant Name',
                'SizeVariantQty' => 'Qty',
            ];

            $loop = 0;
            foreach ($arraytitle as $key => $value) {
                $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'1', $value);
                $loop++;
            }

            $loop = 2;
            foreach ($ProductDetailSizeVariant->get() as $obj) {
                $loop2 = 0;
                foreach ($arraytitle as $key => $value) {
                    $column = $obj->$key;
                    $sheet->setCellValue($this->_excelnamefromnumber($loop2+1).$loop, $column);
                    $loop2++;
                }
                $loop++;
            }

            $filename = str_replace(' ', '_', 'Bulk Size Variant');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
            header('Cache-Control: max-age=0');

            $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $writer->save('php://output');
            exit;
        }

        return $this->views();
    }

    public function uploadbulksizevariant()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);
        $uploadbulksizevariant = $erroruploadbulksizevariant = '';

        $arraytitle = [
            'ProductCode' => 'Product Code',
            'ProductName' => 'Product Name',
            'SizeVariantID' => 'Size Variant ID',
            'SizeVariantName' => 'Size Variant Name',
            'SizeVariantQty' => 'Qty',
        ];

        $requestfile = \Request::file();

        if(isset($requestfile['uploadbulksizevariant'])) {
            $uploadbulksizevariant = $requestfile['uploadbulksizevariant'];

            $uploadbulksizevariantpath = $uploadbulksizevariant->getPathName();
            $objPHPExcel = new \PHPExcel();

            try {
                $inputFileType = \PHPExcel_IOFactory::identify($uploadbulksizevariantpath);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($uploadbulksizevariantpath);
            } catch(Exception $e) {
                $erroruploadbulksizevariant = 'Error loading file "'.pathinfo($uploadbulksizevariantpath,PATHINFO_BASENAME).'": '.$e->getMessage();
            }

            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();

            $this->_loaddbclass(['Seller','Product','ProductDetailSizeVariant']);

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

                $ProductCode = $arrayresult['ProductCode'];
                $SizeVariantID = $arrayresult['SizeVariantID'];
                $SellerSession = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
                $Product = $this->Product->where([['SKUPrinciple', '=', $ProductCode],['SellerID', '=', $SellerSession->ID]])->first();
                $ProductDetailSizeVariant = $this->ProductDetailSizeVariant->where([['ProductID', '=', $Product->ID],['SizeVariantID', '=', $SizeVariantID]])->first();

                if($ProductDetailSizeVariant) {
                    $userdata =  \Session::get('userdata');
                    $userid =  $userdata['uuserid'];

                    $ProductName = $arrayresult['ProductName'];
                    $SizeVariantName = $arrayresult['SizeVariantName'];
                    $SizeVariantQty = $arrayresult['SizeVariantQty'];

                    unset($arrayresult['ProductName']);
                    unset($arrayresult['SizeVariantName']);
                    unset($arrayresult['SizeVariantQty']);

                    $newarray = $arrayresult;
                    $newarray['Qty'] = $SizeVariantQty;
                    $newarray['UpdatedDate'] = new \DateTime("now");
                    $newarray['UpdatedBy'] = $userid;

                    $ProductDetailSizeVariant->update($newarray);
                    
                    $this->_dblog('edit', $this, $ProductCode.' : '.$ProductName.', SizeName : '.$SizeVariantName.' - Qty ( '.$SizeVariantQty.' ), Row '.($row-1).' !');
                    $this->inv['messagesuccess'] .= "Update $ProductCode : $ProductName, SizeName : $SizeVariantName - Qty ( $SizeVariantQty )".', Row '.($row-1).' !<br/>';
                } else $this->inv['messageerror'] .= 'Excel Error : Product '.$arrayresult['ProductCode'].' & Size'.$arrayresult['SizeVariantName'].' Not Merge , Row '.($row-1).' error !<br/>';
            }
            $this->inv['messagesuccess'] = rtrim($this->inv['messagesuccess'], '<br/>');
            $this->inv['messageerror'] = rtrim($this->inv['messageerror'], '<br/>');
        }

        $this->inv['uploadbulksizevariant'] = $uploadbulksizevariant; $this->inv['erroruploadbulksizevariant'] = $erroruploadbulksizevariant;
        return $this->_showview(["dashboard.products.uploadbulksizevariant"]);
    }
}