<?php require_once 'app/core/View.php';

class ControlView extends View {

    function __construct() {
        $this->layout = 'control';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}