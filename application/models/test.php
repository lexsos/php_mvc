<?php

class ModelTest extends Model{

    private $text;

    function getData(){
        return "Test data from model";
    }

    function ModelTest( $arg ){
        parent::__construct();
        $this->text = $arg;
    }
}

?>