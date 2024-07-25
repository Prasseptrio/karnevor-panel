<?php

namespace App\Controllers\Inventory;

use App\Models\MasterModel;
use App\Models\InventoryModel;
use App\Controllers\BaseController;

class Stock extends BaseController
{
	protected $InventoryModel;
	protected $MasterModel;
	function __construct()
	{
		$this->InventoryModel = new InventoryModel();
		$this->MasterModel = new MasterModel();
	}

	public function initial_stock()
	{
		$data = array_merge($this->data, [
			'title'         => 'Initial Stock',
			'InitialStock'  => $this->InventoryModel->getInitialStock(),
			'Products'  	=> $this->MasterModel->getProducts(),
		]);
		return view('inventory/initial_stock', $data);
	}

	public function createInitialStock()
	{
		$createInitialStock = $this->InventoryModel->createInitialStock($this->request->getPost(null));
		if ($createInitialStock) {
			session()->setFlashdata('notif_success', '<b>Successfully added new initial stock</b>');
			return redirect()->to(base_url('initial-stock'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new initial stock</b>');
			return redirect()->to(base_url('initial-stock'));
		}
	}

	public function updateInitialStock()
	{
		$updateInitialStock = $this->InventoryModel->updateInitialStock($this->request->getPost(null));
		if ($updateInitialStock) {
			session()->setFlashdata('notif_success', '<b>Successfully update initial stock</b>');
			return redirect()->to(base_url('initial-stock'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update initial stock</b>');
			return redirect()->to(base_url('initial-stock'));
		}
	}

	public function deleteInitialStock()
	{
		$deleteInitialStock = $this->InventoryModel->deleteInitialStock($this->request->getPost(null));
		if ($deleteInitialStock) {
			session()->setFlashdata('notif_success', '<b>Successfully delete initial stock</b>');
			return redirect()->to(base_url('initial-stock'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete initial stock</b>');
			return redirect()->to(base_url('initial-stock'));
		}
	}

	public function stock_card()
	{
		$Product = $this->request->getGet('product');
		$Period  = date('Y');

		$data = array_merge($this->data, [
			'title'         => 'Stock Card',
			'Products'  	=> $this->MasterModel->getProducts(),
			'ProductStock'  => $this->InventoryModel->getInitialStock($Period, $Product),
			'StockCard'   	=> $this->InventoryModel->getStockCard($Product),
			'inputProduct'  => $Product,
		]);
		return view('inventory/stock_card', $data);
	}

	public function insertPOStockCard()
	{
		$purchaseOrderID = $this->request->getPost('inputPurchaseOrderID');
		$updatePurchaseOrder = $this->InventoryModel->insertPOStockCard($purchaseOrderID);
		if ($updatePurchaseOrder) {
			session()->setFlashdata('notif_success', '<b>Successfully moving to stock</b>');
			return redirect()->to(base_url('purchase-order?id=' . $purchaseOrderID));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to moving to stock</b>');
			return redirect()->to(base_url('purchase-order?id=' . $purchaseOrderID));
		}
	}
}
