<?php

class Router {

    private $routes;
    public $controller,
        $action,
        $params = [];

    public function __construct() {
        $routesPath = ROOT . '/app/config/routes.php';
        $this->routes = include($routesPath);
    }

    public function run() {
        $uri = $_SERVER['REQUEST_URI'];
        // echo "$uri<br>";

        foreach ($this->routes as $key => $path) {
            if(preg_match("/^\/($key)$/u", $uri)) {
                $str = preg_replace("/^\/($key)$/u", $path, $uri);
                $m = explode('/', $str);
                // echo $str;

                $nameController = array_shift($m).'Controller';
                $this->controller = 'app/controllers/'.$nameController;
                $this->action = 'Action' . array_shift($m);

                if (!empty($m)) {
                    $this->params[] = current($m);
                }
                include "$this->controller.php";

                call_user_func_array([new $nameController, $this->action], $this->params);
                break;
            }
        }

        // echo $this->controller;
        // echo '<br>';
        // echo $this->action;
        // echo '<br>';
        // print_r($this->params);

        if (!$this->action) {
            include 'app/core/Controller.php';
            Controller::set404();
        }
    }
}