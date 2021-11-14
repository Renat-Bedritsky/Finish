<?php require_once 'app/core/Model.php';
require_once 'app/models/Products.php'; // to do

$products = new ProductsModel(); // to do

class UsersModel extends Model {

    // Функция для получения всех логинов
    function allUser() {
        $sql = "SELECT `login` FROM `users`";
        $allLogin = $this->general($sql);
        $result = [];                                                       // Пустой массив для логинов

        while ($row = $allLogin->fetch_assoc()) {                           // fetch_assoc() извлекает запись
            array_push($result, $row['login']);                             // Добавление записи в массив
        }
        return $result;
    }


    // Функция для определения id по логину
    function getId($login) {
        $sql = "SELECT id FROM `users` WHERE login = '$login'";
        $string = $this->general($sql);
        $result = $string->fetch_assoc();
        return $result['id'];
    }


    // Функция для получения информации о пользователе
    function getUser($login) {
        $id = $this->getId($login);

        $sql = "SELECT * FROM users WHERE id = $id";
        $string = $this->general($sql);
        $result = $string->fetch_assoc();
        
        $sql = "SELECT * FROM products WHERE author_id = $id";
        $productsUser = $this->general($sql);
        $products = [];

        while ($row = $productsUser->fetch_assoc()) {
            array_push($products, $row);
        }
        $result += ['products' => $products];
        
        $sql = "SELECT * FROM comments WHERE author_id = $id";
        $commentsUser = $this->general($sql);
        $comments = [];

        while ($row = $commentsUser->fetch_assoc()) {
            array_push($comments, $row);
        }
        $result += ['comments' => $comments];

        return $result;
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


    // Функция для получения всех логинов и паролей (для авторизации)
    protected function allLoginAndPass() {
        $sql = "SELECT id, login, password, position FROM users";
        $allLoginAndPass = $this->general($sql);
        $result = [];

        while ($row = $allLoginAndPass->fetch_assoc()) {
            array_push($result, $row);
        }
        return $result;
    }


    // Функция для получения логинов и статусов пользователей (для смены статуса в control.php)
    function getLoginAndPosition() {
        $sql = 'SELECT login, position FROM users';
        $string = $this->general($sql);
        $result = [];

        $access = $this->CheckCookieLogin();

        while ($row = $string->fetch_assoc()) {
            if ($row['position'] == 'administrator') continue;
            if ($row['position'] == 'moderator' && $access['position'] == 'moderator') continue;
            array_push($result, $row);
        }
        return $result;
    }


    // Функция для проверки логина и пароля (для авторизации)
    function autorization($login, $password) {
        $listUsers = $this->allLoginAndPass();

        foreach($listUsers as $user) {
            if ($login == $user['login'] && $password == $user['password']) {
                return 'autorizationYES';
            }
        }
    }


    // Функция для проверки существования логина (для регистрации)
    function checkLogin($login) {
        $allUsers = $this->allUser();

        foreach ($allUsers as $user) {
            if ($user == $login) {
                return 'User exist';
            }
        }
        return 'User not exist';
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
    }

    
    // Функция для добавления пользователя
    function registrationUser($login, $password, $image = 0) {

        $countUser = $this->getLine('users');        // Количество строк в таблице

        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)

        $id = $countUser + 1;
        $date = date("Y-m-d H:i:s");

        if($image == 0) {
            $foto = '/articles/img/site-images/start-foto.png';
        }

        $basket = '[]';
        $position = 'user';

        $sql = "INSERT INTO users VALUES ('$id', '$login', '$password', '$foto', '$basket', '$position', '$date')";
        $this->general($sql);
    }


    // Функция для страницы basket.php
    function forBasket() {
        $basket = $this->getBasket();

        $sql = 'SELECT code FROM products';
        $codes = $this->general($sql);
        $result = [];
        while ($row = $codes->fetch_assoc()) {
            array_push($result, $row['code']);
        }
        foreach ($basket as $key => $value) {
            $lock = 0;
            foreach ($result as $code) {
                if ($code == $key) {
                    $lock = 1;
                    break;
                }
            }
            if ($lock == 0) {
                unset($basket[$key]);
                for ($i = 1; $i <= $value; $i++) {
                    $this->minusBasket($key);
                }
            }
        }

        global $products;
        $array = [];
        foreach ($basket as $code => $count) {
            $product = $products->getProduct($code);
            $product += ['count' => $count];
            array_push($array, $product);
        }
        return $array;
    }


    // Функция для получения данных корзины
    function getBasket() {
        $userData = $this->CheckCookieLogin();
        $id = $userData['author_id'];

        $getBasket = "SELECT basket FROM users WHERE id = $id";      // Текст запроса
        $basket = $this->general($getBasket);                        // Отправка запроса
        $recording = $basket->fetch_assoc();                         // Извлечение записи
        $mass = json_decode($recording['basket']);                   // Декодировка
        $mass = (array)$mass;                                        // Преобразование в массив

        return $mass;
    }


    // Функция для добавления товара в корзину
    function plusBasket($code) {
        $userData = $this->CheckCookieLogin();
        $id = $userData['author_id'];

        $array = $this->getBasket();

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

        $json = json_encode($array);                                 // Кодировка
        $sql = "UPDATE users SET basket = '$json' WHERE id = $id";   // Текст запроса
        $this->general($sql);                                        // Отправка запроса
    }


    // Функция для удаления товара из корзины
    function minusBasket($code) {
        $userData = $this->CheckCookieLogin();
        $id = $userData['author_id'];
        
        $array = $this->getBasket();

        $array[$code] -= 1;

        if ($array[$code] == 0) {
            unset($array[$code]);
        }

        $json = json_encode($array);                                 // Кодировка
        $sql = "UPDATE users SET basket = '$json' WHERE id = $id";   // Текст запроса
        $this->general($sql);                                        // Отправка запроса
    }


    // Функция для обновления фото профиля
    function updateFoto($link) {
        $userData = $this->CheckCookieLogin();
        $id = $userData['author_id'];
        
        $sql = "UPDATE users SET foto = '$link' WHERE id = $id";     // Текст запроса
        $this->general($sql);                                        // Отправка запроса
    }


    // Функция для обновления доступа
    function updatePosition($login, $position) {
        $sql = "UPDATE users SET position = '$position' WHERE login = '$login'";
        $this->general($sql);
    }
}