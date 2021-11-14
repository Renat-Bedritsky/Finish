<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/CategoriesView.php';

class CategoriesController extends Controller {

    public $view;

    function __construct() {
        $this->categories = new CategoriesModel;
        $this->view = new CategoriesView;
        $this->users = new UsersModel;
        $userData = $this->users->CheckCookieLogin();
        $_POST['userData'] = $userData;
    }

    function actionGet() {
        $_POST['title'] = 'Категории';
        $categories = $this->categories->GetInfo();
        $_POST['categories'] = $categories;
        $this->view->show();
    }
}