<?php require_once 'app/core/View.php';

class AddView extends View {

    function __construct() {
        $this->layout = 'add';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}