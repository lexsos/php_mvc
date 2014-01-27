<?php

/*
    Интерфейс объетка вид.
*/

interface IHView{

    public function render();
    public function addSubView( $place, IHView $subView );
    public function clearPlace( $place );
    public function renderPlace( $place );
}

/*
    Класс иерархического представления.
    Резализован паттерн компоновщик.
*/

class THView implements IHView {

    private $tmpl;
    private $subViews;
    private $model;

    function THView( $template, $model ){
        $this->tmpl = $template;
        $this->subViews = array();
        $this->model = $model;
    }

    function render(){
        include( "application/views/".$this->tmpl.".php" );
    }

    function addSubView( $place, IHView $subView ){
        $this->subViews[$place][] = $subView;
    }

    function clearPlace( $place ){
        $this->subViews[$place] = array();
    }

    function renderPlace( $place ){

        if ( !array_key_exists($place, $this->subViews) )
            return;
        foreach( $this->subViews[$place] as $view )
            $view->render();
    }


    function getResPath($type, $res){
        $conf = $this->model->webApp->config;
        return $conf->basePath . $type . "/" . $res;
    }

    function getImg( $img ){
        return $this->getResPath("images", $img);
    }

    function getCss( $css ){
        return $this->getResPath("css", $css);
    }

    function getJs( $js ){
        return $this->getResPath("js", $js);
    }

    function getReq( $route ){
        $conf = $this->model->webApp->config;
        return $conf->basePath . $route;
    }


    function outText( $text ){
        $charset = TWebApp::getWebApp()->config->charset;
        echo htmlentities( $text , ENT_QUOTES, $charset );
    }
}

?>