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
		$earning =  $this->SalesModel->getTotalServiceByDay();
		$earningTotal = $earning['total'] + $earning['sales_order_tax'] - $earning['sales_order_discount'] + $earning['cost_delivery'];
		$data = array_merge($this->data, [
			'title'         => 'Dashboard Page',
			'Sales'			=> $this->SalesModel->countSales(),
			'countCustomer' => $this->SalesModel->countCustomer(),
			'SalesErning' 	=> $earningTotal,
			'erning'		=> $earning
		]);
		return view('common/home', $data);
	}
}
