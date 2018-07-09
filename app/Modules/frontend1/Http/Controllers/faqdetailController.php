<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class faqdetailController extends Controller
{
	public function index()
	{
		$this->_geturi();

		if(!isset($this->inv['getfaq'])) return $this->_redirect('404');

		$this->_loaddbclass(['FaqSub','FaqSubDetail']);

		$this->arrfaqsub = $this->FaqSub->leftjoin([
			['faq', 'faq.ID', '=', 'faq_sub.FaqID']
		])->selectraw('
			faq_sub.*,
			faq.permalink as permalinksub
		')->where([['faq.permalink', '=', $this->inv['getfaq']],['faq_sub.IsActive', '=', 1],['faq_sub.Status', '=', 0]])->orderBy('faq_sub.Name', 'ASC')->get()->toArray();

		if(!count($this->arrfaqsub)) return $this->_redirect('404');

        $this->inv['arrfaqsub'] = $this->arrfaqsub;

		$this->arrfaqsubdetail = $this->FaqSubDetail->leftjoin([
			['faq_sub', 'faq_sub.ID', '=', 'faq_sub_detail.FaqSubID']
		]);
		if(isset($this->inv['getfaqsub'])) {
			$this->arrfaqsubdetail = $this->arrfaqsubdetail->where([['faq_sub.permalink', '=', $this->inv['getfaqsub']],['faq_sub_detail.IsActive', '=', 1],['faq_sub_detail.Status', '=', 0]]);
			$this->arrfaqsubdetail = $this->arrfaqsubdetail->orderBy('faq_sub_detail.Title', 'ASC')->get()->toArray();
		} else if($this->arrfaqsub) {
			$this->arrfaqsubdetail = $this->arrfaqsubdetail->where([['faq_sub.permalink', '=', $this->arrfaqsub[0]['permalink']],['faq_sub_detail.IsActive', '=', 1],['faq_sub_detail.Status', '=', 0]]);
			$this->arrfaqsubdetail = $this->arrfaqsubdetail->orderBy('faq_sub_detail.Title', 'ASC')->get()->toArray();
		}

		if(!count($this->arrfaqsubdetail)) return $this->_redirect('404');
		
        $this->inv['arrfaqsubdetail'] = $this->arrfaqsubdetail;

		return $this->_showviewfront(['faqdetail']);
	}
}