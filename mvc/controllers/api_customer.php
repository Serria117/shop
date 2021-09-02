<?php
//Example of API:
class api_customer extends controller
{
    public function danhSach()
    {
        //model:
        $customer = $this->model('customerModel');
        $cInfo = $customer->getInfo();
        $arr = [];
        while ($row = $cInfo->fetch_assoc()) {
            array_push($arr, new getCustomer($row['customerID'], $row['customerName'], $row['customerEmail']));
        }
        $json = json_encode($arr); //encode array into json
        echo $json;
    }
}

class getCustomer
{
    public $customerID;
    public $customerName;
    public $CustomerEmail;

    public function __construct($id, $name, $email)
    {
        $this->customerID = $id;
        $this->customerName = $name;
        $this->CustomerEmail = $email;
    }
}
