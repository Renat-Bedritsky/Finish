<?php
require_once 'app/core/Controller.php';
require_once 'app/view/DetailView.php';

class DetailController extends Controller {

    function __construct() {
        $this->users = new UsersModel;
        $_POST['userData'] = $this->users->CheckCookieLogin();
        $this->products = new ProductsModel;
        $this->comments = new CommentsModel;
        $this->view = new DetailView;
    }

    function ActionGet($code) {
        $data = $this->products->GetProduct($code);
        $_POST['title'] = $data[0]['name'];
        if (empty($data)) exit(Controller::set404());
        $login = $this->users->GetLogin($data[0]['author_id']);
        $data[0] += ['author' => $login];
        unset($data[0]['author_id']);

        if ($this->comments->GetComments($code) != 0) {
            $com = $this->comments->GetComments($code);
            $ar = $this->users->getUsers($com);
            $data += ['comments' => $ar];
            foreach ($data['comments'] as $key => $comment) {
                $resolution = ResolutionDelete($comment['user'], $_POST['userData']);
                $data['comments'][$key]['user'] += ['resolution' => $resolution];
            }
        }

        if (isset($_POST['plus'])) {
            $array = $this->users->GetBasket($_POST['userData']['author_id']);
            $this->users->PlusBasket($array, $_POST['plus'], $_POST['userData']['author_id']);
            header('Refresh: 0');
        }

        // Добавление коментария
        if(isset($_POST['enter_comment'])) {
            $newComment = [
                'author_id' => $_POST['userData']['author_id'],
                'product_code' => $data[0]['code'],
                'content' => $_POST['content']
            ];
            $this->comments->AddComments($newComment);
            header('Refresh: 0');
        }

        // Изменение коментария
        if (isset($_POST['enter_update'])) {
            $this->comments->UpdateComments($_POST['content'], $_POST['author_id'], $_POST['date']);
            header('Refresh: 0');
        }

        // Удаление коментария
        if (isset($_POST['delete_comment_yes'])) {
            $this->comments->DeleteComment($_POST['delete_comment_yes']);
            header('Refresh: 0');
        }

        $_POST['data'] = $data;
        $this->view->show();
    }
}