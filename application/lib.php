<?php

function p404(){
    $model = new Model();
    $view = new THView( "p404", $model );
    TWebApp::getWebApp()->view = $view;
}

function p403(){
    $model = new Model();
    $view = new THView( "p403", $model );
    TWebApp::getWebApp()->view = $view;
}

function redirect( $path ){
    $model = new ModelRedirect( array($path) );
    $view = new THView( "redirect", $model );
    TWebApp::getWebApp()->view = $view;
}

function isAdmin(){
    $webApp = TWebApp::getWebApp();
    $ldapUser = $webApp->register->ldapUser;
    return $ldapUser->isRole("Admin");
}

function checkAdminRole(){

    if( !isAdmin() ){
        p403();
        return false;
    }
    return true;
}

function isAuth(){
    $webApp = TWebApp::getWebApp();
    $ldapUser = $webApp->register->ldapUser;
    return $ldapUser->authState === AuthState::successAuth;
}

?>
