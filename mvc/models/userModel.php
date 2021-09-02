<?php
class userModel extends DB {
    public function getList(){
        $sql = "SELECT * FROM users";
        $query = $this->con->query($sql);
        $result = $query->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function checkuser($dienThoai){
        $sql = "SELECT * FROM khachhang WHERE dienThoai = '$dienThoai'";
        $query = $this->con->query($sql);
        if($query->num_rows>0){
            $user = $query->fetch_assoc();
            $result = json_encode($user);
            return $result;
        } else {
            return null;
        }
    }
}