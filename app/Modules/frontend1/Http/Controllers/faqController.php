<?php

namespace App\Modules\frontend1\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class faqController extends Controller
{
	public function index()
	{
		$this->_loaddbclass(['Faq']);

		$this->arrfaq = $this->Faq->where([['faq.IsActive', '=', 1],['faq.Status', '=', 0]])
		->selectraw('
			faq.*,
			(select GROUP_CONCAT(CONCAT(faq_sub.Name,"++",faq_sub.permalink) SEPARATOR ",") from faq_sub where faq_sub.FaqID = faq.ID) as FaqSub
		')->orderBy('faq.Name', 'ASC')->get()->toArray();
        $this->inv['arrfaq'] = $this->arrfaq;

		return $this->_showviewfront(['faq']);
	}
}