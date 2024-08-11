<?php

namespace App\Controllers\Sales;

use App\Models\SalesModel;
use App\Models\MasterModel;
use App\Models\FinanceModel;
use App\Models\InventoryModel;
use App\Controllers\BaseController;

class SalesOrder extends BaseController
{
	protected $MasterModel;
	protected $SalesModel;
	protected $InventoryModel;
	protected $FinanceModel;
	function __construct()
	{
		$this->MasterModel 	= new MasterModel();
		$this->SalesModel = new SalesModel();
		$this->InventoryModel = new InventoryModel();
		$this->FinanceModel = new FinanceModel();
	}
	public function sales()
	{
		$id = $this->request->getGet('id');
		if ($id) {
			$this->SalesModel->approvePayment($id);
			$so = $this->SalesModel->getSalesOrder($id);
			$data = array_merge($this->data, [
				'title'     => 'Posale',
				'Products'  => $this->MasterModel->getProducts(),
				'Customers' => $this->SalesModel->getCustomers(),
				'invoice'	=> $so['invoice_no'],
				'soID'		=> $so['order_id'],
				'so'		=> $so
			]);

			return view('sales/sales_order', $data);
		}
		$data = array_merge($this->data, [
			'title'     => 'Posale',
			'Products'  => $this->MasterModel->getProducts(),
			'Customers' => $this->SalesModel->getCustomers(),
			'invoice'	=> $this->SalesModel->getInvoice(),
			'soID'		=> ''
		]);
		return view('sales/sales_order', $data);
	}

	public function createSalesOrder()
	{
		$createSalesOrder = $this->SalesModel->createSalesOrder($this->request->getPost(null), $this->cart->contents());
		$grandTotal 		= $this->request->getPost('inputTotal') - $this->request->getPost('inputDiscount');
		if ($createSalesOrder) {
			$this->cart->destroy();
			session()->setFlashdata('notif_success', '<b>Successfully added new Sales Order</b>');
			return redirect()->to(base_url('posale/print?inv=' . $createSalesOrder));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Sales Order</b>');
			return redirect()->to(base_url('posale'));
		}
	}

	public function printSalesOrder()
	{
		$invoice = $this->request->getGet('inv');
		if (!$invoice) {
			return redirect()->to(base_url('posale'));
		}
		$salesOrder = $this->SalesModel->getSalesOrderByInvoice($invoice);
		$data = array_merge($this->data, [
			'title'     			=> 'Print Sales Order ' . $invoice,
			'SalesOrder'    		=> $salesOrder,
			'SalesOrderProduct'    	=> $this->SalesModel->getSalesOrderProduct($salesOrder['order_id'])
		]);
		return view('sales/sales_order_print', $data);
	}
}
