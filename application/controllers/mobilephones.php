<?php

class ControllerMobilePhones extends TController{

    function action_index( $args ){
    }

    // Телефоны
    function action_addphone( $args ){
        if( !checkAdminRole() )
            return;

        $model = $this->createModel( "MobilePhones", array(new TDb) );

        if( !isset($_POST["number"]) ){
            $modelUsers = $this->createModel( "Users", array(new TDb) );
            $model->currentData->usersList = $modelUsers->getAllUsers();
            $view = new THView( "mobpaddphone", $model );
            TWebApp::getWebApp()->view->addSubView("mainPart", $view);
        }
        else{
            $phone = new TMobilePhone();
            $phone->number = $_POST["number"];
            $phone->description = $_POST["description"];
            $phone->owner_id = $_POST["owner_id"];
            $model->addPhone( $phone );
            redirect("mobilephones/listphones");
        }
    }
    function action_listphones( $args ){
        if( !checkAdminRole() )
            return;
        $model = $this->createModel( "MobilePhones", array(new TDb) );
        $view = new THView( "mobplistphones", $model );
        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }
    function action_delphones( $args ){
        if( !checkAdminRole() )
            return;
        $model = $this->createModel( "MobilePhones", array(new TDb) );
        if ( isset($_POST["marked"]) )
            foreach( $_POST["marked"] as $phoneId)
                $model->delPhone($phoneId);
        redirect("mobilephones/listphones");
    }
    function action_modphone( $args ){
        if( !checkAdminRole() )
            return;
        if( count($args)!=1 ){
            p404();
            return;
        }

        $model = $this->createModel( "MobilePhones", array(new TDb) );
        $phoneId = $args[0];

        if( !isset($_POST["number"]) ){
            $modelUsers = $this->createModel( "Users", array(new TDb) );
            $model->currentData->usersList = $modelUsers->getAllUsers();
            $model->currentData->phone =  $model->getPhone( $phoneId );

            $view = new THView( "mobpeditphone", $model );
            TWebApp::getWebApp()->view->addSubView("mainPart", $view);
        }
        else{
            $phone = new TMobilePhone();
            $phone->id = $phoneId;
            $phone->number = $_POST["number"];
            $phone->description = $_POST["description"];
            $phone->owner_id = $_POST["owner_id"];
            $model->modPhone( $phone );

            redirect("mobilephones/listphones");
        }
    }


    // Типы начислений
    function action_addcrgtype( $args ){
        if( !checkAdminRole() )
            return;

        $model = $this->createModel( "MobilePhones", array(new TDb) );
        if( !isset($_POST["id"]) ){
            $view = new THView( "mobpaddcrgtype", $model );
            TWebApp::getWebApp()->view->addSubView("mainPart", $view);
        }
        else{
            $crg = new TMobileChargeType();
            $crg->id = $_POST["id"];
            $crg->description = $_POST["description"];
            $crg->active = isset($_POST["active"]) ? 1:0;
            $model->addChargeType( $crg );
            redirect("mobilephones/listcrgtypes");
        }
    }
    function action_listcrgtypes( $args ){
        if( !checkAdminRole() )
            return;
        $model = $this->createModel( "MobilePhones", array(new TDb) );
        $view = new THView( "mobplistcrgtypes", $model );
        TWebApp::getWebApp()->view->addSubView("mainPart", $view);
    }
    function action_delcrgtypes( $args ){
        if( !checkAdminRole() )
            return;
        $model = $this->createModel( "MobilePhones", array(new TDb) );
        if ( isset($_POST["marked"]) )
            foreach( $_POST["marked"] as $crgtId)
                $model->delChargeType($crgtId);
        redirect("mobilephones/listcrgtypes");
    }
    function action_activecrgtypes( $args ){
        if( !checkAdminRole() )
            return;
        $active = $args[0];
        $model = $this->createModel( "MobilePhones", array(new TDb) );
        if ( isset($_POST["marked"]) )
            foreach( $_POST["marked"] as $crgtId)
                $model->activateChargeType($crgtId, $active);
        redirect("mobilephones/listcrgtypes");
    }
    function action_modcrgtype( $args ){
        if( !checkAdminRole() )
            return;
        $model = $this->createModel( "MobilePhones", array(new TDb) );
        $cgrtId = $args[0];

        if( !isset($_POST["id"]) ){
            $model->currentData->crgt = $model->getChargeType($cgrtId);
            $view = new THView( "mobpeditcrgt", $model );
            TWebApp::getWebApp()->view->addSubView("mainPart", $view);
        }
        else{
            $crgt = new TMobileChargeType();
            $crgt->id = $_POST["id"];
            $crgt->description = $_POST["description"];
            $crgt->active = isset($_POST["active"]) ? 1:0;
            $model->modChargeType( $crgt, $cgrtId );
            redirect("mobilephones/listcrgtypes");
        }
    }
}

?>