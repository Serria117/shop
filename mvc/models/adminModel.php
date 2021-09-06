<?php
class adminModel extends DB
{
    public function login($name, $password)
    {
        $error = '';
        $sql_name = "SELECT * FROM users WHERE userName = ?";
        $stm = $this->con->prepare($sql_name);
        $stm->bind_param("s", $name);
        $stm->execute();
        $result = $stm->get_result();
        if ($result->num_rows === 1) {
            $login = $result->fetch_assoc();
            if (password_verify($password, $login['userPass'])) {
                return $login;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function danhsachSP()
    {
        $sql = "SELECT sp.id, sp.donGia, sp.tenSP, sp.img, sp.created_on, sp.updated_on, sp.tonKho,
        SUM(soluong) as 'daBan' FROM donhangchitiet as dh
        RIGHT JOIN sanpham as sp ON dh.sanphamID = sp.id 
        GROUP BY sp.tenSP ORDER BY sp.created_on DESC";
        $query = $this->con->query($sql);
        $result = $query->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function orderlist($search)
    {
        $search = $this->con->real_escape_string($search);
        $sql = "SELECT kh.tenKH, kh.dienThoai, dh.giaTri, dh.status, dh.id as dhID, dh.created_on, dh.updated_on 
        FROM donhang as dh INNER JOIN khachhang as kh ON dh.idKH = kh.id 
        WHERE kh.tenKH LIKE '%$search%' OR kh.dienThoai LIKE '%$search%'
        ORDER BY dh.created_on DESC LIMIT 100";
        $query = $this->con->query($sql);
        $result = $query->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function hienThiDonHang($id)
    {
        $sql = "SELECT kh.tenKH, 
        dh.id, dh.diaChi, dh.dienThoai, dh.giaTri, dh.yeuCau, dh.thanhToan, dh.status, dh.created_on, dh.updated_on,
        sp.tenSP, ct.soluong, ct.giaban
        FROM donhang as dh INNER JOIN donhangchitiet as ct ON dh.id = ct.donhangID
        INNER JOIN khachhang as kh ON dh.idKH = kh.id
        INNER JOIN sanpham as sp ON sp.id = ct.sanphamID
        WHERE dh.id = '$id'";
        if ($query = $this->con->query($sql)) {
            $result = $query->fetch_all(MYSQLI_ASSOC);
            $result = json_encode($result);
            return $result;
        } else return 0;
    }

    public function updateOrder($id, $value)
    {
        $sql = "UPDATE donhang SET status = '$value' WHERE id = '$id'";
        $this->con->query($sql);
    }

    public function updateProduct($id, $tenSP, $loaiID, $donGia, $moTa, $img)
    {
        $sql1 = "UPDATE sanpham SET 
        tenSP = ?, url = ?, loaiID = ?, donGia = ?, motaSP = ?
        WHERE id = ?";
        $sql2 = "UPDATE sanpham SET 
        tenSP = ?, url = ?, loaiID = ?, donGia = ?, motaSP = ?, img = ?
        WHERE id = ?";

        $url = $this->slug($tenSP);

        if ($img == '') {
            $stm = $this->con->prepare($sql1);
            $stm->bind_param("ssisiss", $tenSP, $url, $loaiID, $donGia, $moTa, $id);
            $stm->execute();
        } else {
            $stm = $this->con->prepare($sql2);
            $stm->bind_param("ssisisss", $tenSP, $url, $loaiID, $donGia, $moTa, $img, $id);
            $stm->execute();
        }
    }

    public function chitietSP($id)
    {
        $sql = "SELECT * FROM sanpham INNER JOIN loaisp ON sanpham.loaiID = loaisp.id
         WHERE sanpham.id = '$id'";
        $query = $this->con->query($sql);
        $result = $query->fetch_all(MYSQLI_ASSOC);
        $json = json_encode($result);
        return $json;
    }
}
