<?php

namespace App\Controllers\Finance;

use App\Models\FinanceModel;
use App\Controllers\BaseController;

class Capital extends BaseController
{
	protected $FinanceModel;
	function __construct()
	{
		$this->FinanceModel = new FinanceModel();
	}
	public function index()
	{
		$data = array_merge($this->data, [
			'title'      		=> 'Capital & Shares',
			'Investor'   		=> $this->FinanceModel->getInvestor(),
			'FinanceCapital'    => $this->FinanceModel->getCapital(),
			'PettyCash'    		=> $this->FinanceModel->getPettyCash(),
		]);
		return view('finance/capital', $data);
	}
	public function createCapital()
	{
		$capitalProof = '';
		$createFinanceCapital = $this->FinanceModel->createFinanceCapital($this->request->getPost(null), $capitalProof);
		if ($createFinanceCapital) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Finance Capital</b>');
			return redirect()->to(base_url('capital'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Finance Capital</b>');
			return redirect()->to(base_url('capital'));
		}
	}

	public function updateFinanceCapital()
	{
		$updateFinanceCapital = $this->FinanceModel->updateFinanceCapital($this->request->getPost(null));
		if ($updateFinanceCapital) {
			session()->setFlashdata('notif_success', '<b>Successfully update Finance Capital</b>');
			return redirect()->to(base_url('capital'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update Finance Capital</b>');
			return redirect()->to(base_url('capital'));
		}
	}
}
