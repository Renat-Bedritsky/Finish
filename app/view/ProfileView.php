<?php require_once 'app/core/View.php';

class ProfileView extends View {

    function __construct() {
        $this->layout = 'profile';
        parent::__construct($this->template = 'default' ,$this->layout);
    }
}