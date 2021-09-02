<?php
class customer extends controller
{
    public $customer;

    public function __construct()
    {
        $this->customer = $this->model('customerModel');
    }

    //call model here:
    function default()
    {
        $this->customer;
        $this->view("client", [
            'page' => 'customer',
            'title' => 'customer',
            'customerList' => $this->customer->getInfo()
        ]);
    }
    
}
