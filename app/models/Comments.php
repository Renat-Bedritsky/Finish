<?php require_once 'app/core/Model.php';
require_once 'database/Users.php'; // to do

$users = new UsersModel(); //to do

class CommentsModel extends Model {

    // Функция для получения коментариев и информации о их создателях
    function getComments($product_id) {
        $sql = "SELECT * FROM comments WHERE product_id = $product_id";
        
        $string = $this->general($sql);
        $result = [];

        if($string) {
            while ($row = $string->fetch_assoc()) {

                $author_id = $row['author_id'];
                $sql = "SELECT id, login, foto, position FROM users WHERE id = $author_id";
                $user = $this->general($sql);
                $arr = $user->fetch_assoc();
                $row += ['user' => $arr];

                array_push($result, $row);
            }
            return $result;
        }
        else return 'Error';
    }


    // Функция для добавления коментариев
    function addComments($data) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)

        $countStr = $this->getLine('comments');

        $id = $countStr + 1;
        $author_id = $data['author_id'];
        $product_id = $data['product_id'];
        $content = $data['content'];
        $date = date("Y-m-d H:i:s");

        $sql = "INSERT INTO comments VALUES ('$id', '$author_id', '$product_id', '$content', '$date')";
        
        $this->general($sql);
    }


    // Функция для обновления комментария
    function updateComments($text, $author_id, $date) {
        $sql = "UPDATE comments SET content = '$text' WHERE author_id = '$author_id' AND date = '$date'";
        $this->general($sql);
    }


    // Функция для удаления коментариев
    function deleteComments($date) {
        $sql = "DELETE FROM comments WHERE date = '$date'";
        $this->general($sql);
    }


    // Функция для нахождения комментариев пользователя
    function findComment($author_id) {
        $sql = "SELECT content FROM comments WHERE author_id = $author_id";
        
        $string = $this->general($sql);
        $result = $string->fetch_assoc();
        
        return $result['content'];
    }

    // Доступ к удалению комментария
    function resolutionDelete($login) {
        global $users;

        $focusUser = $users->getUser($login);
        $cookieUser = $users->CheckCookieLogin();
        $position = $cookieUser['position'];

        if (
            ($focusUser['position'] == 'moderator' && ($cookieUser['position'] == 'moderator' || $cookieUser['position'] == 'user')) && 
            ($focusUser['id'] != $cookieUser['author_id']) || 
            ($focusUser['position'] == 'administrator' && ($cookieUser['position'] == 'moderator' || $cookieUser['position'] == 'user')) || 
            ($cookieUser['position'] == 'user' && $focusUser['id'] != $cookieUser['author_id'])
            ) {
            return 'NO';
        }
        else if ($cookieUser['access'] == 'allowed' || $position == 'administrator' || $position == 'moderator') {
            return 'YES';
        }
    }
}