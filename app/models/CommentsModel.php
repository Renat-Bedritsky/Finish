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
    

    // Доступ к удалению комментария
    function ResolutionDelete($focusUser, $cookieUser) {
        if (
            ($focusUser['position'] == 'moderator' && ($cookieUser['position'] == 'moderator' || $cookieUser['position'] == 'user')) && 
            ($focusUser['id'] != $cookieUser['author_id']) || 
            ($focusUser['position'] == 'administrator' && ($cookieUser['position'] == 'moderator' || $cookieUser['position'] == 'user')) || 
            ($cookieUser['position'] == 'user' && $focusUser['id'] != $cookieUser['author_id'])
            ) {
            return 'NO';
        }
        else if ($cookieUser['access'] == 'allowed' || $cookieUser['position'] == 'administrator' || $cookieUser['position'] == 'moderator') {
            return 'YES';
        }
    }


    // Функция для удаления коментариев к товару
    function DeleteComments($product_code) {
        $sql = "DELETE FROM comments WHERE product_code = '$product_code'";
        $this->general($sql);
    }


    // Функция для удаления  коментария товару
    function DeleteComment($date) {
        $sql = "DELETE FROM comments WHERE date = '$date'";
        $this->general($sql);
    }

    // Функция для получения коментариев и информации о их создателях
    function GetComments($product_code) {
        $data = $this->getList([], ['product_code' => $product_code]);
        if (isset($data)) return $data;
        else return 0;
    }

}