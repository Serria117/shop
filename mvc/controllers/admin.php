<?php
class admin extends controller {
    public $admin;
    public $product;
    public function __construct()
    {
        $this->admin = $this->model("adminModel");
        $this->product = $this->model("productModel");
    }

    public function default(){
        $this->view("admin", [
            'title' => 'Quản lý bán hàng',
            'page' => 'adminhome',
            'table' => $this->admin->orderList()
        ]);
    }
}