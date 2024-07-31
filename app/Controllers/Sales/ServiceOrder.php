<?php

namespace App\Controllers\Sales;

use App\Models\SalesModel;
use App\Models\MasterModel;
use App\Models\FinanceModel;
use App\Controllers\BaseController;

class ServiceOrder extends BaseController
{
	protected $MasterModel;
	protected $SalesModel;
	protected $FinanceModel;
	function __construct()
	{
		$this->MasterModel 	= new MasterModel();
		$this->SalesModel = new SalesModel();
		$this->FinanceModel = new FinanceModel();
	}
	public function index()
	{
		$serviceID =  $this->request->getGet('id');
		$packageID =  $this->request->getGet('pack');
		if ($serviceID) {
			$data = array_merge($this->data, [
				'title'      		=> 'Services',
				// 'Services'   		=> $this->MasterModel->getServices(),
				// 'service'    		=> $this->MasterModel->getServices($serviceID),
				// 'ServicePackage'    => $this->MasterModel->getServicePackage(serviceID: $serviceID),
				// 'package'    		=> ($packageID) ? $this->MasterModel->getServicePackage(packageID: $packageID) : [],
				// 'ServiceFeature'    => $this->MasterModel->getServiceFeature($packageID)
			]);
			return view('master/services_detail', $data);
		}
		$data = array_merge($this->data, [
			'title'       => 'Services',
			// 'Services'    => $this->MasterModel->getServices()
		]);
		return view('master/services_list', $data);
	}

	public function createServiceOrder()
	{
		$createServiceOrder = $this->SalesModel->createServiceOrder($this->request->getPost(null));
		if ($createServiceOrder['status'] == true) {
			$grandTotal 		= $this->request->getPost('inputTotal') - $this->request->getPost('inputDiscount');
			$paymentMethod 		= $this->request->getPost('inputPaymentMethod');
			$this->FinanceModel->updatePettyCashBalance(incoming: $grandTotal, pettycashID: $paymentMethod, status: 1);
			session()->setFlashdata('notif_success', '<b>Successfully added new Service Order</b>');
			return redirect()->to(base_url('poservice/print?inv=' . $createServiceOrder['data']['invoice']));
		} else {
			session()->setFlashdata('notif_error', '<b>Failed to add new Service Order</b> ' . $createServiceOrder['message']);
			return redirect()->to(base_url('poservice'));
		}
	}
	public function printServiceOrder()
	{
		$invoice = $this->request->getGet('inv');
		if (!$invoice) {
			return redirect()->to(base_url('poservice'));
		} else {
			$serviceOrder = $this->SalesModel->getServiceOrderByInvoice($invoice);
			$data = array_merge($this->data, [
				'title'     			=> 'Print Service Order ' . $invoice,
				'ServiceOrder'    		=> $serviceOrder,
				'ServiceOrderDetail'	=> $this->SalesModel->getServiceOrderDetailByInvoice($invoice ?? '')
			]);
			return view('sales/service_order_print', $data);
		}
	}

	public function reservation()
	{
		$reservationID = $this->request->getGet('id');
		if ($reservationID) {
			$data = array_merge($this->data, [
				'title'         		=> 'Reservation',
				'Reservation'    		=> $this->SalesModel->getReservation(ReservationID: $reservationID),
				'ReservationDetail'    	=> $this->SalesModel->getReservationDetailByID(ReservationID: $reservationID)
			]);
			return view('sales/reservationDetail', $data);
		} else {
			$data = array_merge($this->data, [
				'title'         		=> 'Reservation',
				'Customers' 			=> $this->SalesModel->getCustomers(),
				'ReservationWait'    	=> $this->SalesModel->getReservation(transactionDate: $this->request->getGet('date'), status: '1'),
				'ReservationApprove'    => $this->SalesModel->getReservation(transactionDate: $this->request->getGet('date'), status: '2'),
				'ReservationCancel'    	=> $this->SalesModel->getReservation(transactionDate: $this->request->getGet('date'), status: '3'),
				'ReservationSuccess'    => $this->SalesModel->getReservation(transactionDate: $this->request->getGet('date'), status: '4'),
			]);
			// dd($data);
			return view('sales/reservation', $data);
		}
	}
	public function getArrivalTime()
	{
		$reservationDate = $this->request->getGet('date');
		echo json_encode($this->SalesModel->getArrivalTime($reservationDate));
	}

	// public function followUpReservation()
	// {
	// 	$reservationID = $this->request->getGet('id');
	// 	$reservationDetail = $this->SalesModel->getReservation($reservationID);
	// 	$reservation = $this->Whatsapp->followup($reservationDetail);
	// 	if ($reservation == 'Success') {
	// 		session()->setFlashdata('notif_success', '<b>Success!</b> Successfully send follow-up Massage to Customer');
	// 		return redirect()->to(base_url('reservation?id=' . $reservationID));
	// 	} else {
	// 		session()->setFlashdata('notif_error', 'Failed send follow-up Massage to Customer, ' . $reservation);
	// 		return redirect()->to(base_url('reservation?id=' . $reservationID));
	// 	}
	// }
	public function approveReservation()
	{
		$reservationID = $this->request->getGet('id');
		$reservation = $this->SalesModel->approveReservation($reservationID);
		if ($reservation) {
			session()->setFlashdata('notif_success', '<b>Success!</b> Successfully Approved Reservation');
			return redirect()->to(base_url('reservation?id=' . $reservationID));
		} else {
			session()->setFlashdata('notif_error', 'Failed Approved Reservation');
			return redirect()->to(base_url('reservation?id=' . $reservationID));
		}
	}
	public function cancelReservation()
	{
		$reservationID = $this->request->getGet('id');
		$reservation = $this->SalesModel->cancelReservation($reservationID);
		if ($reservation) {
			session()->setFlashdata('notif_success', '<b>Success!</b> Successfully cancel Reservation');
			return redirect()->to(base_url('reservation?id=' . $reservationID));
		} else {
			session()->setFlashdata('notif_error', 'Failed cancel Reservation');
			return redirect()->to(base_url('reservation?id=' . $reservationID));
		}
	}
	public function reschaduleReservation()
	{
		$reservationID = $this->request->getPost('id');
		$reschaduleReservation = $this->SalesModel->reschaduleReservation($reservationID, $this->request->getPost('reservation_date'));
		if ($reschaduleReservation) {
			session()->setFlashdata('notif_success', '<b>Success!</b> Successfully reschadule Reservation');
			return redirect()->to(base_url('reservation?id=' . $reservationID));
		} else {
			session()->setFlashdata('notif_error', 'Failed reschadule Reservation');
			return redirect()->to(base_url('reservation?id=' . $reservationID));
		}
	}
	public function saveReservation()
	{
		$reservation = $this->SalesModel->saveReservation($this->request->getPost());
		if ($reservation) {
			session()->setFlashdata('notif_success', '<b>Success!</b> Successfully added new Reservation');
			return redirect()->to(base_url('reservation'));
		} else {
			session()->setFlashdata('notif_error', 'Failed added new Reservation');
			return redirect()->to(base_url('reservation'));
		}
	}
	public function getCustomerPet()
	{
		$customerID = $this->request->getPost('customer');
		return json_encode($this->SalesModel->getCustomerPet($customerID));
	}
}
