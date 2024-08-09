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
        $q = $this->db->query("SELECT MAX(RIGHT(invoice_no,3)) AS kd_max FROM sales_order WHERE DATE(transaction_date)=CURDATE()");
        $kd = "";
        if ($q->getNumRows() > 0) {
            foreach ($q->getResult() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }

        return  'SKRPS-01-' . date('dmy') . $kd;
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
        $this->db->transBegin();
        $salt             = substr(md5(uniqid(rand(), true)), 0, 9);
        $name             = htmlspecialchars($dataCustomers['inputCustomerFullname']);
        $token            = base64_encode(random_bytes(32));
        $this->db->table('customers')->insert([
            'customer_fullname'    => $name,
            'customer_email'       => $dataCustomers['inputCustomerEmail'],
            'password'             => sha1($salt . sha1($salt . sha1('123456'))),
            'salt'                 => $salt,
            'token'                => $token,
            'created_at'           => time(),
        ]);
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function updateCustomers($dataCustomers)
    {
        return $this->db->table('customers')->update([
            'customer_fullname'    => $dataCustomers['inputCustomerFullname'],
            'address'              => $dataCustomers['inputCustomerAddress'],
            'customer_whatsapp'    => $dataCustomers['inputCustomerTelephone'],
            'customer_email'       => $dataCustomers['inputCustomerEmail'],
            'customer_updated_at'  => time(),
        ], ['customer_id' => $dataCustomers['inputCustomerID']]);
    }

    public function deleteCustomers($CustomersID)
    {
        return $this->db->table('customers')->delete(['customer_id' => $CustomersID]);
    }
    public function getCustomerPet($CustomerID)
    {
        return $this->db->table('customer_pet')->getWhere(['customer' => $CustomerID])->getResultArray();
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
            'invoice_no'             => $invoice,
            'customer_id'            => $dataSalesOrder['inputCustomerID'],
            'order_status'           => 17,
            'sales_order_discount'   => $dataSalesOrder['inputDiscount'],
            'sales_order_tax'        => $dataSalesOrder['inputTax'],
            'total'                  => $dataSalesOrder['inputTotal'],
            'transaction_date'       => date('Y-m-d'),
            'payment_status'         => 1,
            'payment_method'         => $dataSalesOrder['paymentMethod'],
            'notes'                  => '',
            'type'                   => '',
            'created_at'             => time(),
        ]);

        $salesOrderID = $this->db->insertID();
        foreach ($dataSalesOrderProduct as $salesOrderProduct) {
            $this->db->table('sales_order_product')->insert([
                'order_id'                  => $salesOrderID,
                'product_id'                => $salesOrderProduct['id'],
                'order_product_name'        => $salesOrderProduct['name'],
                'quantity'                  => $salesOrderProduct['qty'],
                'price'                     => $salesOrderProduct['price'],
                'total'                     => $salesOrderProduct['subtotal'],
            ]);

            $product = $this->db->table('products')
                ->where(['products.product_id' => $salesOrderProduct['id']])
                ->get()->getRowArray();
            $newStock = $product['product_stock'] - $salesOrderProduct['qty'];

            $this->db->table('products')->update(['product_stock' => $newStock], ['products.product_id' => $salesOrderProduct['id']]);

            $this->db->table('stock_card')->insert([
                'product_id'      => $salesOrderProduct['id'],
                'sales_id'        => $invoice,
                'outcome'         => $salesOrderProduct['qty'],
                'outcome_nominal' => $salesOrderProduct['subtotal'],
                'description'     => 'Penjualan nomor invoice ' . $invoice,
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
            ->join('customers', 'sales_order.customer_id = customers.customer_id')
            ->where(['sales_order.invoice_no' => $invoice])
            ->get()->getRowArray();
    }

    public function getSalesOrderProduct($SalesOrderID)
    {
        return $this->db->table('sales_order_product')
            ->where(['sales_order_product.order_id' => $SalesOrderID])
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

    public function getReservation($ReservationID = false, $transactionDate = false, $status = false)
    {
        if ($ReservationID) {
            return $this->db->table('sales_order')
                ->join('customers', 'sales_order.customer_id = customers.customer_id')
                ->where(['sales_order.order_id' => $ReservationID])
                ->get()->getRowArray();
        } else if ($transactionDate) {
            return $this->db->table('sales_order')
                ->getWhere(['transaction_date' => $transactionDate])->getResultArray();
        } else if ($status && $transactionDate) {
            return $this->db->table('sales_order')
                ->orderBy('order_id', 'DESC')
                ->getWhere(['status' => $status, 'transaction_date' => $transactionDate, 'type' => 2, 'order_status <' => 11])
                ->getResultArray();
        } else if ($status) {
            return $this->db->table('sales_order')->join('customers', 'sales_order.customer_id = customers.customer_id')->orderBy('order_id', 'DESC')->getWhere(['type' => 2, 'order_status <' => 11, 'status' => $status])->getResultArray();
        } else {
            return $this->db->table('sales_order')->join('customers', 'sales_order.customer_id = customers.customer_id')->orderBy('order_id', 'DESC')->getWhere(['type' => 2, 'order_status <' => 11,])->getRowArray();
        }
    }

    public function getReservationDetailByID($ReservationID = false)
    {
        return $this->db->table('sales_order_product')
            ->where(['sales_order_product.order_id' => $ReservationID])
            ->get()->getResultArray();
    }
    public function approveReservation($ReservationID)
    {
        return $this->db->table('reservation')->update(['status' => 2], ['reservation_id' => $ReservationID]);
    }
    public function reschaduleReservation($ReservationID, $date)
    {
        return $this->db->table('reservation')->update(['reservation_date' => $date], ['reservation_id' => $ReservationID]);
    }
    public function cancelReservation($ReservationID)
    {
        return $this->db->table('reservation')->update(['status' => 3], ['reservation_id' => $ReservationID]);
    }
    public function saveReservation($data)
    {
        try {
            $this->db->transException(true)->transStart();
            // $checkCustomer = $this->getCustomers($data['inputCustomer']);
            // $this->db->table('reservation')->insert([
            //     'reservation_date'      => $data['inputReservationDate'],
            //     'branch_id'             => $data['branch'],
            //     'arrival_time'          => $data['input_arival_time'],
            //     'customer_id'           => $checkCustomer['customer_id'],
            //     'customer_telephone'    => $checkCustomer['customer_telephone'],
            //     'customer_name'         => $checkCustomer['customer_fullname'],
            //     'total_pet'             => count($data['inputCustomerPet']),
            //     'status'                => $data['pet_carrier'],
            //     'pickup_method'         => $data['pickup_method'],
            //     'notes'                 => $data['inputNotes'],
            //     'created_at'            => time()
            // ]);

            // $reservationID = $this->db->insertID('reservation', 'reservation_id');
            // for ($i = 0; $i < count($data['inputCustomerPet']); $i++) {
            //     $this->db->table('reservation_detail')->insert([
            //         'reservation_id'            => $reservationID,
            //         'pet_id'                    => $data['inputCustomerPet'][$i],
            //         'service_package'           => $data['service'][$i],
            //     ]);
            // }
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
    public function getTotalServiceThisMonth()
    {
        $month  = date('m');
        $year   = date('Y');
        return $this->db->table('sales_order')
            ->selectSum('total')
            ->selectSum('cost_delivery')
            ->selectSum('sales_order_discount')
            ->getWhere(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year])
            ->getRowArray();
    }

    public function countSales()
    {
        $month  = date('m');
        $year   = date('Y');
        return $this->db->table('sales_order')
            ->where(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year, 'void_at' == null])
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
        return $this->db->table('sales_order')
            ->selectSum('total')->selectSum('cost_delivery')->selectSum('sales_order_discount')->selectSum('sales_order_tax')
            ->where(["MONTH(transaction_date)" => $month, "YEAR(transaction_date)" => $year,  'void_at' == null])
            ->groupBy('transaction_date')
            ->get()->getRowArray();
    }
    public function getTotalServiceByDayByMount($branch)
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
