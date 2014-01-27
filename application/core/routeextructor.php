<?php

/*
    Интерфейс объекта который возвращает маршрут вида:
    controllerName/actionName/arg1/arg2/...
*/

interface IRouteExtructor {

    public function getRoute();
}

/*
    Объект который извлекает маршрут из URI вида:
    basePath/controllerName/actionName/arg1/arg2/...
    или null при ошибке
*/

class TCPUExtructor implements IRouteExtructor {

    private $basePath;

    function TCPUExtructor( $basePath ){
        $this->basePath = $basePath;
    }

    function getRoute(){

        $fullRoute = $_SERVER['REQUEST_URI'];
        $baseLen =  mb_strlen($this->basePath);

        if( mb_substr($fullRoute, 0, $baseLen) === $this->basePath )
             return mb_substr($fullRoute, $baseLen);
        else
            return null;
    }
}

?>
