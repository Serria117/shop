<?php
/* this class will control the data flow */
class app
{
    protected $controller = 'home'; //The default controller is set to 'home', meaning the 'home' page will take place by default
    protected $action = 'default';
    protected $params = [];

    /*Xử lý URL: URL người dùng nhập vào dưới dạng domain/controller/action/parameter 
    sẽ được phân tách để lấy các giá trị của controller, action và param: 
    */
    function urlProcess()
    { 
        if (isset($_GET['url'])) {
            return explode('/', filter_var(trim(strtolower($_GET['url']), '/')));
        }
    }

    function __construct()
    {
        $arr = $this->urlProcess(); #các giá trị của controller, action, param được lưu trong 1 array để thao tác
        if (empty($arr)) { #nếu array rỗng thì set controller mặc định là home
            $this->controller = 'home';
        } else { #phần tử đầu tiên trong array là tên controller, nếu tồn tại file php chứa class controller tương ứng thì set controller = tên controller tìm thấy
            if (file_exists("./mvc/controllers/" . $arr[0] . ".php")) {
                $this->controller = $arr[0];
                unset($arr[0]);
            }
        }
        require_once "./mvc/controllers/" . $this->controller . ".php"; //load controller file
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

    
}
