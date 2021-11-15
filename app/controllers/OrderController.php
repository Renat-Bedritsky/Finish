<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/OrderView.php';

class OrderController extends Controller {

    public $view;

    function __construct() {
        $this->products = new ProductsModel;
        $this->view = new OrderView;
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
    }

    function actionGet() {
        $_POST['title'] = 'Оформить';
        $basket = $this->users->GetBasket($_POST['userData']['author_id']);
        $total = $this->products->GetTotalPrice($basket);
        $_POST['total'] = $total;
        if (isset($_POST['order'])) header('Refresh: 5');
        $this->view->show();
    }
}