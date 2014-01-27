<?php 

class ControllerNews extends TController{

    function action_index( $args ){
        $this->action_newslist( $args );
    }

    function action_topics( $args ){
        $model = $this->createModel( "News", array(new TDb) );
        $view = new THView( "newstopics", $model );

        TWebApp::getWebApp()->view->addSubView("rightPart", $view);
    }

    function action_newsread( $args ){
        $model = $this->createModel( "News", array(new TDb) );
        $view = new THView( "newsread", $model );

        if( count($args) != 1 ){
            p404();
            return;
        }

        $model->currentData->news = $model->getNews( $args[0] );

        if( $model->currentData->news === null ){
            p404();
            return;
        }

        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }

    function action_newslist( $args ){

        if( count($args) != 0 ){
            p404();
            return;
        }

        $model = $this->createModel( "News", array(new TDb) );
        $view = new THView( "newslist", $model );

        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }

    function action_newsadd( $args ){

        if( !checkAdminRole() )
            return;

        $model = $this->createModel( "News", array(new TDb) );

        if( !isset($_POST["topic"]) ){
            $view = new THView( "newsedit", $model );
            TWebApp::getWebApp()->view->addSubView("mainPart", $view);
        }
        else{
            $news = new TNews();
            $news->topic = $_POST["topic"];
            $news->content = $_POST["content"];
            $model->addNews( $news );

            redirect("news/newslist");
        }
    }

    function action_newsdel( $args ){

        if( !checkAdminRole() )
            return;

        $model = $this->createModel( "News", array(new TDb) );
        $model->delNews( $args[0] );
        redirect("news/newslist");
    }
}

?>