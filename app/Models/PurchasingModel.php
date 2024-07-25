<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchasingModel extends Model
{

    public function getSuppliers($SuppliersID = false)
    {
        if ($SuppliersID) {
            return $this->db->table('suppliers')
                ->where(['suppliers.supplier_id' => $SuppliersID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('suppliers')
                ->get()->getResultArray();
        }
    }

    public function createSuppliers($dataSuppliers)
    {
        return $this->db->table('suppliers')->insert([
            'company'           => $dataSuppliers['inputCompany'],
            'name'              => $dataSuppliers['inputName'],
            'email'             => $dataSuppliers['inputEmail'],
            'whatsapp'          => $dataSuppliers['inputWhatsapp'],
            'address'           => $dataSuppliers['inputAddress'],
            'notes'             => $dataSuppliers['inputNotes'],
        ]);
    }
    public function updateSuppliers($dataSuppliers)
    {
        return $this->db->table('suppliers')->update([
            'company'           => $dataSuppliers['inputCompany'],
            'name'              => $dataSuppliers['inputName'],
            'email'             => $dataSuppliers['inputEmail'],
            'whatsapp'          => $dataSuppliers['inputWhatsapp'],
            'address'           => $dataSuppliers['inputAddress'],
            'notes'             => $dataSuppliers['inputNotes'],
        ], ['supplier_id' => $dataSuppliers['inputSuppliersID']]);
    }

    public function deleteSuppliers($SuppliersID)
    {
        return $this->db->table('suppliers')->delete(['supplier_id' => $SuppliersID]);
    }

    public function getPurchaseOrder($PurchaseOrderID = false)
    {
        if ($PurchaseOrderID) {
            return $this->db->table('purchase_order')
                ->join('suppliers', 'purchase_order.supplier = suppliers.supplier_id')
                ->where(['purchase_order.purchase_order_id' => $PurchaseOrderID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('purchase_order')
                ->join('suppliers', 'purchase_order.supplier = suppliers.supplier_id')
                ->get()->getResultArray();
        }
    }
    public function getPurchaseOrderProduct($PurchaseOrderID)
    {
        return $this->db->table('purchase_order_product')
            ->where(['purchase_order_product.purchase_order' => $PurchaseOrderID])
            ->get()->getResultArray();
    }

    public function createPurchaseOrder($dataPurchaseOrder, $carts)
    {
        $this->db->transBegin();
        $this->db->table('purchase_order')->insert([
            'invoice_no'        => $dataPurchaseOrder['inputInvoice'],
            'supplier'          => $dataPurchaseOrder['inputSupplier'],
            'shipping_cost'     => $dataPurchaseOrder['inputShippingCost'],
            'insurance_cost'    => $dataPurchaseOrder['inputInsuranceCost'],
            'tax'               => $dataPurchaseOrder['inputTax'],
            'discount'          => $dataPurchaseOrder['inputDiscount'],
            'total'             => $dataPurchaseOrder['inputTotal'],
            'notes'             => $dataPurchaseOrder['inputNotes'],
            'transaction_date'  => $dataPurchaseOrder['inputTransactionDate'],
            'payment_status'    => 0,
            'created_at'        => time(),
        ]);
        $purchaseOrderID = $this->db->insertID();
        foreach ($carts as $cart) {
            $this->db->table('purchase_order_product')->insert([
                'purchase_order'    => $purchaseOrderID,
                'product'           => $cart['id'],
                'name'              => $cart['name'],
                'quantity'          => $cart['qty'],
                'price'             => $cart['price'],
                'subtotal'          => $cart['subtotal'],
            ]);
        }
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }
    public function paidPurchaseOrder($PurchaseOrderID)
    {
        return $this->db->table('purchase_order')->update([
            'payment_status'        => 1,
            'paid_date'             => time(),
            'updated_at'            => time(),
        ], ['purchase_order_id' => $PurchaseOrderID]);
    }

    public function deletePurchaseOrder($PurchaseOrderID)
    {
        return $this->db->table('purchase_order')->delete(['id' => $PurchaseOrderID]);
    }
}
