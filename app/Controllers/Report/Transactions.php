<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Models\SalesModel;
use CodeIgniter\API\ResponseTrait;

class Transactions extends BaseController
{
	use ResponseTrait;
	protected $SalesModel;
	function __construct()
	{
		$this->SalesModel = new SalesModel();
	}
	public function index()
	{
		$totalServiceByDayMaguwo = $this->SalesModel->getTotalServiceByDayandBranch(1);
		$totalServiceByDaygiwangan = $this->SalesModel->getTotalServiceByDayandBranch(2);
		if ($this->request->isAJAX()) {
			return $this->respond($totalServiceByDayMaguwo, 200);
		} else {
			$day 	= ($this->request->getGet('day')) ? $this->request->getGet('day') : date('Y-m-d');
			$data 	= array_merge($this->data, [
				'title'     			=> 'Service Order Report',
				'ServiceIncomeMaguwo'	=> $totalServiceByDayMaguwo,
				'ServiceIncomeGiwangan'	=> $totalServiceByDaygiwangan,
				'ServicesToday'			=> $this->SalesModel->getServiceToday($day),
			]);
			return view('report/service', $data);
		}
	}
}
