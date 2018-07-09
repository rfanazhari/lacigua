<?php
namespace App\Modules\dashboard\Http\Controllers\masterproduct;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class productreportController extends Controller
{
    // Set header active
    public $header = [
        'menus'     => true, // True is show menu and false is not show.
        'check'     => true, // Active all header function. If all true and this check false then header not show.
        'search'    => true,
        'addnew'    => false,
        'refresh'   => true,
    ];

    // Declare all you field in table
    // Set idfunction => UNIQUEID for edit, detail, delete and etc (ID)
    public $alias = [
        'ID' => 'ProductReportID',
        'CreatedDate' => 'CreatedDate',
        'ProductID' => 'ProductID',
        'SKUPrinciple' => 'SKUPrinciple',
        'Image1' => 'Image1',
        'NameShow' => 'NameShow',
        'Reason' => 'Reason',
        'Detail' => 'Detail',
        'idfunction' => 'ID',
    ];
    
    // For show name and set width in page HTML
    // If you using alias name with "date", in search you can get two input date
    public $aliasform = [
        'titlepage'     => ['DB', true, true], // Set Title Page, Title Form (true or false), Breadcrumb (true or false)
        'CreatedDate' => ['Created Date', true],
        'ProductReportID' => ['Product Report ID'],
        'ProductID' => ['Product ID'],
        'SKUPrinciple' => ['SKU Principle', true, 'width:150px;'],
        'Image1' => ['Image'],
        'NameShow' => ['Product Name', true],
        'Reason' => ['Reason', true],
        'Detail' => ['Detail', true],
    ];

    var $pathimage = '/resources/assets/frontend/images/content/product/';

    public function index()
    {
        $url = $this->_accessdata($this, __FUNCTION__);
        if($url) return $this->_redirect($url);

        return $this->views();
    }
    
    private function views($views = ["defaultview"]) {
        $this->_loaddbclass([ 'ProductReport' ]);

        $result = $this->ProductReport->leftjoin([
            ['product as p', 'p.ID', '=', 'product_report.ProductID'],
        ])->selectraw('
            p.SKUPrinciple,
            p.Image1,
            p.NameShow,
            product_report.*
        ')->orderBy($this->inv['flip'][$this->inv['getorder']], $this->inv['getsort']);

        $this->inv['flip']['CreatedDate'] = 'product_return.CreatedDate';

        if(isset($this->inv['getsearchby'])) $this->_dbquerysearch($result, $this->inv['flip']);

        $this->inv['flip']['CreatedDate'] = 'CreatedDate';
        

        $result = $result->paginate($this->inv['config']['backend']['limitpage'])->toArray();

        if(!count($result['data'])) $this->inv['messageerror'] = $this->_trans('validation.norecord');
        else {

            $arrayreason = [
                1 => 'Photography Is Not Real',
                2 => 'Other'
            ];
            for($i = 0; $i < count($result['data']); $i++) {
                if($result['data'][$i][$this->inv['flip']['Image1']] == '') {
                    $result['data'][$i][$this->inv['flip']['SKUPrinciple']] = '<span class="img-tool label label-sm label-info" style="background-color:red;" data-toggle="tooltip" data-placement="right" data-html="true" title="<img src=\''.$this->inv['basesite'] . 'assets/frontend/images/material/noimage.jpg\' width=\'100%\' height=\'100%\' />">'.$result['data'][$i][$this->inv['flip']['SKUPrinciple']].'</span>';
                } else {
                    $result['data'][$i][$this->inv['flip']['SKUPrinciple']] = '<span class="img-tool" data-toggle="tooltip" data-placement="right" data-html="true" title="<img src=\''.$this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) .
                        'medium_'.$result['data'][$i][$this->inv['flip']['Image1']].'\' width=\'100%\' height=\'100%\' />">'.$result['data'][$i][$this->inv['flip']['SKUPrinciple']].'</span>';
                }

                if ($result['data'][$i][$this->inv['flip']['Image1']]) {
                    $result['data'][$i][$this->inv['flip']['Image1']] =
                    $this->inv['basesite'] .
                    str_replace('/resources/', '', $this->pathimage) .
                        'small_' . $result['data'][$i][$this->inv['flip']['Image1']];
                }
                $result['data'][$i]['Reason'] = $arrayreason[$result['data'][$i]['Reason']];
                $result['data'][$i]['CreatedDate'] = $this->_datetimeforhtml($result['data'][$i]['CreatedDate'], 'red');
            }
            $this->_setdatapaginate($result);
        }

        // $this->_debugvar($this->inv);
        return $this->_showview($views);
    }
}