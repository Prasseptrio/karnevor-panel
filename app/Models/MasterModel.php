<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterModel extends Model
{

    public function getProductCategories($ProductCategoryID = false)
    {
        if ($ProductCategoryID) {
            return $this->db->table('product_category')
                ->where(['product_category.product_category_id' => $ProductCategoryID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('product_category')
                ->get()->getResultArray();
        }
    }
    public function createProductCategory($dataProductCategory)
    {
        return $this->db->table('product_category')->insert([
            'product_category_name'         => $dataProductCategory['inputProductCategoryName'],
        ]);
    }

    public function updateProductCategory($dataProductCategory)
    {
        return $this->db->table('product_category')->update([
            'product_category_name'         => $dataProductCategory['inputProductCategoryName'],
        ], ['product_category_id' => $dataProductCategory['inputProductCategoryID']]);
    }

    public function deleteProductCategory($ProductCategoryID)
    {
        return $this->db->table('product_category')->delete(['product_category_id' => $ProductCategoryID]);
    }
    public function getProducts($ProductsID = false)
    {
        if ($ProductsID) {
            return $this->db->table('products')
                ->where(['products.product_id' => $ProductsID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('products')
                ->where(['products.is_active' => '1'])
                ->get()->getResultArray();
        }
    }
    public function createProduct($dataProducts)
    {
        return $this->db->table('products')->insert([
            'product_category'      => $dataProducts['inputProductCategory'],
            'product_brand'         => $dataProducts['inputProductBrand'],
            'product_sku'           => $dataProducts['inputProductSku'],
            'product_name'          => $dataProducts['inputProductName'],
            'product_expired_at'    => $dataProducts['inputProductExpiredAt'],
            'product_image'         => $dataProducts['inputProductImage'],
            'product_description'   => $dataProducts['inputProductDescription'],
            'link_shopee'           => $dataProducts['inputLinkShopee'],
            'link_tokopedia'        => $dataProducts['inputLinkTokopedia'],
            'link_bukalapak'        => $dataProducts['inputLinkBukalapak'],
            'product_price'         => 0,
            'product_stock'         => 0,
            'product_created_at'    => time(),
        ]);
    }
    public function updateProducts($dataProducts, $imageName)
    {
        return $this->db->table('products')->update([
            'product_category'      => $dataProducts['inputProductCategory'],
            'product_brand'         => $dataProducts['inputProductBrand'],
            'product_name'          => $dataProducts['inputProductName'],
            'product_price'         => $dataProducts['inputProductPrice'],
            'product_expired_at'    => 0,
            'product_image'         => $imageName,
            'product_description'   => $dataProducts['inputProductDescription'],
            'link_shopee'           => $dataProducts['inputLinkShopee'],
            'link_tokopedia'        => $dataProducts['inputLinkTokopedia'],
            'link_bukalapak'        => $dataProducts['inputLinkBukalapak'],
            'product_updated_at'    => time(),
        ], ['product_id' => $dataProducts['inputProductsID']]);
    }
    public function deleteProducts($ProductsID)
    {
        return $this->db->table('products')->delete(['product_id' => $ProductsID]);
    }

    public function getServices($ServicesID = false)
    {
        if ($ServicesID) {
            return $this->db->table('sales_order')
                ->join('customers', 'customers.customer_id = sales_order.customer_id')
                ->where(['sales_order.invoice_no' => $ServicesID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('sales_order')
                ->join('customers', 'customers.customer_id = sales_order.customer_id')
                ->where(['type' => 1, 'void_at' == null])
                ->orderBy('order_id', 'DESC')
                ->get()->getResultArray();
        }
    }
    public function getServiceProduct($ServiceID)
    {
        $order = $this->getServices($ServiceID);
        return $this->db->table('sales_order_product')->getWhere(['order_id' => $order['order_id']])->getResultArray();
    }
}
