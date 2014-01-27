<?php 

class ControllerTest extends TController{

    function action_index( $args ){
    }

    function action_test( $args ){
        $model = $this->createModel( "Test", "additional text" );
        $view = new THView( "test", $model );

        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }

}

?>