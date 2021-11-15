<?php require_once 'app/core/View.php';

class AutorizationView extends View {

    function __construct() {
        $this->layout = 'autorization';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}