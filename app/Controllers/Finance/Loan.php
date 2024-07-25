<?php

namespace App\Controllers\Finance;

use App\Models\FinanceModel;
use App\Controllers\BaseController;

class Loan extends BaseController
{
	protected $FinanceModel;
	function __construct()
	{
		$this->FinanceModel = new FinanceModel();
	}

	public function index()
	{
		$loanID = $this->request->getGet('id');
		if ($loanID) {
			$data = array_merge($this->data, [
				'title'         => 'Payable & Receivable',
				'loan' 			=> $this->FinanceModel->getFinanceLoans($loanID),
				'LoansDetail'	=> $this->FinanceModel->getFinanceDetail($loanID),
				'PettyCash'    	=> $this->FinanceModel->getPettyCash(),
				'loanID'		=> $loanID
			]);
			return view('finance/loan_detail', $data);
		} else {
			$data = array_merge($this->data, [
				'title'         => 'Payable & Receivable',
				'FinanceLoans'  => $this->FinanceModel->getFinanceLoans(),
				'PettyCash'    	=> $this->FinanceModel->getPettyCash()
			]);
			return view('finance/loan', $data);
		}
	}
	public function createLoan()
	{
		$createFinanceLoans = $this->FinanceModel->createFinanceLoans($this->request->getPost(null));
		if ($createFinanceLoans) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Finance Loans</b>');
			return redirect()->to(base_url('loan'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Finance Loans</b>');
			return redirect()->to(base_url('loan'));
		}
	}

	public function paymentLoan()
	{
		$paymentLoan = $this->FinanceModel->paymentLoan($this->request->getPost(null));
		if ($paymentLoan) {
			session()->setFlashdata('notif_success', '<b>Successfully Paid Loans</b>');
			return redirect()->to(base_url('loan'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to paid Finance Loans</b>');
			return redirect()->to(base_url('loan'));
		}
	}
}
