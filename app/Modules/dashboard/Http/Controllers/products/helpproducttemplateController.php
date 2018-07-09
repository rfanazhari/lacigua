<?php
namespace App\Modules\dashboard\Http\Controllers\products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class helpproducttemplateController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => false, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => false,
        'refresh'   => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'ProductID',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
    ];

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        $this->_loaddbclass([ 'Seller' ]);

        $Seller = $this->Seller->where([['idGroup', '=', \Session::get('userdata')['uusergroupid']]])->first();
        
        $this->inv['SellerUniqueID'] = $Seller->SellerUniqueID;

        return $this->_showview(["dashboard.products.helpproducttemplate"]);
    }

    public function downloadbrand($setsheet = 0, $objPHPExcel = null)
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if($setsheet == $this->inv['baseuri']) $setsheet = 0;

        $this->_loaddbclass([ 'Brand' ]);

        $Brand = $this->Brand->leftJoin([
            ['seller as s','s.ID','=','brand.SellerID'],
        ])->select([
            'brand.*'
        ])->where([
            ['s.idGroup', '=', \Session::get('userdata')['uusergroupid']],
            ['brand.IsActive', '=', 1],
            ['brand.Status', '=', 0]
        ])->orderBy('Name');

        $Brand = $Brand;
        $tmpBrand = $Brand;

        if($tmpBrand->get()) {
            if(is_null($objPHPExcel)) {
                $objPHPExcel = new \PHPExcel();
            } else $objPHPExcel->createSheet();

            $sheet = $objPHPExcel->setActiveSheetIndex($setsheet);
            $sheet->setTitle("Brand");

            $arraytitle = [
                'Name' => 'Name',
                'ID' => 'Data ID',
            ];

            $loop = 0;
            foreach ($arraytitle as $key => $value) {
                $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'1', $value);
                $loop++;
            }

            $loop = 2;
            foreach ($Brand->get() as $obj) {
                $loop2 = 0;
                foreach ($arraytitle as $key => $value) {
                    $column = $obj->$key;
                    if($key == 'ID') {
                        $column = 'B'.$obj->$key;
                    }
                    $sheet->setCellValue($this->_excelnamefromnumber($loop2+1).$loop, $column);
                    $loop2++;
                }
                $loop++;
            }

            if(!$setsheet) {
                $filename = str_replace(' ', '_', 'Your Brand');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
                header('Cache-Control: max-age=0');

                $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $writer->save('php://output');
                exit;
            }
        }
    }

    public function downloadmainmenucategorysubcategory($setsheet = 0, $objPHPExcel = null)
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if($setsheet == $this->inv['baseuri']) $setsheet = 0;

        $this->_loaddbclass([ 'Category' ]);

        $Category = $this->Category->leftJoin([
            ['sub_category as sc','sc.IDCategory','=','category.ID'],
        ])->select([
            'category.ModelType',
            'category.ID as CategoryID',
            'category.Name as CategoryName',
            'sc.ID as SubCategoryID',
            'sc.Name as SubCategoryName'
        ])->where(function($query) {
            $query->where(function($query) {
                $query->where('category.IsActive','=',1)->orwhere('category.IsActive','=',null);
            })->where(function($query) {
                $query->where('category.Status','=',0)->orwhere('category.Status','=',null);
            });
        })->where(function($query) {
            $query->where(function($query) {
                $query->where('sc.IsActive','=',1)->orwhere('sc.IsActive','=',null);
            })->where(function($query) {
                $query->where('sc.Status','=',0)->orwhere('sc.Status','=',null);
            });
        })->orderBy('ModelType')->orderBy('CategoryID');

        $Category = $Category;
        $tmpProduct = $Category;

        if($tmpProduct->get()) {
            if(is_null($objPHPExcel)) {
                $objPHPExcel = new \PHPExcel();
            } else $objPHPExcel->createSheet();
            
            $sheet = $objPHPExcel->setActiveSheetIndex($setsheet);
            $sheet->setTitle("MCS");

            $arraytitle = [
                'ModelType' => 'Main Menu',
                'CategoryName' => 'Category Name',
                'SubCategoryName' => 'Sub Category Name',
                'DATAID' => 'Data ID',
            ];

            $loop = 0;
            foreach ($arraytitle as $key => $value) {
                $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'1', $value);
                $loop++;
            }

            $loop = 2;
            foreach ($Category->get() as $obj) {
                $loop2 = 0;
                foreach ($arraytitle as $key => $value) {
                    if($key != 'DATAID') {
                        $column = $obj->$key;
                        $sheet->setCellValue($this->_excelnamefromnumber($loop2+1).$loop, $column);
                    } else {
                        $DATAID = substr($obj->ModelType, 0, 1).$obj->CategoryID;
                        if($obj->SubCategoryID) $DATAID .= '-'.$obj->SubCategoryID;
                        $column = $DATAID;
                        $sheet->setCellValueExplicit($this->_excelnamefromnumber($loop2+1).$loop, $column, \PHPExcel_Cell_DataType::TYPE_STRING);
                    }
                    $loop2++;
                }
                $loop++;
            }

            if(!$setsheet) {
                $filename = str_replace(' ', '_', 'Main Menu Category Sub Category');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
                header('Cache-Control: max-age=0');

                $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $writer->save('php://output');
                exit;
            }
        }
    }

    public function downloadcolor($setsheet = 0, $objPHPExcel = null)
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if($setsheet == $this->inv['baseuri']) $setsheet = 0;

        $this->_loaddbclass([ 'Color' ]);

        $Color = $this->Color->where([
            ['IsActive', '=', 1],
            ['Status', '=', 0]
        ])->orderBy('Name');

        $Color = $Color;
        $tmpColor = $Color;

        if($tmpColor->get()) {
            if(is_null($objPHPExcel)) {
                $objPHPExcel = new \PHPExcel();
            } else $objPHPExcel->createSheet();
            
            $sheet = $objPHPExcel->setActiveSheetIndex($setsheet);
            $sheet->setTitle("Color");

            $arraytitle = [
                'Name' => 'Name',
                'Hexa' => 'Hexa',
                'ID' => 'Data ID',
            ];

            $loop = 0;
            foreach ($arraytitle as $key => $value) {
                $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'1', $value);
                $loop++;
            }

            $loop = 2;
            foreach ($Color->get() as $obj) {
                $loop2 = 0;
                foreach ($arraytitle as $key => $value) {
                    $column = $obj->$key;
                    if($key == 'ID') {
                        $column = 'C'.$obj->$key;
                    }
                    $sheet->setCellValue($this->_excelnamefromnumber($loop2+1).$loop, $column);
                    $loop2++;
                }
                $loop++;
            }

            if(!$setsheet) {
                $filename = str_replace(' ', '_', 'Color');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
                header('Cache-Control: max-age=0');

                $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $writer->save('php://output');
                exit;
            }
        }
    }

    public function downloadgroupsize($setsheet = 0, $objPHPExcel = null)
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if($setsheet == $this->inv['baseuri']) $setsheet = 0;

        $this->_loaddbclass([ 'GroupSize' ]);

        $GroupSize = $this->GroupSize->where([
            ['IsActive', '=', 1],
            ['Status', '=', 0]
        ])->orderBy('Name');

        $GroupSize = $GroupSize;
        $tmpGroupSize = $GroupSize;

        if($tmpGroupSize->get()) {
            if(is_null($objPHPExcel)) {
                $objPHPExcel = new \PHPExcel();
            } else $objPHPExcel->createSheet();
            
            $sheet = $objPHPExcel->setActiveSheetIndex($setsheet);
            $sheet->setTitle("Group Size");

            $arraytitle = [
                'Name' => 'Name',
                'ID' => 'Data ID',
            ];

            $loop = 0;
            foreach ($arraytitle as $key => $value) {
                $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'1', $value);
                $loop++;
            }

            $loop = 2;
            foreach ($GroupSize->get() as $obj) {
                $loop2 = 0;
                foreach ($arraytitle as $key => $value) {
                    $column = $obj->$key;
                    if($key == 'ID') {
                        $column = 'G'.$obj->$key;
                    }
                    $sheet->setCellValue($this->_excelnamefromnumber($loop2+1).$loop, $column);
                    $loop2++;
                }
                $loop++;
            }

            if(!$setsheet) {
                $filename = str_replace(' ', '_', 'Group Size');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
                header('Cache-Control: max-age=0');

                $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $writer->save('php://output');
                exit;
            }
        }
    }

    public function downloadstyle($setsheet = 0, $objPHPExcel = null)
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        if($setsheet == $this->inv['baseuri']) $setsheet = 0;

        $this->_loaddbclass([ 'Style' ]);

        $Style = $this->Style->where([
            ['IsActive', '=', 1],
            ['Status', '=', 0]
        ])->orderBy('Name');

        $Style = $Style;
        $tmpStyle = $Style;

        if($tmpStyle->get()) {
            if(is_null($objPHPExcel)) {
                $objPHPExcel = new \PHPExcel();
            } else $objPHPExcel->createSheet();
            
            $sheet = $objPHPExcel->setActiveSheetIndex($setsheet);
            $sheet->setTitle("Style");

            $arraytitle = [
                'Name' => 'Name',
                'ID' => 'Data ID',
            ];

            $loop = 0;
            foreach ($arraytitle as $key => $value) {
                $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'1', $value);
                $loop++;
            }

            $loop = 2;
            foreach ($Style->get() as $obj) {
                $loop2 = 0;
                foreach ($arraytitle as $key => $value) {
                    $column = $obj->$key;
                    if($key == 'ID') {
                        $column = 'S'.$obj->$key;
                    }
                    $sheet->setCellValue($this->_excelnamefromnumber($loop2+1).$loop, $column);
                    $loop2++;
                }
                $loop++;
            }

            if(!$setsheet) {
                $filename = str_replace(' ', '_', 'Our Style');
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
                header('Cache-Control: max-age=0');

                $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $writer->save('php://output');
                exit;
            }
        }
    }

    public function downloadtemplateuploadbulkproductregulerfashion()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        $objPHPExcel = new \PHPExcel();

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $Title = "Product Reguler Fashion";
        $sheet->setTitle($Title);

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

        $sheet->setCellValue($this->_excelnamefromnumber(1).'1', 'Type');
        $sheet->setCellValue($this->_excelnamefromnumber(2).'1', '1');
        $loop = 0;
        foreach ($arraytitle as $key => $value) {
            $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'2', $value);
            $sheet->getColumnDimension($this->_excelnamefromnumber($loop+1))->setAutoSize(true);
            $loop++;
        }

        $this->downloadbrand(1, $objPHPExcel);
        $this->downloadmainmenucategorysubcategory(2, $objPHPExcel);
        $this->downloadcolor(3, $objPHPExcel);
        $this->downloadgroupsize(4, $objPHPExcel);
        $this->downloadstyle(5, $objPHPExcel);

        $objPHPExcel->setActiveSheetIndex(0);

        $filename = str_replace(' ', '_', 'Add Bulk '.$Title);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $writer->save('php://output');
        exit;
    }

    public function downloadtemplateuploadbulkproductregulerbeauty()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        $objPHPExcel = new \PHPExcel();

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $Title = "Product Reguler Beauty";
        $sheet->setTitle($Title);

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

        $sheet->setCellValue($this->_excelnamefromnumber(1).'1', 'Type');
        $sheet->setCellValue($this->_excelnamefromnumber(2).'1', '2');
        $loop = 0;
        foreach ($arraytitle as $key => $value) {
            $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'2', $value);
            $sheet->getColumnDimension($this->_excelnamefromnumber($loop+1))->setAutoSize(true);
            $loop++;
        }

        $this->downloadbrand(1, $objPHPExcel);
        $this->downloadmainmenucategorysubcategory(2, $objPHPExcel);
        $this->downloadcolor(3, $objPHPExcel);
        $this->downloadgroupsize(4, $objPHPExcel);
        $this->downloadstyle(5, $objPHPExcel);

        $objPHPExcel->setActiveSheetIndex(0);

        $filename = str_replace(' ', '_', 'Add Bulk '.$Title);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $writer->save('php://output');
        exit;
    }

    public function downloadtemplateuploadbulkproductsalefashion()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        $objPHPExcel = new \PHPExcel();

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $Title = "Product Sale Fashion";
        $sheet->setTitle($Title);

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

        $sheet->setCellValue($this->_excelnamefromnumber(1).'1', 'Type');
        $sheet->setCellValue($this->_excelnamefromnumber(2).'1', '3');
        $loop = 0;
        foreach ($arraytitle as $key => $value) {
            $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'2', $value);
            $sheet->getColumnDimension($this->_excelnamefromnumber($loop+1))->setAutoSize(true);
            $loop++;
        }

        $this->downloadbrand(1, $objPHPExcel);
        $this->downloadmainmenucategorysubcategory(2, $objPHPExcel);
        $this->downloadcolor(3, $objPHPExcel);
        $this->downloadgroupsize(4, $objPHPExcel);
        $this->downloadstyle(5, $objPHPExcel);

        $objPHPExcel->setActiveSheetIndex(0);

        $filename = str_replace(' ', '_', 'Add Bulk '.$Title);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $writer->save('php://output');
        exit;
    }

    public function downloadtemplateuploadbulkproductsalebeauty()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        $objPHPExcel = new \PHPExcel();

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $Title = "Product Sale Beauty";
        $sheet->setTitle($Title);

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

        $sheet->setCellValue($this->_excelnamefromnumber(1).'1', 'Type');
        $sheet->setCellValue($this->_excelnamefromnumber(2).'1', '4');
        $loop = 0;
        foreach ($arraytitle as $key => $value) {
            $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'2', $value);
            $sheet->getColumnDimension($this->_excelnamefromnumber($loop+1))->setAutoSize(true);
            $loop++;
        }

        $this->downloadbrand(1, $objPHPExcel);
        $this->downloadmainmenucategorysubcategory(2, $objPHPExcel);
        $this->downloadcolor(3, $objPHPExcel);
        $this->downloadgroupsize(4, $objPHPExcel);
        $this->downloadstyle(5, $objPHPExcel);

        $objPHPExcel->setActiveSheetIndex(0);

        $filename = str_replace(' ', '_', 'Add Bulk '.$Title);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $writer->save('php://output');
        exit;
    }

    public function downloadtemplateuploadbulkimage()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        $objPHPExcel = new \PHPExcel();

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $Title = "Image";
        $sheet->setTitle($Title);

        $arraytitle = [
            'SKUSeller' => 'SKU Seller *',
            'Image1' => 'Image 1 *',
            'Image2' => 'Image 2 *',
            'Image3' => 'Image 3',
            'Image4' => 'Image 4',
            'Image5' => 'Image 5',
        ];

        $loop = 0;
        foreach ($arraytitle as $key => $value) {
            $sheet->setCellValue($this->_excelnamefromnumber($loop+1).'1', $value);
            $sheet->getColumnDimension($this->_excelnamefromnumber($loop+1))->setAutoSize(true);
            $loop++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $filename = str_replace(' ', '_', 'Add Bulk '.$Title);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');

        $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $writer->save('php://output');
        exit;
    }
}