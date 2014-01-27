<?php

class ControllerSupport extends TController{

    private function needAuth(){
        $model = $this->createModel( "Support", array(new TDb) );
        $view = new THView( "supneedauth", $model );
        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }

    function action_index( $args ){
        if( !isAuth() ){
            $this->needAuth();
            return;
        }
        $model = $this->createModel( "Support", array(new TDb) );

        $view = new THView( "supmain", $model );
        TWebApp::getWebApp()->view->addSubView("mainPart", $view);

        $view = new THView( "supmytickets", $model );
        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }

    function action_ticket( $args ){
        if( count($args) != 1 ){
            p404();
            return;
        }
        if( !isAuth() ){
            $this->needAuth();
            return;
        }
        $model = $this->createModel( "Support", array(new TDb) );
        $ticket = $model->getTicketById( $args[0] );
        $userId = TWebApp::getWebApp()->register->dbUser->id;

        if ( !isAdmin() && $ticket->creator_id !== $userId ){
            p403();
            return;
        }
        $model->currentData->ticket = $ticket;
        $view = new THView( "supticket", $model );
        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }

    function action_addmsg( $args ){
        if( count($args) != 1 ){
            p404();
            return;
        }
        if( !isAuth() ){
            $this->needAuth();
            return;
        }
        $ticketId = $args[0];
        $userId = TWebApp::getWebApp()->register->dbUser->id;
        $model = $this->createModel( "Support", array(new TDb) );
        $ticket = $model->getTicketById( $ticketId );

        if ( !isAdmin() && $ticket->creator_id !== $userId ){
            p403();
            return;
        }

        $smsg = new TSupMsg();
        $smsg->ticket_id = $ticketId;
        $smsg->creator_id = $userId;
        $smsg->content = $_POST["content"];
        $model->addMsg( $smsg );

        redirect("support/ticket/".$ticketId);
    }

    function action_addticket( $args ){
        if( count($args) != 0 ){
            p404();
            return;
        }
        if( !isAuth() ){
            $this->needAuth();
            return;
        }

        $userId = TWebApp::getWebApp()->register->dbUser->id;
        $model = $this->createModel( "Support", array(new TDb) );
        if( isset($_POST["content"]) ){
            $ticket = new TSupTicket;
            $ticket->topic = $_POST["topic"];
            $ticket->creator_id = $userId;
            $ticketId = $model->addTicket($ticket);

            $smsg = new TSupMsg();
            $smsg->ticket_id = $ticketId;
            $smsg->creator_id = $userId;
            $smsg->content = $_POST["content"];
            $model->addMsg( $smsg );

            redirect("support/ticket/".$ticketId);
        }
        else{
            $view = new THView( "supaddticket", $model );
            TWebApp::getWebApp()->view->addSubView("mainPart", $view);
        }
    }
}

?>
