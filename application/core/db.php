<?php

class TRecord{

}

/*
    Методы создания и получения подключений к БД
*/

class TDbConnection {

    static private $connPdo = null;

    static function getNewConnection(){
        $config = TWebApp::getWebApp()->config;
        $dsn = "pgsql:host=".$config->dbHost.";dbname=".$config->dbName;
        try{
            $dbh = new PDO($dsn, $config->dbUser, $config->dbPass);
        }
        catch (PDOException $e){
            return null;
        }
        return $dbh;
    }

    static function getCurrentConnection(){
        if (TDbConnection::$connPdo === null)
            TDbConnection::$connPdo = TDbConnection::getNewConnection();
        return TDbConnection::$connPdo;
    }
}

/*
    Объект позволяет выполнять запросы в БД
*/

class TDb {

    private $pdo;

    function TDb( $dbPdo = null ){
        $this->pdo = ($dbPdo !== null) ?$dbPdo : TDbConnection::getNewConnection() ;
    }

    function execute( $sql, $args = null ){
        $sth = $this->pdo->prepare( $sql );
        $sth->execute( $args );
        $sth->closeCursor();
    }

    function queryObjs( $sql, $sqlArgs = null, $type = 'TRecord', $constructArgs = null ){
        $sth = $this->pdo->prepare( $sql );
        $sth->execute( $sqlArgs );
        $result = array();
        while( $obj = $sth->fetchObject($type, $constructArgs) )
            $result[] = $obj;
        $sth->closeCursor();
        return $result;
    }
    function queryObj( $sql, $sqlArgs = null, $type = 'TRecord', $constructArgs = null ){
        $arr = $this->queryObjs( $sql, $sqlArgs, $type, $constructArgs );
        if( count($arr)>0 )
            return $arr[0];
        return null;
    }
}

?>