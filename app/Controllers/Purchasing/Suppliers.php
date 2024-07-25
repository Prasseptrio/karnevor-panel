<?php

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController;
use App\Models\PurchasingModel;

class Suppliers extends BaseController
{
	protected $PurchasingModel;
	function __construct()
	{
		$this->PurchasingModel = new PurchasingModel();
	}

	public function index()
	{
		$data = array_merge($this->data, [
			'title'        => 'Suppliers',
			'Suppliers'    => $this->PurchasingModel->getSuppliers()
		]);
		return view('purchasing/suppliers_list', $data);
	}
	public function form()
	{
		$SupplierID = $this->request->getGet('id');
		$data = array_merge($this->data, [
			'title' 	=> 'Suppliers',
			'supplier'	=> ($SupplierID) ? $this->PurchasingModel->getSuppliers($SupplierID) : []
		]);
		return view('purchasing/suppliers_form', $data);
	}

	public function createSupplier()
	{
		$createSuppliers = $this->PurchasingModel->createSuppliers($this->request->getPost(null));
		if ($createSuppliers) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Suppliers</b>');
			return redirect()->to(base_url('suppliers'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Suppliers</b>');
			return redirect()->to(base_url('suppliers'));
		}
	}

	public function updateSupplier()
	{
		$updateSuppliers = $this->PurchasingModel->updateSuppliers($this->request->getPost(null));
		if ($updateSuppliers) {
			session()->setFlashdata('notif_success', '<b>Successfully update Suppliers</b>');
			return redirect()->to(base_url('suppliers'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update Suppliers</b>');
			return redirect()->to(base_url('suppliers'));
		}
	}

	public function deleteSupplier($SupplierID)
	{
		if (!$SupplierID) {
			return redirect()->to(base_url('suppliers'));
		}
		$deleteSuppliers = $this->PurchasingModel->deleteSuppliers($SupplierID);
		if ($deleteSuppliers) {
			session()->setFlashdata('notif_success', '<b>Successfully delete Suppliers</b>');
			return redirect()->to(base_url('suppliers'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete Suppliers</b>');
			return redirect()->to(base_url('suppliers'));
		}
	}
}
