<?php
class productModel extends DB
{
    public function danhSachSP()
    {
        $sql = "SELECT * FROM sanpham";
        $query = $this->con->query($sql);
        $table = $query->fetch_all(MYSQLI_ASSOC);
        return $table;
    }

    public function chitietSP($id)
    {
        $sql = "SELECT * FROM sanpham WHERE id = ?";
        $stm = $this->con->prepare($sql);
        $stm->bind_param("i", $id);
        $stm->execute();
        $sanpham = $stm->get_result()->fetch_object();
        $stm->close();
        return $sanpham;
    }

    public function addToCart($id, $qtt)
    {
        $sp = $this->chitietSP($id);
        if (!isset($cart)) {
            $cart = [];
        }
        $cart[$id]['id'] = $id;
        $cart[$id]['name'] = $sp->tenSP;
        $cart[$id]['price'] = $sp->donGia;
        $cart[$id]['quantity'] = $qtt;
        $cart[$id]['subtotal'] = $sp->donGia * $qtt;
        return $cart;
    }

    public function checkOut($tenKH, $dienThoai, $diaChi, $yeuCau, $thanhToan, $phiShip, $cart = [], $total)
    {
        $kh = $this->con->query("SELECT id, dienThoai FROM khachhang WHERE dienThoai = '$dienThoai'");
        if ($kh->num_rows === 0) { //Nếu số điện thoại chưa đăng ký, tạo mới thông tin khách hàng
            $stm = $this->con->prepare("INSERT INTO khachhang SET tenKH = ?, diaChi = ?, dienThoai = ?");
            $stm->bind_param("sss", $tenKH, $diaChi, $dienThoai);
            $stm->execute();
            $idKH = $this->con->insert_id;
            $stm->close();
        } elseif ($kh->num_rows === 1) { //Nếu số điện thoại đã đăng ký, update thông tin khách hàng
            $stm = $this->con->prepare("UPDATE khachhang SET tenKH = ?, diaChi = ? WHERE dienThoai = ?");
            $stm->bind_param("sss", $tenKH, $diaChi, $dienThoai);
            $stm->execute();
            $stm->close();
            $idKH = $kh->fetch_object()->id;
        }
        // exit;
        //Tạo đơn:
        $sql = "INSERT INTO donhang SET
                    idKH = '$idKH', 
                    giaTri = '$total',
                    diaChi = '$diaChi',
                    dienThoai = '$dienThoai',
                    yeuCau = '$yeuCau',
                    thanhToan = '$thanhToan',
                    phiShip = $phiShip
                ";
        if ($this->con->query($sql)) {
            $idDH = $this->con->insert_id;
            foreach ($cart as $item) {
                $sql = "INSERT INTO donhangchitiet SET
                                donhangID = '$idDH',
                                sanphamID = '{$item['id']}',
                                giaban = '{$item['price']}',
                                soluong = '{$item['quantity']}'
                        ";
                $this->con->query($sql);
            }
        };
        unset($_SESSION['cart']);
        $_SESSION['cart'] = [];
        $_SESSION['total'] = 0;
    }
}
