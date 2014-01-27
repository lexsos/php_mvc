<?php

class ModelCss extends Model{

    function addCssFile( $cssFile ){
        $reg = $this->webApp->register;
        if ( $reg->csss === null )
            $reg->csss = array( $cssFile );
        else{
            $csss = $reg->csss;
            $csss[] = $cssFile;
            $reg->csss = $csss;
        }
    }

    function clearCsss(){
        $reg = $this->webApp->register;
        $reg->csss = array();
    }

    function getCsss(){
        $reg = $this->webApp->register;
        if ( $reg->csss === null )
            return array();
        else
            return $reg->csss;
    }
}

?>
