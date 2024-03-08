<?php
require_once(dirname(__FILE__).'/../utils/Database.php');

class City{

    public static function getByZip($zipcode){
        //SELECT `id`, `city` FROM `city` WHERE `zip_code`= '%01000%';
        $pdo = Database::connect();
        $sql = 'SELECT `id`, `city` FROM `city` 
            WHERE `zip_code` LIKE :zipcode;';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':zipcode','%'.$zipcode.'%');
        $sth->execute();
        return($sth->fetchAll());

    }
}