<?php

class ControllerDocuments extends TController{

    function action_index( $args ){
        $model = $this->createModel( "Documents", array(new TDb) );
        $view = new THView( "docindex", $model );
        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }

    function action_del( $args ){
        if( count($args) != 1 ){
            p404();
            return;
        }
        if( !isAdmin()){
            p403();
            return;
        }
        $model = $this->createModel( "Documents", array(new TDb) );
        $docId = $args[0];
        $model->delDocument( $docId );
        redirect("documents");
    }

    function action_add( $args ){
        if( count($args) != 0 || !isset($_POST["topic"])  ){
            p404();
            return;
        }
        if( !isAdmin()){
            p403();
            return;
        }

        $model = $this->createModel( "Documents", array(new TDb) );
        $tmpFileName = $_FILES["file"]["tmp_name"];
        $topic = $_POST["topic"];
        $model->addDocument( $tmpFileName, $topic );
        redirect("documents");
    }

    function action_image( $args ){
        if( count($args) != 2 ){
            p404();
            return;
        }
        $docId = $args[0];
        $pageNum = $args[1];
        $model = $this->createModel( "Documents", array(new TDb) );
        $doc = $model->getDocument( $docId );
        if( $doc === null ){
            p404();
            return;
        }
        $imgPage = $doc->getPage( $pageNum );
        if( $imgPage === null ){
            p404();
            return;
        }
        $model->currentData->imgPage = $imgPage;
        $view = new THView( "docimage", $model );
        TWebApp::getWebApp()->view = $view;
    }


    function action_view( $args ){
        if( count($args) != 2 ){
            p404();
            return;
        }
        $docId = $args[0];
        $pageNum = $args[1];
        $model = $this->createModel( "Documents", array(new TDb) );
        $doc = $model->getDocument( $docId );
        if( $doc === null){
            p404();
            return;
        }
        $model->currentData->doc = $doc;
        $model->currentData->pageNum = $pageNum;
        $view = new THView( "docview", $model );
        TWebApp::getWebApp()->view = $view;

    }
}

?>