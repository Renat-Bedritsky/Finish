<?php 
require_once 'app/core/Controller.php';
require_once 'app/view/ProfileView.php';

class ProfileController extends Controller {

    public $view;

    function __construct() {
        $this->users = new UsersModel;
        $userData = $this->users->CheckCookieLogin();
        if ($userData['access'] != 'allowed') {
            header('location: autorization');
        }
        $_POST['userData'] = $userData;
        $this->categories = new CategoriesModel;
        $this->products = new ProductsModel;
        $this->comments = new CommentsModel;
        $this->view = new ProfileView;
    }

    function actionData($login) {
        $_POST['title'] = 'Профиль';
        $data = $this->users->GetUserInfo($login);
        if (empty($data)) exit(Controller::set404());
        $userProducts = $this->products->ProductsOneAuthor($data[0]['id']);
        $userComments = $this->comments->CommentsOneAuthor($data[0]['id']);
        $resolution = $this->comments->ResolutionDelete($data[0], $_POST['userData']);
        if (isset($_POST['search_user'])) {
            $search = $this->users->searchUser($_POST['search_user']);
            $data += ['search' => $search];
        }
        $data += ['products' => $userProducts];
        $data += ['comments' => $userComments];
        $data += ['resolution' => $resolution];
        $_POST['data'] = $data;
        $this->view->show();
    }
}