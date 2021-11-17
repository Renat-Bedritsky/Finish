<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/OrderView.php';

class OrderController extends Controller {

    public $view;

    function __construct() {
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
        if (!isset($_POST['userData']['position'])) exit(Controller::set404());
        $this->products = new ProductsModel;
        $this->orders = new OrdersModel;
        $this->view = new OrderView;
    }

    function actionGet() {
        $_POST['title'] = 'Оформить';
        $_POST['h2'] = 'Оформление заказа';
        $basket = $this->users->GetBasket($_POST['userData']['author_id']);
        $total = $this->products->GetTotalPrice($basket);
        if ($total == 0) header('location: /basket');
        $_POST['total'] = $total;

        $json = $this->users->GetJson($_POST['userData']['author_id']);
        $_POST['basket'] = $json;

        if (isset($_POST['order']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email'])) {
            if (preg_match("/^[a-zA-Zа-яА-ЯёЁ]*$/u", $_POST['name'])) {
                if (preg_match("/^(\+375|80)(29|25|44|33)(\d{3})(\d{2})(\d{2})*$/u", $_POST['phone']))  {
                    if (preg_match("/^(|(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6})$/i", $_POST['email']))  {
                        $this->orders->AddOrder($_POST['userData']['author_id'], $_POST['name'], $_POST['phone'], $_POST['email'], $_POST['basket']);
                        header('Refresh: 5');
                    }
                    else $_POST['h2'] = 'Некоректный email';
                }
                else $_POST['h2'] = 'Некоректный телефон';
            }
            else $_POST['h2'] = 'Некоректное имя';
        }
        
        $this->view->show();
    }
}