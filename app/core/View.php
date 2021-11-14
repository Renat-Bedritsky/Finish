<?php

class View {
    const VIEW_PATH = ROOT.'/app/visual/';
    public $template, $layout;

    public function __construct($template = 'default', $layout = '404') {
        $this->template = $template;
        $this->file = self::VIEW_PATH.'layouts/'.$layout.'.php';
    }

    function setLayout() {
        if(file_exists($this->file)){
            include_once $this->file;
        }
        
    }

    public function show() {
        include_once self::VIEW_PATH.'template/'.$this->template.'/header.php';
        $this->setLayout();
        include_once self::VIEW_PATH.'template/'.$this->template.'/footer.php';
    }
}