<?php
//AJAX controller: recieve and process AJAX request from client
class ajax extends controller
{
    public $product;
    public $user;
    public $admin;
    public function __construct()
    {
        $this->product = $this->model("productModel");
        $this->user = $this->model("userModel");
        $this->admin = $this->model("adminModel");
    }

    public function addCart()
    {
        $id = $_POST['id'];
        $qtt = $_POST['qtt'];
        $cart = $this->product->addToCart($id, $qtt);
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
            $_SESSION['cart'] = $cart;
        } else {
            foreach ($_SESSION['cart'] as $key => $value) {
                if ($key == $id) {
                    unset($_SESSION['cart'][$id]);
                }
            }
            $_SESSION['cart'] = $_SESSION['cart'] + $cart;
        }
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['subtotal'];
        }
        $_SESSION['total'] = $total;
        print_r($_SESSION['cart']);
    }

    public function updateCart()
    {
        if (isset($_POST['updateID'])) {
            $id = $_POST['updateID'];
            $qtt = $_POST['updateQtt'];
            $sub = $_POST['updateSub'];
            $total = $_POST['updateTotal'];
            
            $_SESSION['cart'][$id]['quantity'] = $qtt;
            $_SESSION['cart'][$id]['subtotal'] = $sub;
            $_SESSION['total'] = $total;
        }
        if (isset($_POST['removeID'])) {
            $rID = $_POST['removeID'];
            $value = $_SESSION['cart'][$rID]['subtotal'];
            $_SESSION['total'] = $_SESSION['total'] - $value;
            unset($_SESSION['cart'][$rID]);
        }
    }

    public function checkuser(){
        if(isset($_POST['phone'])){
            $dienThoai = $_POST['phone'];
            $json = $this->user->checkuser($dienThoai);
            echo $json;
        }
    }
    public function hienThiDon(){
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $json = $this->admin->hienThiDonHang($id);
            echo $json;
        }
    }
}
