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
            $sql = "SELECT id, category_code, author_id, name, code, description, image, price FROM $this->tablename WHERE price >= $min AND price <= $max AND updated_at >= '$new' AND category_code = '$category_code'";
        }
        else $sql = "SELECT id, category_code, author_id, name, code, description, image, price FROM $this->tablename WHERE price >= $min AND price <= $max AND updated_at >= '$new'";
        
        $string = $this->general($sql);

        $page = $data['page'];
        $finalProductInPage = $page * ONPAGE;
        $countProducts = 0;
        $result = ['products' => []];

        $array = [];
        while ($product = $string->fetch_assoc()) {
            array_push($array, $product);
        }
        $array = array_reverse($array);

        foreach ($array as  $path) {
            $countProducts += 1;
            if($countProducts > ($finalProductInPage - ONPAGE) && $countProducts <= $finalProductInPage) {
                array_push($result['products'], $path);
            }
        }

        $countPage = ceil($countProducts / ONPAGE);
        $result += ['page' => $countPage];

        return $result;
    }


    // Функция для страницы basket
    function ProductsForBasket($array) {
        $products = [];
        $basket = [];
        $total = 0;
        foreach ($array as $code => $count) {
            $product = $this->getList(['id, category_code, author_id, name, code, description, image, price'], ['code' => $code]);
            if(empty($product)) $product = ['price' => 0];
            else $product = $product[0];
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


    // Функция для удаления товара
    function DeleteProduct($product_code) {
        $this->deleteList(['code' => $product_code]);
    }


    // Функция для получения одного продукта
    function GetProduct($code) {
        return $this->getList(['id, category_code, author_id, name, code, description, image, price'], ['code' => $code]);
    }
    

    // Сумма цены корзины
    function GetTotalPrice($basket) {
        $total = 0;
        foreach ($basket as $key => $path) {
            $price = $this->getList(['price'], ['code' => $key]);
            if(!isset($price[0])) continue;
            $sum = $price[0]['price'] * $path;
            $total += $sum;
        }
        return $total;
    }


    // Функция для добавления товара
    function SetProduct($data) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)
        $line = $this->getLine();

        $id = $line + 1;                             // Количество строк в таблице + 1
        $category_code = $data['category_code'];     // ID категории
        $author_id = $data['author_id'];             // ID автора
        $name = $data['name'];                       // Наименование товара
        $code = $data['code'];                       // Код товара
        $description = $data['description'];         // Описание товара
        $image = $data['image'];                     // Фото товара
        $price = $data['price'];                     // Цена товара
        $created_at = date("Y-m-d H:i:s");           // Дата создания поста
        $updated_at = date("Y-m-d H:i:s");           // Дата обновления поста

        $this->insertList([$id, $category_code, $author_id, $name, $code, $description, $image, $price, $created_at, $updated_at]);
    }


    // Информация для orders
    function ForOrders($data) {
        foreach ($data['new_orders'] as $key => $order) {
            $total = 0;
            foreach ($order['products'] as $product => $count) {
                $ar = $this->getList(['name, price'], ['code' => $product]);
                $total += $ar[0]['price'] * $count;
                $ar[0] += ['count' => $count];
                $data['new_orders'][$key]['products'][$product] = $ar[0];
            }
            $data['new_orders'][$key] += ['total' => $total];
        }
        foreach ($data['done_orders'] as $key => $order) {
            $total = 0;
            foreach ($order['products'] as $product => $count) {
                $ar = $this->getList(['name, price'], ['code' => $product]);
                $total += $ar[0]['price'] * $count;
                $ar[0] += ['count' => $count];
                $data['done_orders'][$key]['products'][$product] = $ar[0];
            }
            $data['done_orders'][$key] += ['total' => $total];
        }
        return $data;
    }


}