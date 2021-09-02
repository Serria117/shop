<?php
class adminModel extends DB{
    public function orderlist(){
        $sql = "SELECT kh.tenKH, kh.dienThoai, dh.giaTri, dh.status, dh.created_on, dh.updated_on 
        FROM donhang as dh INNER JOIN khachhang as kh ON dh.idKH = kh.id ORDER BY dh.updated_on DESC LIMIT 100";
        $query = $this->con->query($sql);
        $result = $query->fetch_all(MYSQLI_ASSOC);
        foreach ($result as $key=>$item){
            switch ($item['status']){
                case 0: $result[$key]['status'] = "Chưa xử lý"; break;
                case 1: $result[$key]['status'] = "Đang xử lý"; break;
                case 2: $result[$key]['status'] = "Đã giao hàng"; break;
                case -1: $result[$key]['status'] = "Đã hủy"; break;
            }
        }
        return $result;
    }
}