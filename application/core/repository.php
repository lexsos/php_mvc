<?php

/*
    Объект - рипозиторий.
    Позволяет хранить пары ключ/значение.
*/

class TRepository{

    private $params;

    function TRepository( $params = array() ){
        $this->params = $params;
    }

    function getParam( $paramName ){
        if( array_key_exists($paramName, $this->params) )
            return $this->params[$paramName];
        return null;
    }
    function setParam( $paramName, $value ){
        $this->params[$paramName] = $value;
    }
    function __get( $paramName ){

        return $this->getParam( $paramName );
    }
    function __set( $paramName, $value ){
        $this->setParam( $paramName, $value );
    }
}

?>