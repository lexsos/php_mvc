<?php

class ModelRedirect extends Model{

    private $path;

    function redirectTo(){
        return $this->path;
    }

    function ModelRedirect( $arg ){
        parent::__construct();
        $this->path = $arg[0];
    }
}

?>