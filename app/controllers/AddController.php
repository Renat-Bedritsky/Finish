<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/AddView.php';

class AddController extends Controller {

    public $view;

    function __construct() {
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
        if (!isset($_POST['userData']['position']) || $_POST['userData']['position'] == 'moderator' || $_POST['userData']['position'] == 'user' || $_POST['userData']['position'] == 'banned') exit(Controller::set404());
        $this->categories = new CategoriesModel;
        $this->products = new ProductsModel;
        $this->view = new AddView;
    }

    function actionAdd() {
        $_POST['title'] = 'Добавить';
        $all = $this->categories->GetNameCategories();
        $_POST['all'] = $all;

        if (isset($_POST['enter'])) {
            $data = LoadProduct($_POST);
            $this->products->SetProduct($data);
            header("location: /");
        }
        
        $this->view->show();
    }
}