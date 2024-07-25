<?php

namespace App\Controllers\Purchasing;

use App\Models\MasterModel;
use App\Models\InventoryModel;
use App\Models\PurchasingModel;
use App\Controllers\BaseController;

class PurchaseOrder extends BaseController
{
	protected $MasterModel;
	protected $PurchasingModel;
	protected $InventoryModel;
	function __construct()
	{
		$this->MasterModel = new MasterModel();
		$this->PurchasingModel = new PurchasingModel();
		$this->InventoryModel = new InventoryModel();
	}
	public function index()
	{
		$purchaseOrderID 	= $this->request->getGet('id');
		$purchaseOrder 		= $this->PurchasingModel->getPurchaseOrder($purchaseOrderID);
		if ($purchaseOrderID) {
			$data = array_merge($this->data, [
				'title'         			=> 'Purchase Order Detail',
				'purchaseOrder'    			=> $purchaseOrder,
				'PurchaseOrderProduct'  	=> $this->PurchasingModel->getPurchaseOrderProduct($purchaseOrderID),
				'StockCardPurchaseOrder'	=> $this->InventoryModel->checkStockCardPurchaseOrder($purchaseOrder['invoice_no'])
			]);
			return view('purchasing/purchase_order_detail', $data);
		}
		$data = array_merge($this->data, [
			'title'         	=> 'Purchase Order',
			'PurchaseOrder'    	=> $this->PurchasingModel->getPurchaseOrder()
		]);
		return view('purchasing/purchase_order_list', $data);
	}
	public function form()
	{
		$this->cart->destroy();
		$data = array_merge($this->data, [
			'title'         			=> 'Purchase Order',
			'Products'  				=> $this->MasterModel->getProducts(),
			'Suppliers'    				=> $this->PurchasingModel->getSuppliers()
		]);
		return view('purchasing/purchase_order_form', $data);
	}

	public function createPurchaseOrder()
	{
		$createPurchaseOrder = $this->PurchasingModel->createPurchaseOrder($this->request->getPost(null), $this->cart->contents());
		if ($createPurchaseOrder) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Purchase Order</b>');
			return redirect()->to(base_url('purchase-order'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Purchase Order</b>');
			return redirect()->to(base_url('purchase-order'));
		}
	}

	public function paidPurchaseOrder()
	{
		$purchaseOrderID = $this->request->getPost('inputPurchaseOrderID');
		$updatePurchaseOrder = $this->PurchasingModel->paidPurchaseOrder($purchaseOrderID);
		if ($updatePurchaseOrder) {
			session()->setFlashdata('notif_success', '<b>Successfully paid Purchase Order</b>');
			return redirect()->to(base_url('purchase-order?id=' . $purchaseOrderID));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to paid Purchase Order</b>');
			return redirect()->to(base_url('purchase-order?id=' . $purchaseOrderID));
		}
	}
	public function deletePurchaseOrder($PurchaseOrderID)
	{
		if (!$PurchaseOrderID) {
			return redirect()->to(base_url('purchase-order'));
		}
		$deletePurchaseOrder = $this->PurchasingModel->deletePurchaseOrder($PurchaseOrderID);
		if ($deletePurchaseOrder) {
			session()->setFlashdata('notif_success', '<b>Successfully delete Purchase Order</b>');
			return redirect()->to(base_url('purchase-order'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete Purchase Order</b>');
			return redirect()->to(base_url('purchase-order'));
		}
	}
}
