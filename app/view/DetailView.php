<?php require_once 'app/core/View.php';

class DetailView extends View {

    function __construct() {
        $this->layout = 'detail';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}