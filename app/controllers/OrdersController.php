<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/OrdersView.php';

class OrdersController extends Controller {

    public $view;

    function __construct() {
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
        if (!isset($_POST['userData']['position']) || $_POST['userData']['position'] == 'moderator' || $_POST['userData']['position'] == 'user' || $_POST['userData']['position'] == 'banned') exit(Controller::set404());
        $this->products = new ProductsModel;
        $this->orders = new OrdersModel;
        $this->view = new OrdersView;
    }

    function actionGet() {
        $_POST['title'] = 'Заказы';
        $allOrders = $this->orders->GetOrders($_POST['userData']['login']);
        $allInfo = $this->products->ForOrders($allOrders);

        if (isset($_POST['order_done'])) {
            $this->orders->DoneOrder($_POST['userData']['login'], $_POST['order_done']);
            header('Refresh: 0');
        }

        if (isset($_POST['order_canceled'])) {
            $this->orders->CanceledOrder($_POST['userData']['login'], $_POST['order_canceled']);
            header('Refresh: 0');
        }

        $_POST['orders'] = $allInfo;
        $this->view->show();
    }
}