<?php require_once 'app/core/View.php';

class CategoryView extends View {

    function __construct() {
        $this->layout = 'category';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}