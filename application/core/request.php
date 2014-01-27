<?php

/*
    Объект запроса.
    Принимает название контроллера, название действия и аргументы для него.
    Позволяет выполеить запрос к контроллеру.
*/

class TRequest{

    private $controller;
    private $action;
    private $args;
    private $controllerObj;

    function TRequest($controller, $action = "", $args = null){

        $this->controller = ($controller === "") ? "Index" : $controller;
        $this->action = ($action === "") ? "action_index" : "action_".$action;
        $this->args = $args;
        $this->controllerObj = null;
    }

    private function createObj(){
        if($this->controllerObj !== null)
            return true;

        $controllerPath = "application/controllers/" . $this->controller . ".php";
        $controllerPath = mb_strtolower($controllerPath);

        if( file_exists($controllerPath) )
            include_once($controllerPath);
        else
            return false;

        $controllerClass = "Controller".$this->controller;
        $this->controllerObj = new $controllerClass;
        if(method_exists($this->controllerObj, $this->action))
            return true;
        else
            return false;
    }

    function execute(){
        if($this->createObj()){
            $obj = $this->controllerObj;
            $method = $this->action;
            $obj->$method( $this->args );
            return true;
        }
        else
            return false;
    }
}

?>