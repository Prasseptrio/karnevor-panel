<?php

namespace App\Controllers\Finance;

use CodeIgniter\Files\File;
use App\Models\FinanceModel;
use App\Controllers\BaseController;

class Budget extends BaseController
{
	protected $FinanceModel;
	function __construct()
	{
		$this->FinanceModel = new FinanceModel();
	}

	public function index()
	{
		$data = array_merge($this->data, [
			'title'         	=> 'Cost',
			'PettyCash'    		=> $this->FinanceModel->getPettyCash(),
			'OperationalCost'   => $this->FinanceModel->getOperationalCost(),
			'CostCategories'	=> $this->FinanceModel->getCostCategories()
		]);
		return view('finance/cost_list', $data);
	}

	public function createOperationalCost()
	{
		$img = $this->request->getFile('inputBillAttachment');
		if ($img->isValid() && !$img->hasMoved()) {
			$filepath 	= WRITEPATH . 'uploads/' . $img->store('cost/', null);
			$data 		= ['uploaded_fileinfo' => new File($filepath)];
			$filename 	= $data['uploaded_fileinfo']->getFilename();
			$createFinanceBudget = $this->FinanceModel->createOperationalCost($this->request->getPost(null), $filename);
			if ($createFinanceBudget) {
				session()->setFlashdata('notif_success', '<b>Successfully added new Finance Budget</b>');
				return redirect()->to(base_url('operational-cost'));
			} else {
				session()->setFlashdata('notif_error', '<b>Failed to add new Finance Budget</b>');
				return redirect()->to(base_url('operational-cost'));
			}
		} else {
			session()->setFlashdata('notif_error', $img->getErrorString() . '(' . $img->getError() . ')');
			return redirect()->to(base_url('operational-cost'));
		}
	}
}
