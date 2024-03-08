<?php
require_once(dirname(__FILE__) . '/../config/bdd-log.php');

class Database
{
        //Attribut
        private static $_pdo;
        public static function connect()
        {
            //On essaie de se connecter
            try {
                // pour éviter de créé un nouvelle objet pdo si il existe deja
                if(is_null(self::$_pdo)){
                    self::$_pdo = new PDO('mysql:host=' . SERVNAME . ';dbname=' . DBNAME, USER, PASS);
                    //$pdo = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
                    //On définit le mode d'erreur de PDO sur Exception ici un objet
                    self::$_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                    self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // pour utiliser utf8
                    self::$_pdo->exec("SET NAMES 'UTF8'");
                }
                //pour les char spé
                return self::$_pdo; 
            }
        /*On capture les exceptions si une exception est lancée et on affiche
        les informations relatives à celle-ci*/
        //retourne un objet PDOException
        catch (PDOException $ex) {
            $errorMessage = $ex->getMessage();
            return $errorMessage;        }
    }
}
