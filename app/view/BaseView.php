<?php require_once 'app/core/View.php';

class BaseView extends View {

    function __construct() {
        $this->layout = 'base';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}