<?php
require_once 'app/core/Controller.php';
require_once 'app/view/DetailView.php';

class DetailController extends Controller {

    function __construct() {
        $this->categories = new CategoriesModel;
        $this->products = new ProductsModel;
        $this->comments = new CommentsModel;
        $this->view = new DetailView;
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
    }

    function ActionGet($code) {
        $_POST['title'] = 'Товар';
        $data = $this->products->GetProduct($code);
        if (empty($data)) exit(Controller::set404());
        $login = $this->users->GetLogin($data[0]['author_id']);
        $data[0] += ['author' => $login];
        unset($data[0]['author_id']);

        if ($this->comments->GetComments($code) != 0) {
            $com = $this->comments->GetComments($code);
            $ar = $this->users->getUsers($com);
            $data += ['comments' => $ar];
            foreach ($data['comments'] as $key => $comment) {
                $resolution = $this->comments->ResolutionDelete($comment['user'], $_POST['userData']);
                $data['comments'][$key]['user'] += ['resolution' => $resolution];
            }
        }
        $_POST['data'] = $data;
        $this->view->show();
    }
}