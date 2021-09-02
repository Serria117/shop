<?php
class customerModel extends DB{
    public function getInfo(){
        $sql = "SELECT * FROM customers";
        $query = $this->con->query($sql);
        $result = $query->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function insertCustomer($name, $email, $password){
        
    }
}
?>