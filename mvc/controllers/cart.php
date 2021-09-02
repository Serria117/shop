<?php
class cart extends controller
{
    public $cart;
    public function __construct()
    {
        $this->cart = $this->model('productModel');
    }

    public function default()
    {
        $this->view("client", [
            'title' => "Thông tin đặt hàng",
            'page' => "cart"
        ]);
    }

    public function dathang()
    {
        if (isset($_POST['checkout'])) {
            if (!empty($_SESSION['cart'])) {
                $cart = $_SESSION['cart'];
                $dienThoai = filter_var($_POST['dienThoai'], FILTER_SANITIZE_STRING);
                $tenKH = filter_var($_POST['tenKH'], FILTER_SANITIZE_STRING);
                $diaChi = filter_var($_POST['diaChi'], FILTER_SANITIZE_STRING);
                $yeuCau = htmlspecialchars($_POST['yeuCau']);
                $thanhToan = $_POST['thanhToan'];
                $phiShip = 0;
                $total = $_SESSION['total'];
                $this->cart->checkOut($tenKH, $dienThoai, $diaChi, $yeuCau, $thanhToan, $phiShip, $cart, $total);
                $result = "
                Đặt hàng thành công. Chúng tôi sẽ liên hệ với bạn qua số điện thoại $dienThoai để giao hàng, bạn vui lòng để ý cuộc gọi. Xin cảm ơn! <br>
                Bạn sẽ được chuyển về Trang chủ sau 5 giây...
                ";
            } else {
                $result = "Bạn phải chọn sản phẩm để đặt hàng.";
            }
            $this->view("client", [
                'title' => "Thông tin đặt hàng",
                'page' => "cart",
                'mess' => $result
            ]);
        }
    }
}
