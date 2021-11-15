<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/AutorizationView.php';

class AutorizationController extends Controller {

    public $view;

    function __construct() {
        $this->view = new AutorizationView;
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
    }

    function actionGet() {
        $_POST['title'] = 'Авторизация';
        $_POST['h1'] = 'Авторизация';

        if (isset($_POST['enter'])) {
            if ($this->users->Autorization($_POST['login'], md5($_POST['password'])) == 'autorizationYES') {
                setcookie('login', md5($_POST['login'].md5($_POST['password'])));
                header("location: /");
            }
            else {
                $_POST['h1'] = 'Проверьте логин и пароль';
            }
        }

        if (isset($_POST['registration'])) header("location: /registration");
        
        $this->view->show();
    }

    function actionExit() {
        setcookie('login', $_POST['login'], time()-10);
        header("location: /");
    }
}