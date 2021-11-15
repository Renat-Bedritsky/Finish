<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/RegistrationView.php';

class RegistrationController extends Controller {

    public $view;

    function __construct() {
        $this->view = new RegistrationView;
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
    }

    function actionGet() {
        $_POST['title'] = 'Регистрация';
        $_POST['h1'] = 'Регистрация';

        if (isset($_POST['enter'])) {
            if ($_POST['password_1'] != $_POST['password_2']) {
                $_POST['h1'] = 'Пароли не совпадают';
            }
            else {
                $user = $this->users->checkLogin($_POST['login']);
                if ($user == 'User exist') {
                    $_POST['h1'] = 'Пользователь существует';
                }
                else if ($user == 'User not exist') {
                    $login = $_POST['login'];
                    $password = md5($_POST['password_1']);
                    $this->users->RegistrationUser($login, $password);
                    setcookie('login', md5($login.$password));
                    header("location: /");
                }
            }
        }
        
        $this->view->show();
    }
}