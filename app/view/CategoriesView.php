<?php require_once 'app/core/View.php';

class CategoriesView extends View {

    function __construct() {
        $this->layout = 'categories';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}