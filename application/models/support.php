<?php

/*

CREATE TABLE supporttickets (
    id SERIAL PRIMARY KEY,
    createdate timestamp NOT NULL,
    modifydate timestamp NOT NULL,
    topic varchar(250) NOT NULL,
    creator_id integer NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE supportmessages (
    id SERIAL PRIMARY KEY,
    createdate timestamp NOT NULL,
    creator_id integer NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
    ticket_id integer NOT NULL REFERENCES supporttickets (id) ON DELETE CASCADE ON UPDATE CASCADE,
    content text
)

*/

class TSupTicket{
    public $id;
    public $createdate;
    public $modifydate;
    public $topic;
    public $creator_id;

    public $strdate;
    public $strmoddate;
    public $creatorfio;
}

class TSupMsg{
    public $id;
    public $createdate;
    public $creator_id;
    public $ticket_id;
    public $content;

    public $strdate;
    public $creatorfio;
}

class ModelSupport extends Model{

    private $db;

    function ModelSupport( $args ){
        parent::__construct();
        $this->db = $args[0];
    }

    function addTicket( TSupTicket $ticket ){
        $sql = "INSERT INTO supporttickets (createdate, modifydate, topic, creator_id) 
                VALUES (NOW(), NOW(), ?, ?) 
                RETURNING id;";
        $args = array( $ticket->topic, $ticket->creator_id );
        $arr = $this->db->queryObjs( $sql, $args);
        return $arr[0]->id;
    }

    function addMsg( TSupMsg $msg ){
        $sql = "INSERT INTO supportmessages (createdate, creator_id, ticket_id, content) 
                VALUES (NOW(), ?, ?, ?);";
        $args = array( $msg->creator_id, $msg->ticket_id, $msg->content);
        $this->db->execute( $sql, $args);

        $sql = "UPDATE supporttickets SET modifydate=NOW() WHERE id=?;";
        $args = array( $msg->ticket_id );
        $this->db->execute( $sql, $args);
    }

    function getAllTickets(){
        $sql = "SELECT supporttickets.*, users.fio AS creatorfio,
                        to_char(supporttickets.createdate, 'YYYY-MM-DD HH24:MI:SS') AS strdate,
                        to_char(modifydate, 'YYYY-MM-DD HH24:MI:SS') AS strmoddate
                FROM supporttickets
                LEFT OUTER JOIN users ON supporttickets.creator_id=users.id
                ORDER BY supporttickets.modifydate DESC;";
        return $this->db->queryObjs( $sql, null, "TSupTicket");
    }

    function getTicketsByUser( $userId ){
        $sql = "SELECT *, to_char(createdate, 'YYYY-MM-DD HH24:MI:SS') AS strdate,
                        to_char(modifydate, 'YYYY-MM-DD HH24:MI:SS') AS strmoddate
                FROM supporttickets 
                WHERE creator_id=? 
                ORDER BY modifydate DESC;";
        $args = array( $userId );
        return $this->db->queryObjs( $sql, $args, "TSupTicket");
    }

    function getTicketById( $ticketId ){
        $sql = "SELECT supporttickets.*, to_char(supporttickets.createdate, 'YYYY-MM-DD HH24:MI:SS') AS strdate,
                        to_char(supporttickets.modifydate, 'YYYY-MM-DD HH24:MI:SS') AS strmoddate,
                        users.fio AS creatorfio
                FROM supporttickets
                LEFT OUTER JOIN users ON supporttickets.creator_id=users.id
                WHERE supporttickets.id=?;";
        $args = array( $ticketId );
        $arr = $this->db->queryObjs( $sql, $args, "TSupTicket");
        if( count($arr) != 1 )
            return null;
        return $arr[0];
    }

    function getMsgs( $ticketId ){
        $sql = "SELECT supportmessages.*, users.fio AS creatorfio,
                        to_char(supportmessages.createdate, 'YYYY-MM-DD HH24:MI:SS') AS strdate
                FROM supportmessages
                LEFT OUTER JOIN users ON supportmessages.creator_id=users.id
                WHERE supportmessages.ticket_id=?
                ORDER BY supportmessages.createdate;";

        $args = array( $ticketId );
        return $this->db->queryObjs( $sql, $args, "TSupMsg");
    }
}

?>