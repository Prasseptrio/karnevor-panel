<?php

namespace App\Controllers\Finance;

use App\Controllers\BaseController;
use App\Models\FinanceModel;

class Bank extends BaseController
{
	protected $FinanceModel;
	function __construct()
	{
		$this->FinanceModel = new FinanceModel();
	}
	public function index()
	{
		$data = array_merge($this->data, [
			'title'        => 'Cash & Bank',
			'PettyCash'    => $this->FinanceModel->getPettyCash()
		]);
		return view('finance/petty_cash', $data);
	}
	public function getPettyCash()
	{
		$PettyCash = $this->FinanceModel->getPettyCash($this->request->getGet('id'));
		echo json_encode($PettyCash);
	}
	public function createPettyCash()
	{
		$createPettyCash = $this->FinanceModel->createPettyCash($this->request->getPost(null));
		if ($createPettyCash) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Petty Cash</b>');
			return redirect()->to(base_url('petty-cash'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Petty Cash</b>');
			return redirect()->to(base_url('petty-cash'));
		}
	}

	public function updatePettyCash()
	{
		$updatePettyCash = $this->FinanceModel->updatePettyCash($this->request->getPost(null));
		if ($updatePettyCash) {
			session()->setFlashdata('notif_success', '<b>Successfully update Petty Cash</b>');
			return redirect()->to(base_url('petty-cash'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update Petty Cash</b>');
			return redirect()->to(base_url('petty-cash'));
		}
	}

	public function transferPettyCash()
	{
		$transferPettyCash = $this->FinanceModel->transferPettyCash($this->request->getPost(null));
		if ($transferPettyCash) {
			session()->setFlashdata('notif_success', '<b>Successfully transfer Petty Cash</b>');
			return redirect()->to(base_url('petty-cash'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to transfer Petty Cash</b>');
			return redirect()->to(base_url('petty-cash'));
		}
	}
}
