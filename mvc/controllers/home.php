<?php
class home extends controller
{
    public $home;

    public function __construct()
    {
        $this->home = $this->model("homemodel");
    }

    //call model here:
    function default()
    {
        $this->home;
        $this->view("client", [
            'title' => 'Trang chủ',
            'page' => 'home',
        ]);
        
    }
    
}
