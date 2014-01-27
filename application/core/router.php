<?php

/*
    Объект который принимает маршрут выда:
    controllerName/actionName/arg1/arg2/...
    И возвращает объект запроса.
*/

class TRouter{

    private $request;

    private function makeRequest( $routeElements ){

        $elementCount = count($routeElements);
        $controller = "";
        $action = "";
        $args = null;

        if($elementCount >= 1)
            $controller = $routeElements[0];
        if($elementCount >= 2)
            $action = $routeElements[1];
        if($elementCount >= 3)
            $args = array_slice($routeElements, 2);

        // Убираем лишний аргумент из маршрутов вида: controllerName/actionName/
        if( $elementCount==3 && $routeElements[2]==="" )
            $args = null;

        $this->request = new TRequest($controller, $action, $args);
    }

    function TRouter( $route ) {

        $this->makeRequest( explode('/', $route) );
    }

    function getRequest(){
        return $this->request;
    }
}

?>