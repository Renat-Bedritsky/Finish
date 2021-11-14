<?php require_once 'app/core/Model.php';

class ProductsModel extends Model {

    function __construct() {
        parent::__construct();
        $this->tablename = 'products';
    }

    // Функция для получения товаров одной категории из таблицы (для category.php)
    function GetOneCategory($code) {
        $result = $this->getList(['id, category_code, author_id, name, code, description, image, price'], ['category_code' => $code]);
        return $result;
    }


    // Функция для фильтрации
    function FilterProduct($data) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)

        if (isset($data['new']) && $data['new'] == 'yes') $new = date('Y-m-d H:i:s', time()-(7*24*60*60));
        else $new = '2000-01-01 01:01:01';

        if (!isset($data['min']) || $data['min'] == '') $min = 0;
        else $min = $data['min'];

        if (!isset($data['max']) || $data['max'] == '') $max = 100000000;
        else $max = $data['max'];

        if (isset($data['category'])) {
            $category_code = $data['category'];
            $sql = "SELECT id, category_code, author_id, name, code, description, image, price FROM products WHERE price >= $min AND price <= $max AND updated_at >= '$new' AND category_code = '$category_code'";
        }
        else $sql = "SELECT id, category_code, author_id, name, code, description, image, price FROM products WHERE price >= $min AND price <= $max AND updated_at >= '$new'";
        
        $string = $this->general($sql);

        $page = $data['page'];
        $finalProductInPage = $page * ONPAGE;
        $countProducts = 0;
        $result = ['products' => []];

        while ($product = $string->fetch_assoc()) {
            $countProducts += 1;
            if($countProducts > ($finalProductInPage - ONPAGE) && $countProducts <= $finalProductInPage) {
                array_push($result['products'], $product);
            }
        }

        $countPage = ceil($countProducts / ONPAGE);
        $result += ['page' => $countPage];

        return $result;
    }


    // Функция для страницы basket.php
    function ProductsForBasket($array) {
        $products = [];
        $basket = [];
        $total = 0;
        foreach ($array as $code => $count) {
            $product = $this->getList(['id, category_code, author_id, name, code, description, image, price'], ['code' => $code]);
            $product = $product[0];
            $product += ['count' => $count];
            array_push($products, $product);
            $total += $product['price'] * $count;
        }
        $basket += ['products' => $products];
        $basket += ['total' => $total];
        return $basket;
    }


    // Продукты одного автора
    function ProductsOneAuthor($id) {
        return $this->getList(['id, name, code'], ['author_id' => $id]);
    }

}