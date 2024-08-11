<?php

namespace App\Controllers\Common;

use App\Controllers\BaseController;
use App\Models\SalesModel;

class Cart extends BaseController
{
    protected $SalesModel;
    function __construct()
    {
        $this->SalesModel = new SalesModel();
    }
    public function insert()
    {
        $this->cart->insert([
            'id'      => $this->request->getPost('id'),
            'name'    => $this->request->getPost('name'),
            'qty'     => $this->request->getPost('qty'),
            'price'   => $this->request->getPost('price'),
            'options' => []
        ]);
        echo $this->showCart();
    }
    public function insertFormID()
    {
        $id = $this->request->getPost('id');
        $so = $this->SalesModel->getSalesOrder($id);
        $products = $this->SalesModel->getSalesOrderProduct($so['order_id']);
        $this->cart->destroy();
        foreach ($products as $product) {
            $this->cart->insert([
                'id'      => $product['product_id'],
                'name'    => $product['order_product_name'],
                'qty'     => $product['quantity'],
                'price'   => $product['price'],
                'options' => []
            ]);
        }
        echo $this->showCart();
    }

    public function showCart()
    {
        return view('common/cart', [
            'Carts' => $this->cart->contents(),
            'Total' => $this->cart->total()
        ]);
    }
    public function remove()
    {
        $this->cart->remove($this->request->getPost('rowid'));
        echo $this->showCart();
    }
    public function destroy()
    {
        $this->cart->destroy();
        echo $this->showCart();
    }
}
