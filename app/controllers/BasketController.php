<?php
require_once 'app/core/Controller.php';
require_once 'app/view/BasketView.php';

class BasketController extends Controller {

    function __construct() {
        $this->products = new ProductsModel;
        $this->view = new BasketView;
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
    }

    function ActionGet() {
        $_POST['title'] = 'Корзина';
        $array = $this->users->GetBasket($_POST['userData']['author_id']);

        if (isset($_POST['plus'])) {
            $this->users->PlusBasket($array, $_POST['plus'], $_POST['userData']['author_id']);
            $array = $this->users->GetBasket($_POST['userData']['author_id']);
            header('Refresh: 0');
        }
        else if (isset($_POST['minus'])) {
            $this->users->MinusBasket($array, $_POST['minus'], $_POST['userData']['author_id']);
            $array = $this->users->GetBasket($_POST['userData']['author_id']);
            header('Refresh: 0');
        }

        $basket = $this->products->ProductsForBasket($array);

        $_POST['basket'] = $basket;
        $this->view->show();
    }
}