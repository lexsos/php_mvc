<?php

/*
    Объект который хранить все переменные состояния приложения (глобальные параметры).
    Реализован паттерн одиночка.
*/

class TWebApp{

    public $config;
    public $register;
    public $route;

    public $view; // Главный вид
    public $model; // Модель для главного вида

    private static $obj;

    private function __construct(){}
    private function __clone(){}
    private function __wakeup(){}

    static function getWebApp(){
        if( is_null(self::$obj)  )
            self::$obj = new self();
        return self::$obj;
    }
}

?>