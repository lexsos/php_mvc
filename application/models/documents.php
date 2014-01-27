<?php

/*
CREATE TABLE documents (
    id SERIAL PRIMARY KEY,
    createdate timestamp NOT NULL,
    topic varchar(250) NOT NULL,
    zipfilename varchar(250) NOT NULL
);
4*/

class TDocument{
    public $id;
    public $topic;

    private $zipfilename;
    private $zip;

    function TDocument( $id, $topic, $zipFileName ){
        $this->zipfilename = $zipFileName;
        $this->zip = new ZipArchive;
        $this->zip->open( $zipFileName );

        $this->id = $id;
        $this->topic = $topic;
    }

    function pageCount(){
        return $this->zip->numFiles;
    }

    function getPage( $number ){
        if ( $number<1 || $number > $this->pageCount() )
            return null;
        return $this->zip->getFromName( $number . ".jpg");
    }
}

class ModelDocuments extends Model{

    private $db;

    function ModelDocuments( $args ){
        parent::__construct();
        $this->db = $args[0];
    }

    function addDocument( $tmpFileName, $topic ){
        $conf = $this->webApp->config;
        $sql = "INSERT INTO documents (createdate, topic, zipfilename) 
                VALUES (NOW(), ?, ?) 
                RETURNING id;";
        $args = array( $topic, "" );
        $arr = $this->db->queryObjs( $sql, $args);
        $id = $arr[0]->id;

        $filename =  $id . ".zip";
        copy($tmpFileName, $conf->docsDir . "/" . $filename );

        $sql = "UPDATE documents
                SET zipfilename=?
                WHERE id=?;";
        $args = array( $filename, $id);
        $this->db->execute( $sql, $args);
    }

    function getDocument( $id ){
        $sql = "SELECT *
                FROM documents
                WHERE id=?;";
        $args = array( $id );
        $arr = $this->db->queryObjs( $sql, $args);

        if( count($arr) == 0 )
            return null;

        $obj = $arr[0];
        $conf = $this->webApp->config;
        $filepath = $conf->docsDir . "/" . $obj->zipfilename;
        return new TDocument( $obj->id, $obj->topic, $filepath );
    }

    function delDocument( $id ){
        $sql = "SELECT *
                FROM documents
                WHERE id=?;";
        $args = array( $id );
        $arr = $this->db->queryObjs( $sql, $args);

        if( count($arr) == 0 )
            return null;
        $obj = $arr[0];
        $conf = $this->webApp->config;
        $filepath = $conf->docsDir . "/" . $obj->zipfilename;
        unlink( $filepath );

        $sql = "DELETE FROM documents
                WHERE id=?;";
        $args = array( $id );
        $this->db->execute( $sql, $args);

    }

    function getDocsList(){
        $sql = "SELECT * FROM documents ORDER BY createdate DESC;";
        return $this->db->queryObjs( $sql );
    }
}

?>