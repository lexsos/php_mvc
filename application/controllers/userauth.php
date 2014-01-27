<?php

class ControllerUserAuth extends TController{

    function action_index( $args ){
    }

    private function getLdapModel(){
        return $this->createModel( "LdapAuth" );
    }

    private function getDbModel(){
        return $this->createModel( "Users", array(new TDb()) );
    }

    private function checkDbUser( $ldapUser, $modelUsers ){
        if($ldapUser->authState !== AuthState::successAuth)
            return;
        $user = new TDbUser();
        $user->name = $ldapUser->name;
        $user->fio = $ldapUser->fio;
        $modelUsers->checkUser( $user );
    }

    function action_auth( $args ){

        $userName = $_POST["username"];
        $userPasswd = $_POST["passwd"];

        $model = $this->getLdapModel();
        $model->auth($userName, $userPasswd);

        redirect("");

        $this->checkDbUser( TWebApp::getWebApp()->register->ldapUser, $this->getDbModel() );
    }

    function action_userform( $args ){

        $model = $this->getLdapModel();

        $view = null;
        if( $model->webApp->register->ldapUser->authState === AuthState::successAuth )
            $view = new THView( "userinfo", $model );
        else
            $view = new THView( "authform", $model );

        TWebApp::getWebApp()->view->addSubView("rightPart", $view);

    }

    function action_cheksession( $args ){
        $model = $this->getLdapModel();
        $model->checkSession();

        $modelDb = $this->getDbModel();
        $modelDb->loadUser();
    }

    function action_updateusers( $args ){
        $model = $this->getLdapModel();
        $modelDb =$this->getDbModel();
        foreach ( $model->getAllUsers() as $ldapUser )
            $this->checkDbUser($ldapUser, $modelDb);
    }
}

?>