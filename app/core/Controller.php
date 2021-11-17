<?php
require_once 'app/models/CategoriesModel.php';
require_once 'app/models/ProductsModel.php';
require_once 'app/models/UsersModel.php';
require_once 'app/models/CommentsModel.php';
require_once 'app/models/OrdersModel.php';

class Controller {
    public $categories, $comments, $users, $products, $orders;

    function __construct() {
        
    }

    public static function set404(){
        include_once 'app/core/View.php';
        (new View('other'))->show();
    }
}