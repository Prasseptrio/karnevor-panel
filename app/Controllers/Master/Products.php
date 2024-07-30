<?php

namespace App\Controllers\Master;

use App\Models\MasterModel;
use App\Controllers\BaseController;

class Products extends BaseController
{
	protected $MasterModel;
	function __construct()
	{
		$this->MasterModel = new MasterModel();
	}
	public function index()
	{
		$productID = $this->request->getGet('id');
		if ($productID) {
			$data = array_merge($this->data, [
				'title'        	=> 'Products',
				'Categories'   	=> $this->MasterModel->getProductCategories(),
				'product'		=> ($productID) ? $this->MasterModel->getProducts($productID) : [],
				// 'Brands'   		=> $this->MasterModel->getProductBrands(),
			]);
			return view('master/product_detail', $data);
		}

		$data = array_merge($this->data, [
			'title'     	=> 'Products',
			'Products'  	=> $this->MasterModel->getProducts(),
			'Categories'   	=> $this->MasterModel->getProductCategories(),
			// 'Brands'   		=> $this->MasterModel->getProductBrands(),
		]);
		return view('master/product_list', $data);
	}

	public function createProductCategory()
	{
		$createProductCategory = $this->MasterModel->createProductCategory($this->request->getPost(null));
		if ($createProductCategory) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Product Category</b>');
			return redirect()->to(base_url('products'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Product Category</b>');
			return redirect()->to(base_url('products'));
		}
	}

	public function updateProductCategory()
	{
		$updateProductCategory = $this->MasterModel->updateProductCategory($this->request->getPost(null));
		if ($updateProductCategory) {
			session()->setFlashdata('notif_success', '<b>Successfully update Product Category</b>');
			return redirect()->to(base_url('products'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to update Product Category</b>');
			return redirect()->to(base_url('products'));
		}
	}

	public function deleteProductCategory($ProductCategoryID)
	{
		if (!$ProductCategoryID) {
			return redirect()->to(base_url('products'));
		}
		$deleteProductCategory = $this->MasterModel->deleteProductCategory($ProductCategoryID);
		if ($deleteProductCategory) {
			session()->setFlashdata('notif_success', '<b>Successfully delete Product Category</b>');
			return redirect()->to(base_url('products'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete Product Category</b>');
			return redirect()->to(base_url('products'));
		}
	}

	public function createProduct()
	{
		$createProduct = $this->MasterModel->createProduct($this->request->getPost(null));
		if ($createProduct) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Products</b>');
			return redirect()->to(base_url('products'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Products</b>');
			return redirect()->to(base_url('products'));
		}
	}
	public function updateProduct()
	{
		$productImage = $this->request->getFile('inputProductImage');

		if (!$productImage->hasMoved()) {
			$imageName 		= $productImage->getRandomName();
			$productImage->move('../../cdn/images', $imageName);
			$updateProducts = $this->MasterModel->updateProducts($this->request->getPost(null), $imageName);
			if ($updateProducts) {
				session()->setFlashdata('notif_success', '<b>Successfully update Products</b>');
				return redirect()->to(base_url('products'));
			} else {
				session()->setFlashdata('notif_error', '<b>Failed to update Products</b>');
				return redirect()->to(base_url('products'));
			}
		} else {
			session()->setFlashdata('notif_error', '<b>The file has already been moved.</b>');
			return redirect()->to(base_url('products'));
		}
	}
	public function deleteProduct($productID)
	{
		if (!$productID) {
			return redirect()->to(base_url('products'));
		}
		$product = $this->MasterModel->getProducts($productID);
		unlink('../../cdn/products/' . $product['product_image']);
		$deleteProducts = $this->MasterModel->deleteProducts($productID);
		if ($deleteProducts) {
			session()->setFlashdata('notif_success', '<b>Successfully delete Products</b>');
			return redirect()->to(base_url('products'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete Products</b>');
			return redirect()->to(base_url('products'));
		}
	}
	public function createBrands()
	{
		$createBrands = $this->MasterModel->createBrands($this->request->getPost(null));
		if ($createBrands) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Brands</b>');
			return redirect()->to(base_url('products'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Brands</b>');
			return redirect()->to(base_url('products'));
		}
	}

	public function deleteBrands($BrandsID)
	{
		if (!$BrandsID) {
			return redirect()->to(base_url('brands'));
		}
		$deleteBrands = $this->MasterModel->deleteBrands($BrandsID);
		if ($deleteBrands) {
			session()->setFlashdata('notif_success', '<b>Successfully delete Brands</b>');
			return redirect()->to(base_url('products'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to delete Brands</b>');
			return redirect()->to(base_url('products'));
		}
	}
}
