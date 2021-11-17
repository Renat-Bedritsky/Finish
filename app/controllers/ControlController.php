<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/ControlView.php';

class ControlController extends Controller {

    public $view;

    function __construct() {
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
        if (!isset($_POST['userData']['position']) || $_POST['userData']['position'] == 'operator' || $_POST['userData']['position'] == 'user' || $_POST['userData']['position'] == 'banned') exit(Controller::set404());
        $this->view = new ControlView;
    }

    function actionGet($login) {
        $_POST['title'] = 'Управление';
        
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