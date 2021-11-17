<?php require_once 'app/core/View.php';

class OrdersView extends View {

    function __construct() {
        $this->layout = 'orders';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}