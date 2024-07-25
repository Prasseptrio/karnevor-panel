<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;
use Ramsey\Uuid\Uuid;
use CodeIgniter\Database\Exceptions\DatabaseException;

class SalesModel extends Model
{
    protected $db;
    protected $uuid;
    function __construct()
    {
        $this->db   = db_connect();
        $this->uuid = Uuid::uuid4();
    }
    function getInvoice()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(sales_order_invoices,3)) AS kd_max FROM sales_order WHERE DATE(transaction_date)=CURDATE()");
        $kd = "";
        if ($q->getNumRows() > 0) {
            foreach ($q->getResult() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }

        return  '01' . date('dmy') . $kd;
    }
    function getServiceInvoice($transDate = null)
    {
        $date               = new DateTime($transDate);
        $transactionDate    = (is_null($transDate)) ? date('Y-m-d') : $date->format('Y-m-d');
        $transactionCode    = (is_null($transDate)) ? date('dmy') : $date->format('dmy');
        $q                  = $this->db->query("SELECT MAX(RIGHT(service_order_invoices,3)) AS kd_max FROM service_order WHERE DATE(transaction_date)='$transactionDate'");
        $kd = "";
        if ($q->getNumRows() > 0) {
            foreach ($q->getResult() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }

        return  '02' . $transactionCode . $kd;
    }

    public function getCustomers($CustomersID = false)
    {
        if ($CustomersID) {
            return $this->db->table('customers')
                ->where(['customers.customer_id' => $CustomersID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('customers')
                ->get()->getResultArray();
        }
    }
    public function createCustomers($dataCustomers)
    {
        return $this->db->table('customers')->insert([
            'customer_fullname'    => $dataCustomers['inputCustomerFullname'],
            'customer_address'     => $dataCustomers['inputCustomerAddress'],
            'customer_telephone'   => $dataCustomers['inputCustomerTelephone'],
            'customer_email'       => $dataCustomers['inputCustomerEmail'],
            'customer_created_at'  => time(),
        ]);
    }

    public function updateCustomers($dataCustomers)
    {
        return $this->db->table('customers')->update([
            'customer_fullname'    => $dataCustomers['inputCustomerFullname'],
            'customer_address'     => $dataCustomers['inputCustomerAddress'],
            'customer_telephone'   => $dataCustomers['inputCustomerTelephone'],
            'customer_email'       => $dataCustomers['inputCustomerEmail'],
            'customer_updated_at'  => time(),
        ], ['customer_id' => $dataCustomers['inputCustomerID']]);
    }

    public function deleteCustomers($CustomersID)
    {
        return $this->db->table('customers')->delete(['customer_id' => $CustomersID]);
    }
    public function getCustomerPet($CustomerID, $petID = false)
    {
        if ($CustomerID && $petID) {
            return $this->db->table('customer_pet')->getWhere(['customer' => $CustomerID, 'pet_id' => $petID])->getRowArray();
        } else if ($CustomerID) {
            return $this->db->table('customer_pet')->getWhere(['customer' => $CustomerID])->getResultArray();
        }
    }
    public function createCustomerPet($dataCustomerPet)
    {
        return $this->db->table('customer_pet')->insert([
            'customer'  => $dataCustomerPet['inputCustomer'],
            'pet_name'  => $dataCustomerPet['inputPetName'],
            'pet_age'   => $dataCustomerPet['inputPetAge'],
            'pet_type'  => $dataCustomerPet['inputPetType'],
        ]);
    }
    public function createSalesOrder($dataSalesOrder, $dataSalesOrderProduct)
    {
        $this->db->transBegin();
        $invoice =  $this->getInvoice();
        $this->db->table('sales_order')->insert([
            'sales_order_invoices'   => $invoice,
            'customer'               => $dataSalesOrder['inputCustomerID'],
            'sales_order_discount'   => $dataSalesOrder['inputDiscount'],
            'sales_order_tax'        => $dataSalesOrder['inputTax'],
            'sales_order_total'      => $dataSalesOrder['inputTotal'],
            'transaction_date'       => date('Y-m-d'),
            'sales_order_created_at' => time(),
        ]);
        $salesOrderID = $this->db->insertID();

        foreach ($dataSalesOrderProduct as $salesOrderProduct) {
            $this->db->table('sales_order_product')->insert([
                'sales_order'               => $salesOrderID,
                'product'                   => $salesOrderProduct['id'],
                'sales_order_product_name'  => $salesOrderProduct['name'],
                'sales_order_quantity'      => $salesOrderProduct['qty'],
                'sales_order_price'         => $salesOrderProduct['price'],
            ]);

            $product = $this->db->table('products')
                ->where(['products.product_id' => $salesOrderProduct['id']])
                ->get()->getRowArray();

            $newStock = $product['product_stock'] - $salesOrderProduct['qty'];

            $this->db->table('products')->update(['product_stock' => $newStock], ['products.product_id' => $salesOrderProduct['id']]);

            $this->db->table('stock_card')->insert([
                'product'         => $salesOrderProduct['id'],
                'sales_order'     => $invoice,
                'outcome'         => $salesOrderProduct['qty'],
                'outcome_nominal' => $salesOrderProduct['subtotal'],
                'created_at'      => time()
            ]);
        }
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return $invoice;
        }
    }

    public function getSalesOrder($SalesOrderID = false)
    {
        if ($SalesOrderID) {
            return $this->db->table('sales_order')
                ->where(['sales_order.sales_order_id' => $SalesOrderID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('sales_order')
                ->get()->getResultArray();
        }
    }
    public function getSalesOrderByInvoice($invoice)
    {
        return $this->db->table('sales_order')
            ->join('customers', 'sales_order.customer = customers.customer_id')
            ->where(['sales_order.sales_order_invoices' => $invoice])
            ->get()->getRowArray();
    }

    public function getSalesOrderProduct($SalesOrderID)
    {
        return $this->db->table('sales_order_product')
            ->where(['sales_order_product.sales_order' => $SalesOrderID])
            ->get()->getResultArray();
    }

    public function createServiceOrder($dataServiceOrder)
    {
        try {
            $this->db->transException(true)->transStart();
            $invoice =  $this->getServiceInvoice($dataServiceOrder['inputServiceDate']);
            $this->db->table('service_order')->insert([
                'service_order_invoices'        => $invoice,
                'customer'                      => $dataServiceOrder['inputCustomer'],
                'service_order_total'           => $dataServiceOrder['inputTotal'],
                'service_order_discount'        => $dataServiceOrder['inputDiscount'],
                'transaction_date'              => $dataServiceOrder['inputServiceDate'],
                'pickup_fee'                    => $dataServiceOrder['inputPickupFee'],
                'branch_id'                     => $dataServiceOrder['branch'],
                'service_order_created_at'      => time(),
            ]);
            $cp = 0;
            $srv = 0;
            for ($i = 0; $i < count($dataServiceOrder['inputCustomerPet']); $i++) {
                $servicePackageID   = $dataServiceOrder['inputService'][$srv++];
                $servicePackage     = $this->db->table('service_package')->getWhere(['service_package_id' => $servicePackageID])->getRowArray();
                $this->db->table('service_order_detail')->insert([
                    'service_order_invoices' => $invoice,
                    'pet'                    => $dataServiceOrder['inputCustomerPet'][$cp++],
                    'service_package'        => $servicePackageID,
                    'service_price'          => $servicePackage['service_package_price'],
                ]);
            }
            if ($dataServiceOrder['reservationID'] != '') {
                $this->db->table('reservation')->update(['status' => 3], ['reservation_id' => $dataServiceOrder['reservationID']]);
            }
            if ($this->db->transStatus() === false) {
            } else {
                $this->db->transCommit();
                return [
                    'status'    => true,
                    'message'   => 'success',
                    'data'      => ['invoice' => $invoice]
                ];
            }
            $this->db->transComplete();
        } catch (DatabaseException $th) {
            $this->db->transRollback();
            return [
                'status'    => false,
                'message'   => $th->getMessage(),
                'data'      => []
            ];
        }
    }
    public function getServiceOrderByInvoice($invoice)
    {
        return $this->db->table('service_order')
            ->join('customers', 'service_order.customer = customers.customer_id')
            ->where(['service_order.service_order_invoices' => $invoice])
            ->get()->getRowArray();
    }
    public function getServiceOrderDetailByInvoice(String $invoice)
    {
        return $this->db->table('service_order_detail')
            ->join('customer_pet', 'service_order_detail.pet = customer_pet.pet_id')
            ->join('service_package', 'service_order_detail.service_package = service_package.service_package_id')
            ->join('services', 'service_package.service = services.service_id')
            ->where(['service_order_invoices' => $invoice])
            ->get()->getResultArray();
    }

    public function getReservation($ReservationID = false, $reservationDate = false, $status = false)
    {
        if ($ReservationID) {
            return $this->db->table('reservation')
                ->join('customers', 'reservation.customer_id = customers.customer_id')
                ->where(['reservation.reservation_id' => $ReservationID, 'reservation_no !=' => ''])
                ->get()->getRowArray();
        } else if ($reservationDate) {
            return $this->db->table('reservation')
                ->getWhere(['reservation_date' => $reservationDate, 'reservation_no !=' => ''])->getResultArray();
        } else if ($status || $status == '0') {
            return $this->db->table('reservation')
                ->orderBy('reservation_id', 'ASC')
                ->getWhere(['status' => $status, 'reservation_no !=' => ''])
                ->getResultArray();
        } else if ($status && $reservationDate) {
            return $this->db->table('reservation')
                ->orderBy('reservation_id', 'ASC')
                ->getWhere(['status' => $status, 'reservation_date' => $reservationDate, 'reservation_no !=' => ''])
                ->getResultArray();
        } else {
            return $this->db->table('reservation')->orderBy('reservation_id', 'DESC')->get()->getResultArray();
        }
    }

    public function getReservationDetailByID($ReservationID = false)
    {
        return $this->db->table('reservation_detail')
            ->join('customer_pet', 'reservation_detail.pet_id = customer_pet.pet_id')
            ->join('service_package', 'reservation_detail.service_package = service_package.service_package_id')
            ->where(['reservation_detail.reservation_id' => $ReservationID])
            ->get()->getResultArray();
    }
    public function approveReservation($ReservationID)
    {
        return $this->db->table('reservation')->update(['status' => 1], ['reservation_id' => $ReservationID]);
    }
    public function reschaduleReservation($ReservationID, $date)
    {
        return $this->db->table('reservation')->update(['reservation_date' => $date], ['reservation_id' => $ReservationID]);
    }
    public function cancelReservation($ReservationID)
    {
        return $this->db->table('reservation')->update(['status' => 2], ['reservation_id' => $ReservationID]);
    }
    public function getMaxReservation($branch)
    {
        $getMax = $this->db->table('reservation')->selectMax('reservation_id')->get()->getRowArray();
        if ($getMax['reservation_id'] != null) {
            $maxNumber = $getMax['reservation_id'] + 1;
            $maxNumber = sprintf("%04s", $maxNumber);
        } else {
            $maxNumber = '0001';
        }
        return date('dmy') . $branch . '03' . $maxNumber;
    }
    public function saveReservation($data)
    {
        try {
            $this->db->transException(true)->transStart();
            $reservationNo = $this->getMaxReservation($data['branch']);
            $checkCustomer = $this->getCustomers($data['inputCustomer']);
            $this->db->table('reservation')->insert([
                'reservation_no'        => $reservationNo,
                'reservation_date'      => $data['inputReservationDate'],
                'branch_id'             => $data['branch'],
                'arrival_time'          => $data['input_arival_time'],
                'customer_id'           => $checkCustomer['customer_id'],
                'customer_telephone'    => $checkCustomer['customer_telephone'],
                'customer_name'         => $checkCustomer['customer_fullname'],
                'total_pet'             => count($data['inputCustomerPet']),
                'status'                => $data['pet_carrier'],
                'pickup_method'         => $data['pickup_method'],
                'notes'                 => $data['inputNotes'],
                'created_at'            => time()
            ]);

            $reservationID = $this->db->insertID('reservation', 'reservation_id');
            for ($i = 0; $i < count($data['inputCustomerPet']); $i++) {
                $this->db->table('reservation_detail')->insert([
                    'reservation_id'            => $reservationID,
                    'pet_id'                    => $data['inputCustomerPet'][$i],
                    'service_package'           => $data['service'][$i],
                ]);
            }
            $this->db->transComplete();
        } catch (DatabaseException $th) {
            $this->db->transRollback();
            return [
                'status'    => false,
                'message'   => $th->getMessage(),
                'data'      => []
            ];
        }
    }
    public function getTotalServiceThisMonthByBranch($branch = false)
    {
        $month  = date('m');
        $year   = date('Y');
        if ($branch) {
            return $this->db->table('service_order')
                ->selectSum('service_order_total')
                ->selectSum('pickup_fee')
                ->getWhere(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year, 'branch_id' => $branch])
                ->getRowArray();
        } else {
            return $this->db->table('service_order')
                ->selectSum('service_order_total')
                ->selectSum('pickup_fee')
                ->getWhere(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year])
                ->getRowArray();
        }
    }
    public function getTotalDiscountServiceThisMonthByBranch($branch = false)
    {
        $month  = date('m');
        $year   = date('Y');
        if ($branch) {
            return $this->db->table('service_order')
                ->selectSum('service_order_discount')
                ->getWhere(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year, 'branch_id' => $branch])
                ->getRowArray();
        } else {
            return $this->db->table('service_order')
                ->selectSum('service_order_discount')
                ->getWhere(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year])
                ->getRowArray();
        }
    }

    public function getLastService()
    {
        return $this->db->table('service_order')
            ->join('service_order_detail', 'service_order.service_order_invoices = service_order_detail.service_order_invoices')
            ->join('customers', 'service_order.customer = customers.customer_id')
            ->join('customer_pet', 'service_order_detail.pet = customer_pet.pet_id')
            ->orderBy('transaction_date', 'DESC')
            ->get(5)->getResultArray();
    }
    public function countServiceThisMonth()
    {
        $month  = date('m');
        $year   = date('Y');
        return $this->db->table('service_order')
            ->where(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year])
            ->countAllResults();
    }

    public function countCustomer()
    {
        return $this->db->table('customers')->countAllResults();
    }

    public function getTotalServiceByDay()
    {
        $month  = date('m');
        $year   = date('Y');
        return $this->db->table('service_order')
            ->select('transaction_date')->selectSum('service_order_total')->selectSum('pickup_fee')
            ->where(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year])
            ->groupBy('transaction_date')
            ->get()->getResultArray();
    }
    public function getTotalServiceByDayandBranch($branch)
    {
        $month  = date('m');
        $year   = date('Y');
        return $this->db->table('service_order')
            ->select('transaction_date')->selectSum('service_order_total')->selectSum('pickup_fee')->selectSum('service_order_discount')
            ->where(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year, 'branch_id' => $branch])
            ->groupBy('transaction_date')
            ->get()->getResultArray();
    }
    public function getServiceToday($day)
    {
        return $this->db->table('service_order')
            ->join('customers', 'service_order.customer = customers.customer_id')
            ->orderBy('transaction_date', 'DESC')
            ->getWhere(['transaction_date' => $day])->getResultArray();
    }
    public function getArrivalTime($ReservationDate)
    {
        return $this->db->table('reservation')->getWhere(['reservation_date' => $ReservationDate])->getResultArray();
    }
}
