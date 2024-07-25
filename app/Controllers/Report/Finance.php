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
		$incomeMaguwo 	 		= $this->SalesModel->getTotalServiceThisMonthByBranch(1);
		$incomeGiwangan 		= $this->SalesModel->getTotalServiceThisMonthByBranch(2);
		$income					= $incomeMaguwo['service_order_total'] + $incomeGiwangan['service_order_total'];
		$totalDiscountMaguwo	= $this->SalesModel->getTotalDiscountServiceThisMonthByBranch(1);
		$totalDiscountGiwangan	= $this->SalesModel->getTotalDiscountServiceThisMonthByBranch(2);
		$totalDiscount			= $totalDiscountGiwangan['service_order_discount'] + $totalDiscountMaguwo['service_order_discount'];
		$costMaguwo		 		= $this->FinanceModel->getTotalCostThisMonthByBranch(1);
		$costGiwangan		 	= $this->FinanceModel->getTotalCostThisMonthByBranch(2);
		$totalCost		 		= $costMaguwo['bill'] + $costGiwangan['bill'];
		$totalIncomeMaguwo 		= $incomeMaguwo['service_order_total'] + $incomeMaguwo['pickup_fee'];
		$totalIncomeGiwangan 	= $incomeGiwangan['service_order_total'] + $incomeGiwangan['pickup_fee'];
		$totalIncome	 		= $totalIncomeMaguwo + $totalIncomeGiwangan;
		if ($this->request->isAJAX()) {
			return $this->respond([
				'income_maguwo' 	 	=> $incomeMaguwo['service_order_total'],
				'income_giwangan' 		=> $incomeGiwangan['service_order_total'],
				'pickup_fee_maguwo' 	=> $incomeMaguwo['pickup_fee'],
				'pickup_fee_giwangan' 	=> $incomeGiwangan['pickup_fee'],
				'total_income_maguwo' 	=> $totalIncomeMaguwo,
				'total_income_giwangan' => $totalIncomeGiwangan,
				'cost_maguwo'		 	=> $costMaguwo['bill'],
				'cost_giwangan'		 	=> $costGiwangan['bill']
			], 200);
		}
		$data = array_merge($this->data, [
			'title'     			=> 'Profit',
			'income_maguwo' 	 	=> $incomeMaguwo['service_order_total'],
			'income_giwangan' 		=> $incomeGiwangan['service_order_total'],
			'income' 				=> $income,
			'cost_maguwo'		 	=> $costMaguwo['bill'],
			'cost_giwangan'		 	=> $costGiwangan['bill'],
			'cost'		 			=> $totalCost,
			'discount_giwangan'		=> $totalDiscountGiwangan['service_order_discount'],
			'discount_maguwo'		=> $totalDiscountMaguwo['service_order_discount'],
			'discount'				=> $totalDiscount,
			'profit_maguwo'			=> $totalIncomeMaguwo - $costMaguwo['bill'],
			'profit_giwangan'		=> $totalIncomeGiwangan - $costGiwangan['bill'],
			'profit'				=> ($totalIncomeMaguwo - $costMaguwo['bill']) + ($totalIncomeGiwangan - $costGiwangan['bill']),
			'pickupfeeMaguwo'		=> $incomeMaguwo['pickup_fee'],
			'pickupfeeGiwangan'		=> $incomeGiwangan['pickup_fee'],
			'pickupfee'				=> $incomeMaguwo['pickup_fee'] + $incomeGiwangan['pickup_fee']
		]);
		return view('report/profit', $data);
	}
}
