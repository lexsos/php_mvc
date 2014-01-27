<?php

class ModelJs extends Model{

    function addJsFile( $jsFile ){
        $reg = $this->webApp->register;
        if ( $reg->jss === null )
            $reg->jss = array( $jsFile );
        else{
            $jss = $reg->jss;
            $jss[] = $jsFile;
            $reg->jss = $jss;
        }
    }

    function clearJss(){
        $reg = $this->webApp->register;
        $reg->jss = array();
    }

    function getJss(){
        $reg = $this->webApp->register;
        if ( $reg->jss === null )
            return array();
        else 
            return $reg->jss;
    }
}

?>
