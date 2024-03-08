<?php
//connexion à la base de données my sql
require_once(dirname(__FILE__) . '/../utils/Database.php');

class profil
{
    //Attributs même nom que dans la table de la base de données
    private $_id;
    private $_pseudonyme;

    private $_biography;
    private $_various_info;
    private $_profile_picture;
    private $_lifestyle;
    private $_personnality;
    private $_center_of_interest;
    private $_deleted_at;
    // clés étrangéres
    private $_id_property;
    //objet PDO
    private $_pdo;

    /****************************************************************************************************************************************/
    /****************************************************************************************************************************************/
    //Méthodes __construct Crée un objet PDO qui représente une connexion à la base.
    public function __construct(
        //paramétres de la fonction
        $id = NULL,
        $pseudonyme = NULL,
        $biography = NULL,
        $various_info = NULL,
        $profile_picture = NULL,
        $lifestyle = NULL,
        $personnality = NULL,
        $center_of_interest = NULL,
        $deleted_at = NULL,
        // clés étrangéres
        $id_property
    ) {
        //Hydrater les attributs = donner une valeur aux attributs 
        $this->_id = $id;
        $this->_pseudonyme = $pseudonyme;
        $this->_biography = $biography;
        $this->_various_info = $various_info;
        $this->_profile_picture = $profile_picture;
        $this->_lifestyle = $lifestyle;
        $this->_personnality = $personnality;
        $this->_center_of_interest = $center_of_interest;
        $this->_id_property = $id_property;
        $this->_deleted_at = $deleted_at;
        //connexion base de données
        //appel de la fonction statique 
        $this->_pdo = Database::connect();
    }
    /****************************************************************************************************************************************/    
// créé un nouvel property retoure true ou des objet pdo avec les messages d'erreurs
public function create()
{
        try{ 
            //requéte sql préparer afin de recupèrer les informations de property et les "envoi" dans la base de données
            $sql = 'INSERT INTO `profil` 
             (`id`,`pseudonyme`,`biography`,
             `various_info`, `profile_picture`,`lifestyle`,
             `personnality`,`center_of_interest`,`id_property`)
            VALUES
            (:id,:pseudonyme,:biography,
            :various_info, :profile_picture, :lifestyle,
            :personnality, :center_of_interest,:id_property);';
            //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a été utilisé pour préparer la requête.
            // protection sql (injection)
            $sth = $this->_pdo->prepare($sql);
            $sth->bindValue(':id', $this->_id, PDO::PARAM_INT);
            $sth->bindValue(':pseudonyme', $this->_pseudonyme, PDO::PARAM_STR);
            $sth->bindValue(':biography', $this->_biography, PDO::PARAM_STR);

            $sth->bindValue(':various_info', $this->_various_info, PDO::PARAM_STR);
            $sth->bindValue(':profile_picture', $this->_profile_picture, PDO::PARAM_STR);
            $sth->bindValue(':lifestyle', $this->_lifestyle, PDO::PARAM_STR);

            $sth->bindValue(':personnality', $this->_personnality, PDO::PARAM_STR);
            $sth->bindValue(':center_of_interest', $this->_center_of_interest, PDO::PARAM_STR);
            $sth->bindValue(':id_property', $this->_id_property, PDO::PARAM_INT);

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
    $sql = 'SELECT * FROM `profil` WHERE `id_property`= :id_user;';
    //connexion base de données
    $pdo = Database::connect();
    try {
        // On fait un prepare ici car ont doit récupérer les informations de profil dont la valeur de l'id_user est passée en paramétre de la méthode read
        $sth = $pdo->prepare($sql);
        //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a été utilisée pour préparer la requête.
        $sth->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        // on execute la requête SQL preparée
        if ($sth->execute()) {
            // on gére ici le retour de la méthode
            $profil = $sth->fetch();
            if ($profil) {
                return $profil;
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
    public static function update($objet_profil)
    {
        $sql = 'UPDATE `profil` SET :pseudonyme, :biography,
                                    :various_info, :profile_picture, :lifestyle,
                                    :personnality, :center_of_interest, :id_property
          WHERE `id_user`= :_id_user';
        $pdo = Database::connect();
        try {
            // On fait un prepare ici car on doit récupérer la valeur de l'id de la requête
            // bindValue associe une valeur à un paramètre
            // même dénomination que celle de la base de données
            //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a été utilisée pour préparer la requête.

            $pdo = Database::connect();
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':id', $objet_profil->_id, PDO::PARAM_INT);
            $sth->bindValue(':pseudonyme', $objet_profil->_type_of_profil, PDO::PARAM_STR);
            $sth->bindValue(':biography', $objet_profil->_price, PDO::PARAM_STR);

            $sth->bindValue(':various_info', $objet_profil->_living_area, PDO::PARAM_STR);
            $sth->bindValue(':profile_picture', $objet_profil->_land_area, PDO::PARAM_STR);
            $sth->bindValue(':lifestyle', $objet_profil->_number_of_rooms, PDO::PARAM_STR);

            $sth->bindValue(':personnality', $objet_profil->_various_info, PDO::PARAM_STR);
            $sth->bindValue(':center_of_interest', $objet_profil->_description_equipment, PDO::PARAM_STR);
            $sth->bindValue(':id_property', $objet_profil->_number_of_remaining_places, PDO::PARAM_INT);


            // exécute la requête sql préparée
            if ($sth->execute()) {
                $profil = $sth->fetch();
                if ($profil) {
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
        $sql = 'UPDATE `profil` 
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








    //      /****************************************************************************************************************************************/
    //  // Methode qui permet de récuperer le profil d'un utilisateur
    //  // paramétre $id return objet / objet pdo
    //  public static function read($id)
    //  {
    //      $pdo = Database::connect();
    //      try {
    //          $sql = 'SELECT * FROM `profil`
    //          WHERE `id` = :id;';

    //          $sth = $pdo->prepare($sql);

    //          $sth->bindValue(':id', $id, PDO::PARAM_INT);
    //          if ($sth->execute()) {
    //              return ($sth->fetch());
    //          }
    //      } catch (PDOException $e) {
    //          return $e;
    //      }
    //  }
//         /****************************************************************************************************************************************/
//     //retourne tous les profiles du bien
//     //pour l'affichage des profils dans les annonces
//     public static function getAll()
//     {
//         try {
//             //requette sql pour tous les users de la table user sauf password
//             $sql = 'SELECT FROM `patients`;';
//             $pdo = Database::connect();
//             // protection sql (injection)
//             $sth = $pdo->query($sql);
//             //renvoi un tableau d'objet avec les infos des users de la base de données
//             $getAll = $sth->fetchAll();
//             return $getAll;
//         } catch (PDOException $ex) {
//             //gestion erreurs 
//             return $ex;
//         }
//     }
}