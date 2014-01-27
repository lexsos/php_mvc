<?php
/*

CREATE TABLE news (
    id SERIAL PRIMARY KEY,
    postdate timestamp NOT NULL,
    topic varchar(50) NOT NULL,
    content text
);

*/

class TNews{

    public $id;
    public $postdate;
    public $topic;
    public $content;
    public $strdate;
    public $old;
}

class ModelNews extends Model{

    private $db;

    function ModelNews( $args ){
        parent::__construct();
        $this->db = $args[0];
    }

    function addNews( TNews $news ){
        $sql = "INSERT INTO news (postdate, topic, content)
                VALUES (NOW(), ?, ?);";
        $args = array( $news->topic, $news->content );
        $this->db->execute( $sql, $args);
    }

    function getNews( $id ){
        $sql = "SELECT *, to_char(postdate, 'YYYY-MM-DD') AS strdate
                FROM news
                WHERE id=?;";
        $args = array($id);
        $arr = $this->db->queryObjs( $sql, $args, "TNews");
        if ( count($arr) == 1 )
            return $arr[0];
        return null;
    }

    function delNews( $id ){
        $sql = "DELETE FROM news WHERE id=?;";
        $args = array( $id );
        $this->db->execute( $sql, $args);
    }

    function getLatestNews( $countLimit ){
        $sql = "SELECT *,
                        to_char(postdate, 'YYYY-MM-DD') AS strdate,
                        ( NOW()::date - postdate::date) AS old
                FROM news
                ORDER BY postdate DESC
                LIMIT ?;";
        $args = array($countLimit);
        $arr = $this->db->queryObjs( $sql, $args, "TNews");
        return $arr;
    }

    function getAllNews(){
        $sql = "SELECT *,
                        to_char(postdate, 'YYYY-MM-DD') AS strdate,
                        ( NOW()::date - postdate::date) AS old
                FROM news
                ORDER BY postdate DESC;";
        $arr = $this->db->queryObjs( $sql, null, "TNews");
        return $arr;
    }
}

?>