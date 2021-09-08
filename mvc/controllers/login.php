<?php
class login extends controller
{
    public $user;

    public function __construct()
    {
        $this->user = $this->model('adminmodel');
    }

    public function default()
    {
        $this->view('adminlogin', [
            'title' => 'Đăng nhập hệ thống',
            'error' => isset($_SESSION['error']) ? $_SESSION['error'] : ''
        ]);

        //reset the error message:
        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }

        if (isset($_POST['login'])) {
            $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
            $pass = $_POST['password'];
            $login = $this->user->login($name, $pass);
            if ($login != 0) {
                $_SESSION['admin'] = $login;
                header("location: /shop/admin");
            } else {
                $_SESSION['error'] = "Sai tên đăng nhập hoặc mật khẩu";
                header("location: /shop/login");
            }
        }
    }

    public function logout() {
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
            header ('location: /shop/login');
        }
    }
}
