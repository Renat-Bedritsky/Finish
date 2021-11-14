<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/BaseView.php';

class BaseController extends Controller {

    function __construct() {
        $this->products = new ProductsModel;
        $this->view = new BaseView;
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
    }

    function actionGet($page) {
        $_POST['title'] = 'Главная';
        $_GET += ['page' => $page];

        $mass = (array)$this->products->FilterProduct($_GET);

        if (isset($_GET['min']) && isset($_GET['max'])) {
            if (isset($_GET['new'])) $get = '?min='.$_GET['min'].'&max='.$_GET['max'].'&new='.$_GET['new'];
            else $get = '?min='.$_GET['min'].'&max='.$_GET['max'];
        }
        else $get = '';

        if (isset($_POST['plus'])) {
            $array = $this->users->GetBasket($_POST['userData']['author_id']);
            $this->users->PlusBasket($array, $_POST['plus'], $_POST['userData']['author_id']);
        }
        
        $mass += ['get' => $get];
        $_POST['info'] = $mass;
        $this->view->show();
    }
}