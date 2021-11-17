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
        }
        return '0';
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
        $this->updateList(['basket' => $json], ['id' => $user_id]);
    }


    // Функция для удаления товара из корзины
    function MinusBasket($array, $code, $user_id) {
        $array[$code] -= 1;
        if ($array[$code] == 0) {
            unset($array[$code]);
        }
        $json = json_encode($array);                                      // Кодировка
        $this->updateList(['basket' => $json], ['id' => $user_id]);
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


    // Функция для обновления фото профиля
    function UpdateFoto($image, $id) {
        $this->updateList(['foto' => $image], ['id' => $id]);
    }


    // Получить логин по id
    function GetLogin($id) {
        $result = $this->getList(['login'], ['id' => $id]);
        return $result[0]['login'];
    }


    // Для страницы detail
    function GetUsers($data) {
        foreach ($data as $key => $path) {
            $id = $path['author_id'];
            $user = $this->getList(['id, login, foto, position'], ['id' => $id]);

            $link = $_SERVER['DOCUMENT_ROOT'].'/public/images/foto_profiles/'.$user[0]['foto'];
            if (!file_exists($link) || $user[0]['foto'] == '') {
                $user[0]['foto'] = '../site-images/start-foto.png';
            }

            $data[$key] += ['user' => $user[0]];
        }
        return $data;
    }


    // Функция для получения логинов и статусов пользователей (для смены статуса в control)
    function GetLoginAndPosition($access) {
        $data = $this->getList(['login, position']);
        $result = [];
        foreach ($data as $key => $path) {
            if ($path['position'] == 'administrator') continue;
            if ($path['position'] == 'moderator' && $access == 'moderator') continue;
            if ($path['position'] == 'operator' && $access == 'moderator') continue;
            array_push($result, $data[$key]);
        }
        return $result;  
    }


    // Функция для обновления доступа
    function UpdatePosition($login, $position) {
        $this->updateList(['position' => $position], ['login' => $login]);
    }


    // Функция для проверки логина и пароля (для авторизации)
    function Autorization($login, $password) {
        $listUsers = $this->allLoginAndPass();
        foreach($listUsers as $user) {
            if ($login == $user['login'] && $password == $user['password']) {
                return 'autorizationYES';
            }
        }
    }


    // Функция для проверки существования логина (для регистрации)
    function checkLogin($login) {
        $allUsers = $this->getList(['login']);
        foreach ($allUsers as $user) {
            if ($user['login'] == $login) {
                return 'User exist';
            }
        }
        return 'User not exist';
    }

    
    // Функция для добавления пользователя
    function RegistrationUser($login, $password) {
        $count = $this->getLine();
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)

        $id = $count + 1;
        $date = date("Y-m-d H:i:s");
        $foto = 'start-foto.png';
        $basket = '[]';
        $position = 'user';

        $this->insertList([$id, $login, $password, $foto, $basket, $position, $date]);
    }


    // Получить корзину в json
    function GetJson($id) {
        $result = $this->getList(['basket'], ['id' => $id]);
        return $result[0]['basket'];
    }


    // Обновить корзину
    function UpdateBasket($basket, $login) {
        $array = [];
        foreach ($basket as $path) {
            $array += [$path['code'] => $path['count']];

        }
        $new = json_encode($array);
        $this->updateList(['basket' => $new], ['login' => $login]);
    }


    // Очистить корзину
    function DeleteBasket($id) {
        $this->updateList(['basket' => '[]'], ['id' => $id]);
    }

}