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


    // Функция для удаления коментариев к товару
    function DeleteComments($product_code) {
        $sql = "DELETE FROM $this->tablename WHERE product_code = '$product_code'";
        $this->general($sql);
    }


    // Функция для удаления  коментария товару
    function DeleteComment($date) {
        $sql = "DELETE FROM $this->tablename WHERE date = '$date'";
        $this->general($sql);
    }

    // Функция для получения коментариев и информации о их создателях
    function GetComments($product_code) {
        $data = $this->getList([], ['product_code' => $product_code]);
        if (isset($data)) return $data;
        else return 0;
    }


    // Функция для добавления коментариев
    function AddComments($data) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)

        $id = $this->getLine() + 1;
        $author_id = $data['author_id'];
        $product_code = $data['product_code'];
        $content = $data['content'];
        $date = date("Y-m-d H:i:s");

        $sql = "INSERT INTO $this->tablename VALUES ('$id', '$author_id', '$product_code', '$content', '$date')";
        $this->general($sql);
    }


    // Функция для обновления комментария
    function updateComments($text, $author_id, $date) {
        $sql = "UPDATE $this->tablename SET content = '$text' WHERE author_id = '$author_id' AND date = '$date'";
        $this->general($sql);
    }

}