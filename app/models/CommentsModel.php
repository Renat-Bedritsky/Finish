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

}