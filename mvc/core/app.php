<?php
/* this class will control the data flow */
class app
{
    protected $controller = 'home'; //The default controller is set to 'home', meaning the 'home' page will take place by default
    protected $action = 'default';
    protected $params = [];

    function __construct()
    {
        $arr = $this->urlProcess();
        if (empty($arr)) {
            $this->controller = 'home';
        } else {
            if (file_exists("./mvc/controllers/" . $arr[0] . ".php")) {
                $this->controller = $arr[0];
                unset($arr[0]);
            }
        }
        //Process controller:

        require_once "./mvc/controllers/" . $this->controller . ".php"; //load the controller file bases on its name
        $this->controller = new $this->controller;
        //Process action:
        if (isset($arr[1])) {
            if (method_exists($this->controller, $arr[1])) {
                $this->action = $arr[1];
            }
            unset($arr[1]);
        }

        //Process params:
        $this->params = $arr ? array_values($arr) : [];

        //Call the method(function) from a class, define by 'controller' (class name) and 'action' (function name)
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    function urlProcess()
    { //the URL will be take a part and store in an array: [0]=>controller, [1]=>action and the later elements are the params
        if (isset($_GET['url'])) {
            return explode('/', filter_var(trim(strtolower($_GET['url']), '/')));
        }
    }
}
