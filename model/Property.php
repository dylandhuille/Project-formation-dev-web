<?php
//connexion a la base de donnée my sql
require_once(dirname(__FILE__) . '/../utils/Database.php');
class Property
{
    //Attributs même que nom que dans la table
    private $_id;
    private $_type_of_property;
    private $_locations;
    private $_price;
    private $_living_area;
    private $_land_area;
    private $_number_of_rooms;
    private $_various_info;
    private $_description_equipment;
    private $_number_of_remaining_places;
    private $_registered_at;
    private $_deleted_at;
    private $_moderated_at;
    // clés étrangères
    private $_id_user;
    private $_id_city;
    private $_picture;
    //objet pdo
    private $_pdo;
    /****************************************************************************************************************************************/
    /****************************************************************************************************************************************/
    //Méthode __construct Crée un objet PDO qui représente une connexion à la base.
    public function __construct(
        //paramétres de la fonction
        $id = NULL,
        $type_of_property = NULL,
        $price = NULL,
        $living_area = NULL,
        $land_area = NULL,
        $number_of_rooms = NULL,
        $various_info = NULL,
        $description_equipment = NULL,
        $number_of_remaining_places = NULL,
        $registered_at = NULL,
        $deleted_at  = NULL,
        $moderated_at = NULL,
        // clés étrangères
        $id_user = NULL,
        $id_city = NULL,
        $picture
        )
    {
        //Hydrater les attributs = donner une valeur aux attributs 
         $this->_id = $id;
         $this->_type_of_property = $type_of_property;
         $this->_price = $price;
         $this->_living_area = $living_area;
         $this->_land_area = $land_area;
         $this->_number_of_rooms = $number_of_rooms;
         $this->_various_info = $various_info;
         $this->_description_equipment = $description_equipment;
         $this->_number_of_remaining_places = $number_of_remaining_places;
         $this->_registered_at = $registered_at;
         $this->_deleted_at = $deleted_at;
         $this->_moderated_at = $moderated_at;
         $this->_id_user = $id_user;
         $this->_id_city = $id_city;
         $this->_picture = $picture;
        //connexion base de donner
        //fonction statique appel
        $this->_pdo = Database::connect();
    }
    /****************************************************************************************************************************************/    
// créé un nouvel property retoure true ou des objet pdo avec les messages d'erreurs
public function create()
{
        try{ 
            //requéte sql préparer afin de recupèrer les informations de property et les "envoi" dans la base de données
            $sql = 'INSERT INTO `property` 
             (`id`,`type_of_property`,`price`,
             `living_area`, `land_area`, `number_of_rooms`,`various_info`,
             `description_equipment`,`number_of_remaining_places`,`registered_at`,
             `deleted_at`,`moderated_at`,`id_user`,`id_city`,`picture`)
            VALUES
            (:id,:type_of_property,:price,
            :living_area, :land_area, :number_of_rooms ,:various_info,
            :description_equipment, :number_of_remaining_places,:registered_at,
            :deleted_at,:moderated_at,:id_user,:id_city,:picture);';
            //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a été utilisé pour préparer la requête.
            // protection sql (injection)
            $sth = $this->_pdo->prepare($sql);
            $sth->bindValue(':id', $this->_id, PDO::PARAM_INT);
            $sth->bindValue(':type_of_property', $this->_type_of_property, PDO::PARAM_STR);
            $sth->bindValue(':price', $this->_price, PDO::PARAM_INT);

            $sth->bindValue(':living_area', $this->_living_area, PDO::PARAM_INT);
            $sth->bindValue(':land_area', $this->_land_area, PDO::PARAM_INT);
            $sth->bindValue(':number_of_rooms', $this->_number_of_rooms, PDO::PARAM_INT);
            $sth->bindValue(':various_info', $this->_various_info, PDO::PARAM_STR);

            $sth->bindValue(':description_equipment', $this->_description_equipment, PDO::PARAM_STR);
            $sth->bindValue(':number_of_remaining_places', $this->_number_of_remaining_places, PDO::PARAM_INT);
            $sth->bindValue(':registered_at', $this->_registered_at, PDO::PARAM_STR);//date du moment

            $sth->bindValue(':deleted_at', $this->_deleted_at, PDO::PARAM_STR);
            $sth->bindValue(':moderated_at', $this->_moderated_at, PDO::PARAM_STR);

            // clés étrangères
            $sth->bindValue(':id_user', $this->_id_user, PDO::PARAM_INT);
            $sth->bindValue(':id_city', $this->_id_city, PDO::PARAM_INT);

            $sth->bindValue(':picture', $this->_picture, PDO::PARAM_STR);


            //gestions des éventuelles erreurs
            //erreur sql
            if (!$sth->execute()) {
                 //"envoie l'erreur dans le catch" et "centralise les erreurs"
                 throw new PDOException('un problème est survenue lors de la requête Sql'); 
            } else {
                return true;
            }
        //erreur de connexion à la base de données retourne un objet PDOException avec les messages d'erreurs
        } catch (\PDOException $ex) {
            return $ex;
        }
}
/*************************read*********************************************************************************************************************************************/
//méthode pour afficher les informations d'un bien retourne un objet avec les informations du bien ou des messages d'erreurs

public static function read($id_user){

        // récupérer un bien grâce à son l'id de user
        //requéte sql préparer 
        $sql = 'SELECT * FROM `property` WHERE `id_user`= :id_user;';
        //connexion base de données
        $pdo = Database::connect();
        try {
            // On fait un prepare ici car ont doit récupérer les informations de Property dont la valeur de l'id_user est passée en paramétre de la méthode read
            $sth = $pdo->prepare($sql);
            //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a été utilisée pour préparer la requête.
            $sth->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            // on execute la requête SQL preparée
            if ($sth->execute()) {
                // on gére ici le retour de la méthode
                $property = $sth->fetch();
                if ($property) {
                    return $property;
                } else {
                    // on gére ici les erreurs de la méthode
                    return 'n\'existe pas';
                }
            }
            // on gére ici les erreurs de la requête SQL
        } catch (\PDOException $e) {
            return $e;
        }

        }
/************************update****************************************************************************************************************/
    //méthode pour changer les informations du bien de l'utilisateur envois les informations modifiées à la base de données
    // ou renvoi un objet PDOException avec les erreurs
    public static function update($objet_property)
    {
        $sql = 'UPDATE `property` SET :type_of_property, :price,
                                      :living_area, :land_area, :number_of_rooms,
                                      :various_info, :description_equipment, :number_of_remaining_places,
                                      :registered_at, :deleted_at, :moderated_at,
                                      :id_user, :id_city, :picture
          WHERE `id_user`= :id_user';
        $pdo = Database::connect();
        try {
            // On fait un prepare ici car on doit récupérer la valeur de l'id de la requête
            // bindValue associe une valeur à un paramètre
            // même dénomination que celle de la base de données
            //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a été utilisée pour préparer la requête.

            $pdo = Database::connect();
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':id',  $objet_property->_id, PDO::PARAM_INT);
            $sth->bindValue(':type_of_property', $objet_property->_type_of_property, PDO::PARAM_INT);
            $sth->bindValue(':price', $objet_property->_price, PDO::PARAM_INT);

            $sth->bindValue(':living_area', $objet_property->_living_area, PDO::PARAM_INT);
            $sth->bindValue(':land_area', $objet_property->_land_area, PDO::PARAM_INT);
            $sth->bindValue(':number_of_rooms', $objet_property->_number_of_rooms, PDO::PARAM_INT);

            $sth->bindValue(':various_info', $objet_property->_various_info, PDO::PARAM_STR);
            $sth->bindValue(':description_equipment', $objet_property->_description_equipment, PDO::PARAM_STR);
            $sth->bindValue(':number_of_remaining_places', $objet_property->_number_of_remaining_places, PDO::PARAM_INT);

            $sth->bindValue(':registered_at', $objet_property->_registered_at, PDO::PARAM_STR);
            $sth->bindValue(':deleted_at', $objet_property->_deleted_at, PDO::PARAM_STR);
            $sth->bindValue(':moderated_at', $objet_property->_moderated_at, PDO::PARAM_STR);

            $sth->bindValue(':id_user', $objet_property->_id_user, PDO::PARAM_INT);
            $sth->bindValue(':id_city', $objet_property->_id_city, PDO::PARAM_INT);
            $sth->bindValue(':picture', $objet_property->_picture, PDO::PARAM_STR);


            // exécute la requête sql préparée
            if ($sth->execute()) {
            
                $property = $sth->fetch();
                if ($property) {
                    return 'les modifications ont bien était prise en compte';
                } else {
                    // "envoie l'erreur dans le catch" et "centralise les erreurs" dans le controller
                    throw new PDOException('update impossible problème sql');
                }
            }
        } catch (\PDOException $e) {
            // retourne un objet PDOException avec les erreurs
            return $e;
        }
    }
/************************delete ****************************************************************************************************************/
    // 1 parametre d'entrer l'id de l'utilisateur et retourne le nombre de lignes affectées ou false et désactive l'annonce
public static function Delete($id_user){//deactivated
    try {
        $pdo = Database::connect();
        $sql = 'UPDATE `property` 
                SET `deleted_at` = NOW()
                WHERE `id_user` = :id_user;';
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        if ($sth->execute()) {
            return $sth->rowCount();
        }
    } catch (PDOException $e) {
        return false;
    }
}
}