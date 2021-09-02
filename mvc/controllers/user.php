<?php
class user extends controller
{
    public $user;

    public function __construct()
    {
        $this->user = $this->model('userModel');
    }

    //call model here:
    function default()
    {
        $this->user;
        $this->view("client", [
            'page' => 'user',
            'title' => 'user',
            'userList' => $this->user->getList()
        ]);
    }
    
}
