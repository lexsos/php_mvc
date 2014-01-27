<?php

/*
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name varchar(100) NOT NULL UNIQUE,
    fio varchar(100) NOT NULL
);
*/

class TDbUser{
    public $id;
    public $name;
    public $fio;
}


class ModelUsers extends Model{

    private $db;

    function ModelUsers( $args ){
        parent::__construct();
        $this->db = $args[0];
    }

    function addUser( TDbUser $user ){
        $sql = "INSERT INTO users (name, fio) VALUES (?, ?);";
        $args = array( $user->name, $user->fio );
        $this->db->execute( $sql, $args);
    }

    function getUser( $userName ){
        $sql = "SELECT * FROM users WHERE name=?;";
        $args = array($userName);
        $arr = $this->db->queryObjs( $sql, $args, "TDbUser");
        return $arr[0];
    }

    function getAllUsers(){
        $sql = "SELECT *
                FROM users
                ORDER BY fio;";
        return $this->db->queryObjs( $sql, null, "TDbUser");
    }

    function checkUser( TDbUser $user ){
        $duser = $this->getUser( $user->name );
        if (count($duser) === 0)
            $this->addUser($user);
    }

    function loadUser(){
        $webApp = TWebApp::getWebApp();
        $ldapUser = $webApp->register->ldapUser;
        if( $ldapUser->authState === AuthState::successAuth )
            $webApp->register->dbUser = $this->getUser( $ldapUser->name );
    }
}

?>
