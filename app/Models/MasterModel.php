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
            return $this->db->table('services')
                ->where(['services.service_id' => $ServicesID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('services')
                ->get()->getResultArray();
        }
    }

    public function createServices($dataServices)
    {
        return $this->db->table('services')->insert([
            'service_name'   => $dataServices['inputServiceName'],
        ]);
    }
    public function getServicePackage($serviceID = null, $packageID = null)
    {
        if ($serviceID) {
            return $this->db->table('service_package')
                ->join('services', 'service_package.service = services.service_id')
                ->where(['service_package.service' => $serviceID])
                ->get()->getResultArray();
        } else if ($packageID) {
            return $this->db->table('service_package')
                ->join('services', 'service_package.service = services.service_id')
                ->where(['service_package.service_package_id' => $packageID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('service_package')
                ->join('services', 'service_package.service = services.service_id')
                ->get()->getResultArray();
        }
    }
    public function createServicePackage($dataServicePackage)
    {
        return $this->db->table('service_package')->insert([
            'service'                   => $dataServicePackage['inputService'],
            'service_package_name'      => $dataServicePackage['inputServicePackageName'],
            'service_package_price'     => $dataServicePackage['inputServicePackagePrice'],
        ]);
    }

    public function getServiceFeature($ServicePackageID = false)
    {
        return $this->db->table('service_feature')
            ->where(['service_feature.service_package' => $ServicePackageID])
            ->get()->getResultArray();
    }

    public function createServiceFeature($dataServiceFeature)
    {
        return $this->db->table('service_feature')->insert([
            'service'                   => $dataServiceFeature['inputService'],
            'service_package'           => $dataServiceFeature['inputServicePackage'],
            'service_feature_name'      => $dataServiceFeature['inputServiceFeatureName'],
        ]);
    }
    public function getProductBrands($BrandsID = false)
    {
        if ($BrandsID) {
            return $this->db->table('brands')
                ->where(['brand_id' => $BrandsID])
                ->get()->getRowArray();
        } else {
            return $this->db->table('brands')
                ->get()->getResultArray();
        }
    }

    public function createBrands($dataBrands)
    {
        return $this->db->table('brands')->insert([
            'brand_name'         => $dataBrands['inputBrandName'],
        ]);
    }

    public function deleteBrands($BrandsID)
    {
        return $this->db->table('brands')->delete(['id' => $BrandsID]);
    }
}
