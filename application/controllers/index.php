<?php 

class ControllerIndex{

    function action_index( $args ){
        $model = new Model();
        $view = new THView( "index", $model );
        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }
}

?>