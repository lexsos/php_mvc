<?php 

class ControllerJs extends TController{

    function action_index( $args ){
        $model = $this->createModel( "Js" );
        $view = new THView( "js", $model );

        TWebApp::getWebApp()->view->addSubView("jsPart", $view);
    }
}

?>