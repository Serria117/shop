<?php
class DB {
    public $con;
    protected $host = "localhost";
    protected $user = 'root';
    protected $pass = '';
    protected $db = 'shop';

    function __construct()
    {
        $this->con = new mysqli($this->host, $this->user, $this->pass, $this->db);
        $this->con->query("SET NAMES 'utf8'");
    }
}
?>