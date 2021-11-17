<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/CategoryView.php';

class CategoryController extends Controller {

    public $view;

    function __construct() {
        $this->categories = new CategoriesModel;
        $this->products = new ProductsModel;
        $this->view = new CategoryView;
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
    }

    function ActionPage($string) {
        $array = explode('_', $string);
        $_POST['title'] = $this->categories->GetNameCategory($array[0]);
        $_GET += ['category' => $array[0]];
        $_GET += ['page' => $array[1]];

        $category = (array)$this->products->FilterProduct($_GET);

        if (isset($_GET['category'])) {
            $categoryInfo = $this->categories->GetOneInfo($array[0]);
            $category += ['category_info' => $categoryInfo];
        }
        if (isset($_GET['min']) && isset($_GET['max'])) {
            if (isset($_GET['new'])) $get = '?min='.$_GET['min'].'&max='.$_GET['max'].'&new='.$_GET['new'];
            else $get = '?min='.$_GET['min'].'&max='.$_GET['max'];
        }
        else $get = '';

        if (isset($_POST['plus']) && isset($_POST['userData']['position'])) {
            $array = $this->users->GetBasket($_POST['userData']['author_id']);
            $this->users->PlusBasket($array, $_POST['plus'], $_POST['userData']['author_id']);
            header('Refresh: 0');
        }
        if (isset($_POST['plus']) && !isset($_POST['userData']['position'])) header('location: /autorization');
        
        $category += ['get' => $get];
        $_POST['category'] = $category;
        $this->view->show();
    }
}