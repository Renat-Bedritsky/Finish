<?php
require_once 'app/core/Controller.php';
require_once 'app/view/BasketView.php';

class BasketController extends Controller {

    function __construct() {
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
        if (!isset($_POST['userData']['position'])) header('location: /autorization');
        $this->products = new ProductsModel;
        $this->view = new BasketView;
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

        foreach ($basket['products'] as $key => $path) {
            if ($path['price'] == 0) {
                unset($basket['products'][$key]);
                $this->users->UpdateBasket($basket['products'], $_POST['userData']['login']);
                header('Refresh: 0');
            }
        }

        $_POST['basket'] = $basket;
        $this->view->show();
    }

    function ActionClear() {
        $this->users->DeleteBasket($_POST['userData']['author_id']);
        header("location: /basket");
    }
}