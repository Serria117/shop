<?php
class admin extends controller
{
    public $admin;
    public $product;
    public function __construct()
    {
        $this->admin = $this->model("adminModel");
        $this->product = $this->model("productModel");
    }

    public function login()
    {
        $this->view("adminlogin", [
            'title' => 'Đăng nhập',
            'error' => isset($_SESSION['error']) ? $_SESSION['error'] : ''
        ]);
        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }
        if (isset($_POST['login'])) {
            $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
            $pass = $_POST['password'];
            $login = $this->admin->login($name, $pass);
            if ($login != 0) {
                $_SESSION['admin'] = $login;
                header("location: /shop/admin");
            } else {
                $_SESSION['error'] = "Sai tên đăng nhập hoặc mật khẩu";
                header("location: /shop/admin/login");
            }
        }
    }

    public function default()
    {
        if (isset($_SESSION['admin'])) {
            $this->view("admin", [
                'title' => 'Quản lý bán hàng',
                'page' => 'adminhome',
                'table' => $this->admin->orderList(),
                'user' => $_SESSION['admin']
            ]);
        } else {
            header("location: /shop/admin/login");
        }
    }

    public function product()
    {
        if (isset($_SESSION['admin'])) {
            $this->view("admin", [
                'title' => 'Quản lý sản phẩm',
                'page' => 'adminproduct',
                'table' => $this->product->danhSachSP(),
                'loaisp' => $this->product->danhSachLoaiSP(),
                'user' => $_SESSION['admin']
            ]);
        } else {
            header("location: /shop/admin/login");
        }
    }

    public function updateOrder()
    {
        if (isset($_SESSION['admin'])) {
            if (isset($_POST['save']) && isset($_POST['trangthai'])) {
                $id = $_POST['id'];
                $status = $_POST['trangthai'];
                $this->admin->updateOrder($id, $status);
            }
            $this->view("admin", [
                'title' => 'Quản lý bán hàng',
                'page' => 'adminhome',
                'table' => $this->admin->orderList(),
                'user' => $_SESSION['admin']
            ]);
        } else {
            header("location: /shop/admin/login");
        }
    }

    public function themSP(){
        if (isset($_SESSION['admin'])) {
            if(isset($_POST['add'])){

            }

        } else {
            header("location: /shop/admin/login");
        }
    }
}
