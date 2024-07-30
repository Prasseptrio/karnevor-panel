<?php

namespace App\Controllers\Report;

use App\Models\SalesModel;
use App\Models\FinanceModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class Finance extends BaseController
{
	use ResponseTrait;
	protected $SalesModel;
	protected $FinanceModel;
	function __construct()
	{
		$this->FinanceModel = new FinanceModel();
		$this->SalesModel = new SalesModel();
	}
	public function profit()
	{
		$income 	 		= $this->SalesModel->getTotalServiceThisMonth();
		$Totalincome		= $income['total'] + $income['sales_order_discount'];
		$totalDiscount		= $income['sales_order_discount'];
		$pickupfee		 	= $income['cost_delivery'];
		$data = array_merge($this->data, [
			'title'     => 'Profit',
			'income' 	=> $Totalincome,
			'discount'	=> $totalDiscount,
			'profit'	=> $income['total'] + $income['sales_order_discount'],
			'pickupfee'	=> $pickupfee
		]);
		return view('report/profit', $data);
	}
}
