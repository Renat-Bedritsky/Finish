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

        // Удаление товара
        if (isset($_POST['delete_product_yes'])) {
            $this->products->DeleteProduct($_POST['delete_product_yes']);
            $this->comments->DeleteComments($_POST['delete_product_yes']);
            header('Refresh: 0');
        }

        // Удаление коментария
        if (isset($_POST['delete_comment_yes'])) {
            $this->comments->DeleteComment($_POST['delete_comment_yes']);
            header('Refresh: 0');
        }
        
        $data = $this->users->GetUserInfo($login);

        // Обновление фото профиля
        if (isset($_POST['update_foto'])) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/foto_profiles/'.$data[0]['foto']) && $data[0]['foto'] != '../site-images/start-foto.png') {
                unlink($_SERVER['DOCUMENT_ROOT'].'/public/images/foto_profiles/'.$data[0]['foto']);
            }
            $image = LoadFoto('foto_profiles');
            $id = $_POST['userData']['author_id'];
            $this->users->UpdateFoto($image, $id);
            header('location: /profile/'.$data[0]['login']);
            $data = $this->users->GetUserInfo($login);
        }

        $link = $_SERVER['DOCUMENT_ROOT'].'/public/images/foto_profiles/'.$data[0]['foto'];
        if (!file_exists($link) || $data[0]['foto'] == '') {
            $data[0]['foto'] = '../site-images/start-foto.png';
        }

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