<?php
class user extends controller
{
    public $user;

    public function __construct()
    {
        $this->user = $this->model('adminModel');
    }

    //call model here:
    function default()
    {
        $this->user;
        $this->view("admin", [
            'page' => 'adminuser',
            'title' => 'Thông tin người dùng',
            
        ]);
    }
    
}
