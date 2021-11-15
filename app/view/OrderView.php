<?php require_once 'app/core/View.php';

class OrderView extends View {

    function __construct() {
        $this->layout = 'order';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}