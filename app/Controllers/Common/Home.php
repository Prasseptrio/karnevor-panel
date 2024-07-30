<?php

namespace App\Controllers\Common;

use App\Controllers\BaseController;
use App\Models\FinanceModel;
use App\Models\SalesModel;

class Home extends BaseController
{
	protected $SalesModel;
	protected $FinanceModel;
	function __construct()
	{
		$this->SalesModel = new SalesModel();
		$this->FinanceModel = new FinanceModel();
	}
	public function index()
	{
		$data = array_merge($this->data, [
			'title'         => 'Dashboard Page',
			// 'LastService'	=> $this->SalesModel->getLastService(),
			'countCustomer' => $this->SalesModel->countCustomer(),
			// 'ServiceEarning' => $this->SalesModel->getTotalServiceThisMonthByBranch(),
			// 'cost' 			=>  $this->FinanceModel->getTotalCostThisMonth(),
			// 'countService'	=> $this->SalesModel->countServiceThisMonth()
		]);
		return view('common/home', $data);
	}
}
