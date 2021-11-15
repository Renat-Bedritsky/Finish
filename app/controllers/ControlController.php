<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/ControlView.php';

class ControlController extends Controller {

    public $view;

    function __construct() {
        $this->view = new ControlView;
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
    }

    function actionGet($login) {
        $_POST['title'] = 'Управление';
        // if ($_POST['userData']['position'] != 'administrator' && $_POST['userData']['position'] != 'moderator') exit(Controller::set404());
        
        if(isset($_POST['position'])) {
            $this->users->UpdatePosition($_POST['login'], $_POST['position']);
            header('Refresh: 0');
        }

        $logins = $this->users->GetLoginAndPosition($_POST['userData']['position']);
        $_POST += ['logins' => $logins];
        $_POST += ['focus' => $login];
        $this->view->show();
    }
}