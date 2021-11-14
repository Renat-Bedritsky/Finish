<?php require_once 'app/core/View.php';

class BasketView extends View {

    function __construct() {
        $this->layout = 'basket';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}