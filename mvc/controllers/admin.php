<?php
class admin extends controller
{
    public $admin;
    public $product;
    public $user;
    public function __construct()
    {
        $this->admin = $this->model("adminModel");
        $this->product = $this->model("productModel");
        if (!isset($_SESSION['admin'])) {
            header("location: /shop/login");
        }else {
            $this->user = $_SESSION['admin'];
        }

    }

    public function default()
    {
        $this->view("admin", [
            'title' => 'Quản lý bán hàng',
            'page' => 'adminhome',
            'table' => $this->admin->orderList(""),
            'user' => $this->user
        ]);
    }

    public function timkiem()
    {
        $search = '';
        if (isset($_POST['search-order'])) {
            $search = $_POST['search-order'];
        }
        $this->view("admin", [
            'title' => 'Quản lý bán hàng',
            'page' => 'adminhome',
            'table' => $this->admin->orderList($search),
            'user' => $this->user
        ]);
    }

    public function product()
    {
        $this->view("admin", [
            'title' => 'Quản lý sản phẩm',
            'page' => 'adminproduct',
            'table' => $this->admin->danhSachSP(),
            'loaisp' => $this->product->danhSachLoaiSP(),
            'user' => $this->user
        ]);
    }


    public function updateOrder()
    {
        if (isset($_POST['save']) && isset($_POST['trangthai'])) {
            $id = $_POST['id'];
            $status = $_POST['trangthai'];
            $this->admin->updateOrder($id, $status);
        }
        $this->view("admin", [
            'title' => 'Quản lý bán hàng',
            'page' => 'adminhome',
            'table' => $this->admin->orderList(""),
            'user' => $this->user
        ]);
    }

    public function themSP()
    {
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
    }

    public function admin_updateSP()
    {
        if (isset($_POST['update'])) {
            $id = $_POST['update-id'];
            $tenSP = $_POST['update-name'];
            $loai = $_POST['update-loai'];
            $donGia = $_POST['update-giaban'];
            $moTa = $_POST['update-mota'];
            $status = $_POST['update-status'];
            $img = 0;
            echo $id . "<br>" . $tenSP . "<br>";
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
                    if (file_exists($oldImg)) {
                        unlink($oldImg);
                    };
                }
            }
            $result = $this->product->suaSP($id, $tenSP, $donGia, $loai, $moTa, $img, $status);
            if ($result === false) {
                echo "FALSE";
            } else {
                echo "TRUE";
                header("location: /shop/admin/product");
            }
        } else echo 'Không có thông tin';
    }

    public function user()
    {
        $this->view('admin', [
            'page' => 'adminuser',
            'title' => 'Quản lý người dùng',
            'user' => $this->user
        ]);
    }
}
