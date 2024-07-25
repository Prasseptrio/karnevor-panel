<?php

namespace App\Controllers\Master;

use App\Models\MasterModel;
use App\Controllers\BaseController;

class Services extends BaseController
{
	protected $MasterModel;
	function __construct()
	{
		$this->MasterModel = new MasterModel();
	}
	public function index()
	{
		$serviceID =  $this->request->getGet('id');
		$packageID =  $this->request->getGet('pack');
		if ($serviceID) {
			$data = array_merge($this->data, [
				'title'      		=> 'Services',
				'Services'   		=> $this->MasterModel->getServices(),
				'service'    		=> $this->MasterModel->getServices($serviceID),
				'ServicePackage'    => $this->MasterModel->getServicePackage(serviceID: $serviceID),
				'package'    		=> ($packageID) ? $this->MasterModel->getServicePackage(packageID: $packageID) : [],
				'ServiceFeature'    => $this->MasterModel->getServiceFeature($packageID)
			]);
			return view('master/services_detail', $data);
		}
		$data = array_merge($this->data, [
			'title'       => 'Services',
			'Services'    => $this->MasterModel->getServices()
		]);
		return view('master/services_list', $data);
	}
	public function servicePackage()
	{
		$packageID =  $this->request->getGet('id');
		echo json_encode($this->MasterModel->getServicePackage(packageID: $packageID));
	}
	public function createServices()
	{
		$createServices = $this->MasterModel->createServices($this->request->getPost(null));
		if ($createServices) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Services</b>');
			return redirect()->to(base_url('services'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Services</b>');
			return redirect()->to(base_url('services'));
		}
	}

	public function createServicePackage()
	{
		$createServicePackage = $this->MasterModel->createServicePackage($this->request->getPost(null));
		if ($createServicePackage) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Service Package</b>');
			return redirect()->to(base_url('services?id=' . $this->request->getPost('inputService')));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Service Package</b>');
			return redirect()->to(base_url('services?id=' . $this->request->getPost('inputService')));
		}
	}

	public function createServiceFeature()
	{
		$createServiceFeature = $this->MasterModel->createServiceFeature($this->request->getPost(null));
		if ($createServiceFeature) {
			session()->setFlashdata('notif_success', '<b>Successfully added new Service Feature</b>');
			return redirect()->to(base_url('services?id=' . $this->request->getPost('inputService') . '&pack=') . $this->request->getPost('inputServicePackage'));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Service Feature</b>');
			return redirect()->to(base_url('services?id=' . $this->request->getPost('inputService') . '&pack=') . $this->request->getPost('inputServicePackage'));
		}
	}
}
