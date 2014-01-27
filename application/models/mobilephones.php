<?php

/*

CREATE TABLE mobilePhones(
    id SERIAL PRIMARY KEY,
    number varchar(50) NOT NULL UNIQUE,
    description varchar(250),
    owner_id integer NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Типы начислений
CREATE TABLE mobileChargesType(
    id integer PRIMARY KEY,
    description varchar(50) NOT NULL UNIQUE,
    active boolean NOT NULL DEFAULT false
);

-- Лимиты устанавливаются на пользователя, минимальный срок лимита 1 месяц
CREATE TABLE mobileLimits(
    id SERIAL PRIMARY KEY,
    startdate date NOT NULL,
    pricelimit double precision  NOT NULL,
    user_id integer NOT NULL REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,

    UNIQUE (startdate, user_id)
);

-- Месяцы
CREATE TABLE mobileMonths(
    id SERIAL PRIMARY KEY,
    year integer NOT NULL,
    month integer NOT NULL,

    UNIQUE (year, month)
);

-- Начисления на номера
CREATE TABLE mobileCharges(
    id SERIAL PRIMARY KEY,
    mouth_id integer NOT NULL REFERENCES mobileMonths (id) ON DELETE CASCADE ON UPDATE CASCADE,
    charge_id integer NOT NULL REFERENCES mobileChargesType (id) ON DELETE CASCADE ON UPDATE CASCADE,
    phone_id integer NOT NULL REFERENCES mobilePhones (id) ON DELETE CASCADE ON UPDATE CASCADE,
    price double precision  NOT NULL
);

-- Детализация
CREATE TABLE mobileDetail(
    id bigserial PRIMARY KEY,
    phone_id integer NOT NULL REFERENCES mobilePhones (id) ON DELETE CASCADE ON UPDATE CASCADE,
    mouth_id integer NOT NULL REFERENCES mobileMonths (id) ON DELETE CASCADE ON UPDATE CASCADE,

    calldate timestamp NOT NULL,
    price double precision  NOT NULL,
    sec integer,
    dst varchar(50),
    ctype varchar(10),
    ccode varchar(10)
);

*/

class TMobilePhone{

    public $id;
    public $number;
    public $description;
    public $owner_id;

    public $owner_fio;
}

class TMobileChargeType{
    public $id;
    public $description;
    public $active;
}

class TMobileLimit{
    public $id;
    public $startdate;
    public $pricelimit;
    public $user_id;
}

class TMobileMonth{
    public $id;
    public $year;
    public $month;
}

class TMobileCharge{
    public $id;
    public $mouth_id;
    public $charge_id;
    public $phone_id;
    public $price;
}

class TMobileDetail{
    public $id;
    public $phone_id;
    public $mouth_id;

    public $calldate;
    public $price;
    public $sec;
    public $dst;
    public $ctype;
    public $ccode;
}

class ModelMobilePhones extends Model{
    private $db;

    function ModelMobilePhones( $args ){
        parent::__construct();
        $this->db = $args[0];
    }

    // Телефоны
    function addPhone( TMobilePhone $phone){
        $sql = "INSERT INTO mobilePhones (number, description, owner_id)
                VALUES (?, ?, ?);";
        $args = array( $phone->number, $phone->description, $phone->owner_id );
        $this->db->execute( $sql, $args);
    }
    function modPhone( TMobilePhone $phone){
        $sql = "UPDATE mobilePhones
                SET number=?, description=?, owner_id=?
                WHERE id=?;";
        $args = array( $phone->number, $phone->description, $phone->owner_id, $phone->id );
        $this->db->execute( $sql, $args);
    }
    function delPhone( $phoneId ){
        $sql = "DELETE FROM mobilePhones
                WHERE id=?;";
        $args = array( $phoneId );
        $this->db->execute( $sql, $args);
    }
    function getPhone( $phoneId ){
        $sql = "SELECT mobilePhones.*,
                        users.fio AS owner_fio
                FROM mobilePhones
                LEFT OUTER JOIN users ON mobilePhones.owner_id=users.id
                WHERE mobilePhones.id=?;";
        $args = array( $phoneId );
        $arr = $this->db->queryObjs( $sql, $args, "TMobilePhone");
        if (count($arr)>0)
            return $arr[0];
        return null;
    }
    function getAllPhones(){
        $sql = "SELECT mobilePhones.*,
                        users.fio AS owner_fio
                FROM mobilePhones
                LEFT OUTER JOIN users ON mobilePhones.owner_id=users.id
                ORDER BY mobilePhones.number;";
        return $this->db->queryObjs( $sql, null, "TMobilePhone");
    }
    function getPhonesByOwner( $ownerId ){
        $sql = "SELECT mobilePhones.*,
                        users.fio AS owner_fio
                FROM mobilePhones
                LEFT OUTER JOIN users ON mobilePhones.owner_id=users.id
                WHERE mobilePhones.owner_id=?
                ORDER BY mobilePhones.number;";
        $args = array( $ownerId );
        return $this->db->queryObjs( $sql, $args, "TMobilePhone");
    }
    function isOwnerPhone( $userId, $phoneId ){
        $sql = "SELECT id
                FROM mobilePhones
                WHERE owner_id=? AND id=?;";
        $args= array( $userId, $phoneId );
        return count( $this->db->queryObjs($sql, $args) ) > 0;
    }

    // Типы начислений
    function addChargeType( TMobileChargeType $crgType ){
        $sql = "INSERT INTO mobilechargestype (id, description, active)
                VALUES (?, ?, ?);";
        $args = array( $crgType->id, $crgType->description, $crgType->active );
        $this->db->execute( $sql, $args);
    }
    function delChargeType( $cgrId ){
        $sql = "DELETE FROM mobilechargestype
                WHERE id=?;";
        $args = array( $cgrId );
        $this->db->execute( $sql, $args);

    }
    function modChargeType( TMobileChargeType $crgType, $crgId ){
        $sql = "UPDATE mobilechargestype
                SET id=?, description=?, active=?
                WHERE id=?;";
        $args = array( $crgType->id, $crgType->description, $crgType->active, $crgId );
        $this->db->execute( $sql, $args);
    }
    function activateChargeType( $crgId, $status ){
        $sql = "UPDATE mobilechargestype
                SET active=?
                WHERE id=?;";
        $args = array( $status, $crgId );
        $this->db->execute( $sql, $args);
    }
    function getAllChargeTypes(){
        $sql = "SELECT * FROM mobilechargestype ORDER BY id;";
        return $this->db->queryObjs( $sql, null, "TMobileChargeType");
    }
    function getChargeType( $crgtId ){
        $sql = "SELECT * FROM mobilechargestype
                WHERE id=?;";
        $args = array( $crgtId );
        return $this->db->queryObj( $sql, $args, "TMobileChargeType");
    }

    // Пользовательские лимиты
    function addLimit(TMobileLimit $limit){
    }
    function delLimit( $id ){
    }
    function getLimitsByUser( $userId ){
    }
    function getLimitByUserMonth( $userId, $month, $year){
    }


    function addMonth( TMobileMonth $month ){
        $id = 0;
        return $id;
    }
    function delMonth( $id ){
    }
    function getIdMonth( $year, $month ){
    }
    function getAllMonths(){
    }


    function addCharge( TMobileCharge $charge ){
    }


    function addDetail( TMobileDetail $detail){
    }
    function getDetailsByPhonePeriod( $phoneId, $from, $to ){
    }
}

?>