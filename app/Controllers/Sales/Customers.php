<?php

namespace App\Controllers\Sales;

use App\Controllers\BaseController;
use App\Models\SalesModel;

class Customers extends BaseController
{
	protected $SalesModel;
	function __construct()
	{
		$this->SalesModel = new SalesModel();
	}
	public function index()
	{
		if ($this->request->isAJAX()) {
			$customerID = $this->request->getGet('id');
			$customer	= $this->SalesModel->getCustomers($customerID);
			echo json_encode($customer);
		} else {
			$customerID = $this->request->getGet('id');
			if ($customerID) {
				$data = array_merge($this->data, [
					'title'     	=> 'Customers',
					'customer'  	=> ($customerID) ? $this->SalesModel->getCustomers($customerID) : [],
					'CustomerPet'   => $this->SalesModel->getCustomerPet($customerID)
				]);
				return view('sales/customer_detail', $data);
			}
			$data = array_merge($this->data, [
				'title'         => 'Customers',
				'Customers'    => $this->SalesModel->getCustomers()
			]);
			return view('sales/customer_list', $data);
		}
	}

	public function customerPet()
	{
		$customerID = $this->request->getGet('customer');
		echo json_encode($this->SalesModel->getCustomerPet($customerID));
	}

	public function createCustomer()
	{
		$source = $this->request->getPost('source');
		$createCustomers = $this->SalesModel->createCustomers($this->request->getPost(null));
		if ($createCustomers) {
			session()->setFlashdata('notif_success', '<b>Successfully added new customer</b>');
			return redirect()->to(base_url($source));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new customer</b>');
			return redirect()->to(base_url($source));
		}
	}
	public function updateCustomer()
	{
		$updateCustomers = $this->SalesModel->updateCustomers($this->request->getPost(null));
		if ($updateCustomers) {
			session()->setFlashdata('notif_success', '<b>Successfully update customer</b>');
			return redirect()->to(base_url('customers'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update customer</b>');
			return redirect()->to(base_url('customers'));
		}
	}

	public function deleteCustomer($CustomersID)
	{
		if (!$CustomersID) {
			return redirect()->to(base_url('customers'));
		}
		$deleteCustomers = $this->SalesModel->deleteCustomers($CustomersID);
		if ($deleteCustomers) {
			session()->setFlashdata('notif_success', '<b>Successfully delete customer</b>');
			return redirect()->to(base_url('customers'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete customer</b>');
			return redirect()->to(base_url('customers'));
		}
	}
	public function createCustomerPet()
	{
		$createCustomerPet = $this->SalesModel->createCustomerPet($this->request->getPost(null));
		if ($createCustomerPet) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Customer Pet</b>');
			return redirect()->to(base_url('customers?id=' . $this->request->getPost('inputCustomer')));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Customer Pet</b>');
			return redirect()->to(base_url('customers?id=' . $this->request->getPost('inputCustomer')));
		}
	}
}
