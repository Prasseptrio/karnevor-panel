<?php

namespace App\Controllers\Common;

use App\Controllers\BaseController;

class Cart extends BaseController
{
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
