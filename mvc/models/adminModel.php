<?php
class adminModel extends DB
{
    public function login($name, $password){
        $error = '';
        $sql_name = "SELECT * FROM users WHERE userName = ?";
        $stm = $this->con->prepare($sql_name);
        $stm->bind_param("s", $name);
        $stm->execute();
        $result = $stm->get_result();
        if($result->num_rows===1){
            $login = $result->fetch_assoc();
            if(password_verify($password, $login['userPass'])){
               return $login;
            }else {
                return 0;
            }
        } else {
            return 0;
        }


    }
    
    public function orderlist()
    {
        $sql = "SELECT kh.tenKH, kh.dienThoai, dh.giaTri, dh.status, dh.id as dhID, dh.created_on, dh.updated_on 
        FROM donhang as dh INNER JOIN khachhang as kh ON dh.idKH = kh.id ORDER BY dh.created_on DESC LIMIT 100";
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

    public function updateOrder($id, $value){
        $sql = "UPDATE donhang SET status = '$value' WHERE id = '$id'";
        $this->con->query($sql);
    }
}
