<?php 

class ControllerCss extends TController{

    function action_index( $args ){
        $model = $this->createModel( "Css" );
        $view = new THView( "css", $model );

        TWebApp::getWebApp()->view->addSubView("cssPart", $view);
    }
}

?>