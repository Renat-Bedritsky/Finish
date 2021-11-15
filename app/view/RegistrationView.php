<?php require_once 'app/core/View.php';

class RegistrationView extends View {

    function __construct() {
        $this->layout = 'registration';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}