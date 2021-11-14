<?php require_once 'app/core/Model.php';

class CategoriesModel extends Model {

    function __construct() {
        parent::__construct();
        $this->tablename = 'categories';
    }


    // Функция для нахождения категории товара
    function GetInfo() {
        $result = $this->getList(['id, name, code, description, image']);
        return $result;
    }

    function GetNameCategory($code) {
        $result = $this->getList(['name'], ['code' => $code]);
        return $result[0]['name'];
    }

    function GetOneInfo($code) {
        $result = $this->getList(['id, name, code, description, image'], ['code' => $code]);
        return $result[0];
    }

}