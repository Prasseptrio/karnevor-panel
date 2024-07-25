<?php

namespace App\Models;

use CodeIgniter\Model;
use tidy;

class InventoryModel extends Model
{

    public function getInitialStock($period = false, $product = false)
    {
        if ($period && $product) {
            return $this->db->table('stock_initial')
                ->where(['stock_initial.period' => $period, 'stock_initial.product' => $product])
                ->get()->getRowArray();
        }
        if ($period) {
            return $this->db->table('stock_initial')
                ->where(['stock_initial.period' => $period])
                ->get()->getResultArray();
        } else {
            return $this->db->table('stock_initial')
                ->get()->getResultArray();
        }
    }
    public function createInitialStock($dataInitialStock)
    {
        $this->db->transBegin();
        $this->db->table('stock_initial')->insert([
            'period'      => $dataInitialStock['inputPeriod'],
            'product'     => $dataInitialStock['inputProduct'],
            'quantity'    => $dataInitialStock['inputQuantity'],
            'nominal'     => $dataInitialStock['inputNominal'],
            'created_at'  => time(),
        ]);
        $this->db->table('products')->update(['product_stock' => $dataInitialStock['inputQuantity']], ['products.product_id' => $dataInitialStock['inputProduct']]);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function deleteInitialStock($dataInitialStock)
    {
        return $this->db->table('stock_initial')->delete([
            'period'      => $dataInitialStock['inputPeriod'],
            'product'     => $dataInitialStock['inputProduct'],
        ]);
    }

    public function getStockCard($product)
    {
        return $this->db->table('stock_card')
            ->where(['stock_card.product' => $product])
            ->get()->getResultArray();
    }

    public function checkStockCardPurchaseOrder($PurchaseOrderInvoice)
    {
        return $this->db->table('stock_card')
            ->where(['stock_card.purchase_order' => $PurchaseOrderInvoice])
            ->countAllResults();
    }

    public function insertPOStockCard($PurchaseOrderID)
    {
        $purchaseOrder = $this->db->table('purchase_order')
            ->where(['purchase_order.purchase_order_id' => $PurchaseOrderID])
            ->get()->getRowArray();
        $PurchaseOrderProduct = $this->db->table('purchase_order_product')
            ->where(['purchase_order_product.purchase_order' => $PurchaseOrderID])
            ->get()->getResultArray();

        $this->db->transBegin();

        foreach ($PurchaseOrderProduct as $purchaseOrderProduct) {
            $product = $this->db->table('products')
                ->where(['products.product_id' => $purchaseOrderProduct['product']])
                ->get()->getRowArray();
            $newStock = $product['product_stock'] + $purchaseOrderProduct['quantity'];
            $this->db->table('products')->update(['product_stock' => $newStock], ['products.product_id' => $purchaseOrderProduct['product']]);
            $this->db->table('stock_card')->insert([
                'product'         => $purchaseOrderProduct['product'],
                'purchase_order'  => $purchaseOrder['invoice_no'],
                'income'          => $purchaseOrderProduct['quantity'],
                'income_nominal'  => $purchaseOrderProduct['price'] * $purchaseOrderProduct['quantity'],
                'created_at'      => time()
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
}
