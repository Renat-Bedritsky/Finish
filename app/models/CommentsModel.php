<?php require_once 'app/core/Model.php';

class CommentsModel extends Model {

    function __construct() {
        parent::__construct();
        $this->tablename = 'comments';
    }


    // Комментарии одного автора
    function CommentsOneAuthor($id) {
        return $this->getList(['product_code, content, date'], ['author_id' => $id]);
    }


    // Функция для удаления всех коментариев к товару
    function DeleteComments($product_code) {
        $this->deleteList(['product_code' => $product_code]);
    }


    // Функция для удаления одного коментария к товару
    function DeleteComment($date) {
        $this->deleteList(['date' => $date]);
    }

    // Функция для получения коментариев
    function GetComments($product_code) {
        $data = $this->getList([], ['product_code' => $product_code]);
        if (isset($data)) return $data;
        else return 0;
    }


    // Функция для добавления коментариев
    function AddComments($data) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)
        $line = $this->getLine();

        $id = $line + 1;
        $author_id = $data['author_id'];
        $product_code = $data['product_code'];
        $content = $data['content'];
        $date = date("Y-m-d H:i:s");

        $this->insertList([$id, $author_id, $product_code, $content, $date]);
    }


    // Функция для обновления комментария
    function updateComments($text, $author_id, $date) {
        $this->updateList(['content' => $text], ['author_id' => $author_id, 'date' => $date]);
    }

}