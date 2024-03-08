<?php
//connexion à la base de données my sql
require_once(dirname(__FILE__) . '/../utils/Database.php');
require_once dirname(__FILE__) . '/../utils/sendMail.php';
class User
{
    use sendMail;
    //Attributs même nom que dans la table de la base de données
    private $_id;
    private $_pseudonym;
    private $_firstname;
    private $_lastname;
    private $_email;
    private $_password;
    private $_deleted_at;
    private $_registered_at;
    // clés étrangéres
    private $_id_role;
    private $_confirmation_token;

    //objet PDO
    private $_pdo;
    /****************************************************************************************************************************************/
    /****************************************************************************************************************************************/
    //Méthodes __construct Crée un objet PDO qui représente une connexion à la base.
    public function __construct(
        //paramétres de la fonction
        $id = NULL,
        $pseudonym  = NULL,
        $firstname  = NULL,
        $lastname  = NULL,
        $email  = NULL,
        $password  = NULL,
        $deleted_at  = NULL,
        $registered_at  = NULL,
        $id_role  = 1, //1 est le rôle par défaut un utilisateur
        $confirmation_token
    ) {
        //Hydrater les attributs = donner une valeur aux attributs 
        $this->_id = $id;
        $this->_pseudonym = $pseudonym;
        $this->_firstname = $firstname;
        $this->_lastname = $lastname;
        $this->_email = $email;
        $this->_password = $password;
        $this->_deleted_at = $deleted_at;
        $this->_registered_at = $registered_at;
        $this->_id_role = $id_role;
        $this->_confirmation_token;
        //connexion base de données
        //appel de la fonction statique 
        $this->_pdo = Database::connect();
    }

    /****************************************************************************************************************************************/
    // Methode qui permet de récuperer le profil d'un utilisateur
    // paramétre $id return objet / objet pdo
    public static function get($id)
    {
        $pdo = Database::connect();
        try {
            $sql = 'SELECT * FROM `user`
            WHERE `id` = :id;';

            $sth = $pdo->prepare($sql);

            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            if ($sth->execute()) {
                return ($sth->fetch());
            }
        } catch (PDOException $e) {
            return $e;
        }
    }
    /****************************************************************************************************************************************/
    // 1 paramétre d'entrer l'id de l'utilisateur et retourne le nombre de ligne affecter ou false
    public static function validateSignUp($id)
    {
        try {

            $pdo = Database::connect();
            $sql = 'UPDATE `user` 
                    SET `registered_at` = NOW()
                    WHERE `id` = :id;';
            $sth = $pdo->prepare($sql);
            //on supprime le token de validation
            User::clearToken($id);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            if ($sth->execute()) {
                return $sth->rowCount();
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    /****************************************************************************************************************************************/
    // 1 paramétre d'entrer l'id de l'utilisateur et supprime le token de validation ou false
    public static function clearToken($id)
    {
        try {

            $pdo = Database::connect();
            $sql = 'UPDATE `user` 
                    SET `confirmation_token` = NULL
                    WHERE `id` = :id;';
            $sth = $pdo->prepare($sql);

            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            if ($sth->execute()) {
                //var_dump($sth->rowCount());
                return $sth->rowCount();
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    /****************************************************************************************************************************************/
    // retourne le nombre de ligne affecter ou false
    public function updateSignUp()
    {
        try {
            $pdo = Database::connect();
            $sql = 'UPDATE `user` 
                     SET 
                        `lastname` = :lastname,
                        `firstname` = :firstname,
                        `email` = :email,
                        `pseudonym` = :pseudonym,
                        `password` = :password
                     WHERE `id` = :id;';
            $sth = $pdo->prepare($sql);
            //utiliser $this
            $sth->bindValue(':id', $this->_id, PDO::PARAM_INT);
            $sth->bindValue(':lastname', $this->_lastname, PDO::PARAM_STR);
            $sth->bindValue(':email', $this->_email, PDO::PARAM_STR);
            $sth->bindValue(':firstname', $this->_firstname, PDO::PARAM_STR);
            $sth->bindValue(':pseudonym', $this->_pseudonym, PDO::PARAM_STR);
            $sth->bindValue(':password', $this->_password, PDO::PARAM_STR);

            if ($sth->execute()) {
                //var_dump($sth->rowCount());
                return 'La mise à jour a bien été effectuée';
            }
        } catch (PDOException $e) {
            return $e;
        }
    }

    /****************************************************************************************************************************************/
    //fonction qui prend en paramétre l'email de l'utilisateur et retourne un objet contenant les informations de l'utilisateur
    public static function getByEmail($email)
    {
        $pdo = Database::connect();
        try {
            $sql = 'SELECT * FROM `user` 
                    WHERE `email` = :email AND registered_at IS NOT NULL AND deleted_at IS NULL';

            $sth = $pdo->prepare($sql);

            $sth->bindValue(':email', $email);

            if ($sth->execute()) {
                return ($sth->fetch());
            }
        } catch (PDOException $e) {
            return $e;
        }
    }
    /****************************************************************************************************************************************/
    //fonction qui retourne un token
    private function setToken()
    {
        $length = 60;
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }
    /****************************************************************************************************************************************/
    //retourne tous les users de la table users 
    //pour l'admin
    public static function getAll()
    {
        try {
            //requette sql pour tous les users de la table user sauf password
            $sql = 'SELECT $id, $pseudonym, $firstname, $lastname, $email, $deleted_at, $registered_at, $id_role FROM `user` ORDER BY lastname;';
            $pdo = Database::connect();
            // protection sql (injection)
            $sth = $pdo->query($sql);
            //renvoi un tableau d'objet avec les infos des users de la base de données
            $getAll = $sth->fetchAll();
            return $getAll;
        } catch (PDOException $ex) {
            //gestion erreurs 
            return $ex;
        }
    }
    /****************************************************************************************************************************************/
    //méthode qui vérifie si l'utilisateur n'existe pas déjà à l'aide de son adresse email retourne un objet si l'user existe sinon retourne false
    public static function isExist($email)
    {
        //requette sql pour un email passer en paramétre
        $sql = "SELECT * FROM `user` WHERE `email`=:email;";
        // protection sql (injection)
        $pdo = Database::connect();
        $sth = $pdo->prepare($sql);
        //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui à été utilisée pour préparer la requête.
        $sth->bindValue(':email', $email, PDO::PARAM_STR);
        //Exécute une requête préparée
        $sth->execute();
        //renvoi un objet contenant les informations de user s'il est dans la base de données ou renvoi false si le email n'est pas dans la table
        $returnexist = $sth->fetch();
        //retour de la fonction
        return $returnexist;
    }
    /****************************************************************************************************************************************/
    //méthode qui vérifie si le pseudonym n'existe pas déjà retourne un objet si le pseudonym existe sinon retourne false
    public static function isExistPseudonym($pseudonym)
    {
        //requette sql pour un email passer en paramétre
        $sql = "SELECT * FROM `user` WHERE `pseudonym`=:pseudonym;";
        // protection sql (injection)
        $pdo = Database::connect();
        $sth = $pdo->prepare($sql);
        //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a été utilisée pour préparer la requête.
        $sth->bindValue(':pseudonym', $pseudonym, PDO::PARAM_STR);
        //Exécute une requête préparée
        $sth->execute();
        //renvoi un objet contenant les informations de user s'il est dans la base de données ou renvoi false si le email n'est pas dans la table
        $returnexist = $sth->fetch();
        //retour de la fonction
        return $returnexist;
    }
    /****************************************************************************************************************************************/
    // créé un nouvel user aprés avoir vérifier si l'email n'existe pas dans la base de données retour true ou un PDOException avec des messages d'erreurs
    public function create()
    {
        //si la méthode isExist revoi false  l'utilisateur est un nouvel utilisateur et est donc envoyé dans la base de données
        if (!$this->isExist($this->_email) && !$this->isExistPseudonym($this->_pseudonym)) {
            try {
                //requéte sql préparée afin d'écrire les informations du "profil" de user dans la base de données
                $sql = 'INSERT INTO `user` (`id`, `pseudonym`, `firstname`, `lastname`, `email`, `password`,`deleted_at`,`registered_at`,`id_role`,`confirmation_token`)
            VALUES
            (:id, :pseudonym, :firstname, :lastname, :email, :password ,:deleted_at , :registered_at, :id_role, :confirmation_token)';
                //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a était utilisée pour préparer la requête.
                // protection sql (injection)
                $sth = $this->_pdo->prepare($sql);
                $token = $this->setToken();

                $sth->bindValue(':id', $this->_id, PDO::PARAM_INT);
                $sth->bindValue(':pseudonym', $this->_pseudonym, PDO::PARAM_STR);
                $sth->bindValue(':firstname', $this->_firstname, PDO::PARAM_STR);
                $sth->bindValue(':lastname', $this->_lastname, PDO::PARAM_STR);
                $sth->bindValue(':email', $this->_email, PDO::PARAM_STR);
                $sth->bindValue(':password', $this->_password, PDO::PARAM_STR);
                $sth->bindValue(':deleted_at', $this->_deleted_at, PDO::PARAM_STR);
                $sth->bindValue(':registered_at', $this->_registered_at, PDO::PARAM_STR);
                $sth->bindValue(':id_role', $this->_id_role, PDO::PARAM_INT);
                $sth->bindValue(':confirmation_token', $token, PDO::PARAM_STR);

                if ($sth->execute()) {
                    //envoi de l'email de validation du compte
                    $id = $this->_pdo->lastInsertId();
                    //appel de la méthode pour envoyer le mail avec en paramétre l'id l'email et le token en basse de données
                    $this->sendMailConfirm($id, $this->_email, $token);
                } else {
                    //retourne true si pas de message d'erreurs
                    return true;
                }
                //erreur de connexion a la base de données retoune un objet PDOExeption
            } catch (\PDOException $ex) {
                return $ex;
            }
            //erreur l'utilisateur à déjà un compte
        } else {
            return $errorMessage = 'Email ou pseudonym déjà utilisé essayez de vous connecter';
        }
    }
    /**********************************************************************************************************************************************************************/
    //méthode pour afficher les informations du profile de l'utilisateur retourne un objet avec les informations du user ou des messages d'erreurs
    public static function getProfile($id) // displayOne
    {
        // récupérer un utilisateur grâce à son id 
        //requéte sql préparer "SELECT `pseudonym`,`firstname`,`lastname`,`email`,`registered_at`,`id_role` FROM `user` WHERE `id`= 1;"
        $sql = 'SELECT * FROM `user` WHERE `id`= :id;';
        //connexion base de données
        //fonction statique appel    use sendMail;

        $pdo = Database::connect();
        try {
            // On fait un prepare ici car ont doit récupérer les informations de User dont la valeur de l'id est passée en paramétre de la méthode displayProfile
            $sth = $pdo->prepare($sql);
            //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a été utilisée pour préparer la requête.
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            // on execute la requête SQL preparée
            if ($sth->execute()) {
                // on gére ici le retour de la méthode
                $patient = $sth->fetch();
                if ($patient) {
                    return $patient;
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
    /****************************************************************************************************************************************/
    //méthode pour changer les informations du profile de l'utilisateur envois les informations modifiées à la base de données
    // ou renvoi un objet PDOException avec les erreurs
    public static function update($objet_user)
    {
        $sql = 'UPDATE `user` SET :pseudonym, :firstname, :lastname,
                                     :email, :registered_at, :id_role WHERE `id`= :id';
        $pdo = Database::connect();
        try {
            // On fait un prepare ici car on doit récupérer la valeur de l'id de la requête
            // bindValue associe une valeur à un paramètre
            // même dénomination que celle de la base de données
            $pdo = Database::connect();
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':id', $objet_user->_id, PDO::PARAM_INT);
            $sth->bindValue(':pseudonym', $objet_user->_pseudonym, PDO::PARAM_STR);
            $sth->bindValue(':firstname', $objet_user->_firstname, PDO::PARAM_STR);
            $sth->bindValue(':lastname', $objet_user->_lastname, PDO::PARAM_STR);
            $sth->bindValue(':email', $objet_user->_email, PDO::PARAM_STR);
            $sth->bindValue(':registered_at', $objet_user->_registered_at, PDO::PARAM_STR);
            $sth->bindValue(':id_role', $objet_user->_id_role, PDO::PARAM_INT);

            // exécute la requête sql préparée
            if ($sth->execute()) {
                $user = $sth->fetch();
                if ($user) {
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
    /****************************************************************************************************************************************/
    // 1 parametre d'entrer l'id de l'utilisateur et retourne le nombre de lignes affectées ou false
    public static function deactivated($id)
    {
        try {
            $pdo = Database::connect();
            $sql = 'UPDATE `user` 
                    SET `deleted_at` = NOW()
                    WHERE `id` = :id;';
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            if ($sth->execute()) {
                return $sth->rowCount();
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    /****************************************************************************************************************************************/
    //changer le mot de passe si oublier non fonctionnelle
    public function  forgottenPassword($id, $email)
    {
        //si la méthode isExist revoi true  l'utilisateur existe et donc un email est envoyé à son adresse email de récupération
        if ($this->isExist($email)) {
            try {
                //requête sql préparée afin d'écrire les informations du "profil" de user dans la base de données
                $sql = 'UPDATE `user` SET confirmation_token = :confirmation_token WHERE `email`= :email;';
                //Associe une valeur à un nom correspondant (comme paramètre fictif) dans la requête SQL qui a était utilisée pour préparer la requête.
                // protection sql (injection)
                $sth = $this->_pdo->prepare($sql);
                $token = $this->setToken();

                $sth->bindValue(':confirmation_token', $token, PDO::PARAM_STR);
                $sth->bindValue(':email', $this->_email, PDO::PARAM_STR);

                if ($sth->execute()) {
                    //envoi de l'email de validation du compte
                    $id = $this->_pdo->lastInsertId();
                    //appel de la méthode pour envoyer le mail avec en paramétre l'id l'email et le token en basse de données
                    $this->sendMailConfirm($id, $email, $token);
                } else {
                    //retourne true si pas de message d'erreurs
                    return true;
                }
                //erreur de connexion à la base de données retoune un objet PDOExeption
            } catch (\PDOException $ex) {
                return $ex;
            }
            //erreur l'utilisateur à déjà un compte
        } else {
            return $errorMessage = 'Email ou pseudonym déjà utilisé essayez de vous connecter';
        }
    }
    /****************************************************************************************************************************************/
}
