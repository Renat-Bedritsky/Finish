<?php require_once 'app/core/Model.php';

class UsersModel extends Model {

    function __construct() {
        parent::__construct();
        $this->tablename = 'users';
    }


    // Функция для получения всех логинов и паролей (для авторизации)
    protected function allLoginAndPass() {
        return $this->getList(['id, login, password, position']);
    }


    // Функция для сверки COOKIE с существующими пользователями
    function CheckCookieLogin() {
        $listUsers = $this->allLoginAndPass();

        foreach($listUsers as $user) {
            if (isset($_COOKIE['login']) && $_COOKIE['login'] == md5($user['login'].$user['password'])) {
                $access = 'allowed';
                $userData = ['author_id' => $user['id'], 'login' => $user['login'], 'access' => $access, 'position' => $user['position']];
                return $userData;
            }
            else return '0';
        }
    }


    // Функция для получения данных корзины
    function GetBasket($id) {
        $basket = $this->getList(['basket'], ['id' => $id]);
        $mass = json_decode($basket[0]['basket']);   // Декодировка
        $result = (array)$mass;
        return $result;
    }


    // Функция для добавления товара в корзину
    function PlusBasket($array, $code, $user_id) {
        if (array_key_exists($code, $array)) {                       // Если товар есть в корзине
            $array[$code] += 1;
        }
        else {                                                       // Если товара нет в корзине
            if (array_key_exists(0, $array)) {
                unset($array[0]);
            }
            $count = 1;
            $array += [$code => $count];
        }
        $json = json_encode($array);                                      // Кодировка
        $sql = "UPDATE users SET basket = '$json' WHERE id = $user_id";   // Текст запроса
        $this->general($sql);                                             // Отправка запроса
    }


    // Функция для удаления товара из корзины
    function MinusBasket($array, $code, $user_id) {
        $array[$code] -= 1;
        if ($array[$code] == 0) {
            unset($array[$code]);
        }
        $json = json_encode($array);                                      // Кодировка
        $sql = "UPDATE users SET basket = '$json' WHERE id = $user_id";   // Текст запроса
        $this->general($sql);                                             // Отправка запроса
    }


    // Функция для получения информации о пользователе
    function GetUserInfo($login) {
        return $this->getList(['id, login, foto, basket, position, date'], ['login' => $login]);
    }


    // Функция для поиска пользователя
    function searchUser($login) {
        $sql = "SELECT login FROM users WHERE login LIKE '$login%'";
        $user = $this->general($sql);
        $result = [];
        while ($row = $user->fetch_assoc()) {
            array_push($result, $row['login']);
        }
        return $result;
    }

}