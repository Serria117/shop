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
                'table' => $this->admin->orderList(""),
                'user' => $_SESSION['admin']
            ]);
        } else {
            header("location: /shop/admin/login");
        }
    }

    public function timkiem()
    {
        if (isset($_SESSION['admin'])) {
            $search = '';
            if (isset($_POST['search-order'])) {
                $search = $_POST['search-order'];
            }
            $this->view("admin", [
                'title' => 'Quản lý bán hàng',
                'page' => 'adminhome',
                'table' => $this->admin->orderList($search),
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
                'table' => $this->admin->danhSachSP(),
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
                'table' => $this->admin->orderList(""),
                'user' => $_SESSION['admin']
            ]);
        } else {
            header("location: /shop/admin/login");
        }
    }

    public function themSP()
    {
        if (isset($_SESSION['admin'])) {
            if (isset($_POST['add'])) {
                $tenSP = $_POST['name'];
                $loaiSP = $_POST['loai'];
                $moTa = $_POST['mota'];
                $donGia = $_POST['donGia'];
                $donVi = $_POST['donVi'];

                //Xử lý file ảnh upload:
                $checkUpload = [];
                $folder = './public/images/sanpham/';
                $file = $_FILES['img'];
                $findExt = explode('.', $file['name']);
                $fileExt = strtolower(end($findExt));
                $allowExt = ['jpg', 'png', 'gif'];
                if ($file['size'] > 5242880) {
                    $checkUpload['size'] = 'File size must be less than 5MB!';
                }
                if (!in_array($fileExt, $allowExt)) {
                    $checkUpload['type'] = 'Invalid image format.';
                }
                if (count($checkUpload) != 0) {
                    print_r($checkUpload);
                    exit();
                } else {
                    $fileName = uniqid() . $file['name'];
                    move_uploaded_file($file['tmp_name'], $folder . $fileName);
                    $img = $fileName;
                }

                $result = $this->product->themSP($tenSP, $donGia, $donVi, $loaiSP, $img, $moTa);
                if ($result === false) {
                    echo "False";
                    exit;
                } else {
                    header("location: /shop/admin/product");
                }
            }
        } else {
            header("location: /shop/admin/login");
        }
    }

    public function admin_updateSP()
    {
        if (isset($_SESSION['admin'])) {
            if (isset($_POST['update'])) {
                $id = $_POST['update-id'];
                $tenSP = $_POST['update-name'];
                $loai = $_POST['update-loai'];
                $donGia = $_POST['update-giaban'];
                $moTa = $_POST['update-mota'];
                $img = 0;
                echo $id . "<br>" . $tenSP ."<br>";
                if ($_FILES['update-img']['name'] != '') {
                    $checkUpload = [];
                    $folder = './public/images/sanpham/';
                    $SP = $this->product->chiTietSP($id);
                    $oldImg = $folder . $SP->img;
                    $file = $_FILES['update-img'];
                    $findExt = explode('.', $file['name']);
                    $fileExt = strtolower(end($findExt));
                    $allowExt = ['jpg', 'png', 'gif'];
                    if ($file['size'] > 5242880) {
                        $checkUpload['size'] = 'File size must be less than 5MB!';
                    }
                    if (!in_array($fileExt, $allowExt)) {
                        $checkUpload['type'] = 'Invalid image format.';
                    }
                    if (count($checkUpload) > 0) {
                        $img = 0;
                        echo "Image error";
                        
                    } else {
                        $fileName = uniqid() . "-" . $file['name'];
                        move_uploaded_file($file['tmp_name'], $folder . $fileName);
                        $img = $fileName;
                        if(file_exists($oldImg)){
                            unlink($oldImg);
                        };
                    }
                }
                $result = $this->product->suaSP($id, $tenSP, $donGia, $loai, $moTa, $img);
                if ($result === false) {
                    echo "FALSE";
                } else {
                    echo "TRUE";
                    header ("location: /shop/admin/product");
                }
            } else echo 'Không có thông tin';
        } else {
            header("location: /shop/admin/login");
        }
    }
}
