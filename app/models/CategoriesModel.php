<?php require_once 'app/core/Model.php';

class CategoriesModel extends Model {

    function __construct() {
        parent::__construct();
        $this->tablename = 'categories';
    }

    function GetInfo() {
        return $this->getList(['id, name, code, description, image']);
    }

    function GetNameCategories() {
        return $this->getList(['name, code']);
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