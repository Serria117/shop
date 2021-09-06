<?php
class productModel extends DB
{
    public function danhSachSP()
    {
        $sql = "SELECT * FROM sanpham ORDER BY loaiID";
        $query = $this->con->query($sql);
        $table = $query->fetch_all(MYSQLI_ASSOC);
        return $table;
    }

    public function danhSachLoaiSP(){
        $sql = "SELECT * FROM loaisp";
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
                    phiShip = '$phiShip'
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

    public function themSP($tenSP, $donGia, $donVi, $loai, $img, $moTa){
        $sql = "INSERT INTO sanpham 
        SET tenSP = ?, 
        `url` = ?, loaiID = ?, donGia = ?, donVi = ?, motaSP = ?, img = ?
        ";
        $url = $this->slug($tenSP);
        $stm = $this->con->prepare($sql);
        $stm->bind_param("ssiisss", $tenSP, $url, $loai, $donGia, $donVi, $moTa, $img);
        if($stm->execute()){
            return true;
        } else {
            return false;
        } 
        $stm->close();
    }

    public function suaSP($id, $tenSP, $donGia, $loai, $moTa, $img){
        $url = $this->slug($tenSP);
        $SP = $this->chitietSP($id);
        if ($loai == 0) {
            $loai = $SP->loaiID;
        }
        if($img == 0){
            $sql = "UPDATE sanpham SET tenSP = ?, donGia = ?, loaiID = ?, motaSP = ?, url = ?
            WHERE id = ?";
            $stm = $this->con->prepare($sql);
            $stm->bind_param("siissi", $tenSP, $donGia, $loai, $moTa, $url, $id);
            if($stm->execute()){
                return true;
            }else return false;
        } else {
            $sql = "UPDATE sanpham SET tenSP = ?, donGia = ?, loaiID = ?, motaSP = ?, url = ?, img = ? 
            WHERE id = ?";
            $stm = $this->con->prepare($sql);
            $stm->bind_param("siisssi", $tenSP, $donGia, $loai, $moTa, $url, $img, $id);
            if($stm->execute()){
                return true;
            }else return false;
        }
    }
}
