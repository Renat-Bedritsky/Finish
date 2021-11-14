<?php require_once 'app/core/Model.php';

class ProductsModel extends Model {

    // Функция для получения товаров одной категории из таблицы (для category.php)
    function getCategory($code) {
        $categoryInfo = $this->categoryInfo($code);

        $category_id = $categoryInfo['id'];

        $sql = "SELECT * FROM products WHERE category_id = $category_id";
        $string = $this->general($sql);
        $result = [];                                                     // Пустой массив для данных

        while ($row = $string->fetch_assoc()) {                           // fetch_assoc() извлекает запись
            array_push($result, $row);                                    // Добавление записи в массив
        }
        $result += ['category_info' => $categoryInfo];
        $result = array_reverse($result);
        return $result;
    }


    // Функция для нахождения категории товара
    function categoryInfo($code) {
        $sql = "SELECT id, name, code, description FROM categories WHERE code = '$code'";
        $string = $this->general($sql);
        $result = $string->fetch_assoc();
        return $result;
    }


    // Функция для нахождения категории товара
    function findCategory($id) {
        $sql = "SELECT code FROM categories WHERE id = $id";
        
        $string = $this->general($sql);
        $result = $string->fetch_assoc();
        
        return $result['code'];
    }


    // Функция для получения записи из таблицы products
    function getProduct($code) {
        $sql = "SELECT id, category_id, author_id, name, code, description, image, price FROM products WHERE code = '$code'";
        $string = $this->general($sql);
        $result = $string->fetch_assoc();

        $author_id = $result['author_id'];
        $sql = "SELECT login FROM users WHERE id = '$author_id'";
        $login = $this->general($sql);
        $author = $login->fetch_assoc();
        $author = $author['login'];
        $result += ['author' => $author];

        $category = $this->findCategory($result['category_id']);
        $result += ['category' => $category];

        unset($result['author_id']);
        unset($result['category_id']);

        return $result;
    }


    // Функция для фильтрации
    function filterProduct($data) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)

        if (isset($data['new']) && $data['new'] == '') {
            $new = date('Y-m-d H:i:s', time()-(7*24*60*60));
        }
        else $new = '2000-01-01 01:01:01';

        if ($data['min'] == '') {
            $min = 0;
        }
        else $min = $data['min'];

        if ($data['max'] == '') {
            $max = 100000000;
        }
        else $max = $data['max'];

        if (isset($data['category'])) {
            $categoryInfo = $this->categoryInfo($data['category']);

            $code = $data['category'];
            $sql = "SELECT id FROM categories WHERE code = '$code'";
            $catedory_obj = $this->general($sql);
            $category_ar = $catedory_obj->fetch_assoc();
            $category_id = $category_ar['id'];

            $sql = "SELECT * FROM products WHERE price >= $min AND price <= $max AND updated_at >= '$new' AND category_id = '$category_id'";
        }
        else $sql = "SELECT * FROM products WHERE price >= $min AND price <= $max AND updated_at >= '$new'";
        
        $string = $this->general($sql);
        $result = [];                                              // Пустой массив для данных

        while ($row = $string->fetch_assoc()) {                    // fetch_assoc() извлекает запись
            array_push($result, $row);                             // Добавление записи в массив
        }

        if (isset($data['category'])) {
            $result += ['category_info' => $categoryInfo];
        }

        return $result;
    }


    // Функция для добавления товара
    function setProduct($data) {
        date_default_timezone_set('Europe/Minsk');   // Назначение временой зоны (Минск)

        $id = $this->getLine('products') + 1;        // Количество строк в таблице + 1
        $category_id = $data['category_id'];         // ID категории
        $author_id = $data['author_id'];             // ID автора
        $name = $data['name'];                       // Наименование товара
        $code = $data['code'];                       // Код товара
        $description = $data['description'];         // Описание товара
        $image = $data['image'];                     // Фото товара
        $price = $data['price'];                     // Цена товара
        $created_at = date("Y-m-d H:i:s");           // Дата создания поста
        $updated_at = date("Y-m-d H:i:s");           // Дата обновления поста

        $sql = "INSERT INTO products VALUES ('$id', '$category_id', '$author_id', '$name', '$code', '$description', '$image', '$price', '$created_at', '$updated_at')";
        $this->general($sql);
    }


    // Функция для удаления товара и коментариев к нему
    function deleteProduct($product_id) {
        $sql = "DELETE FROM comments WHERE product_id = '$product_id'";
        $this->general($sql);

        $sql = "DELETE FROM products WHERE id = '$product_id'";
        $this->general($sql);
    }
}

?>