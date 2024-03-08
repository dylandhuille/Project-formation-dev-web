<?php
// appel des fichiers
require_once(dirname(__FILE__) . '/../utils/regex.php');
require_once(dirname(__FILE__) . '/../model/User.php');

// on vérifie si la méthode $_POST existe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*************************************************Lastname***************************************************************/
    // Lastname : nettoyage et validation
    $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
    // on vérifie si Lastname n'est pas vide
    if (!empty($lastname)) {
        $testRegex = preg_match('/' . REGEX_NO_NUMBER . '/', $lastname);
        //  vérification du format
        if (!$testRegex) {
            $error["lastname"] = "Le nom n'est pas au bon format!!";
        } else {
            //  vérification de la longeur de la chaine de caractère
            if (strlen($lastname) <= 1 || strlen($lastname) >= 70) {
                $error["lastname"] = "La longueur de chaine n'est pas bonne";
            }
        }
    } else { //retourne une erreur dans le tableau d'erreurs
        $error["lastname"] = "Vous devez entrer un nom!!";
    }
    /*********************************************firstname*******************************************************************/

    // firstname : nettoyage et validation
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
    // on vérifie si $firstname n'est pas vide
    if (!empty($firstname)) {
        $testRegex = preg_match('/' . REGEX_NO_NUMBER . '/', $firstname);
        //  vérification du format
        if (!$testRegex) {
            $error["firstname"] = "Le prénom n'est pas au bon format!!";
        } else {
            //  vérification de la longeur de la chaine de caractère
            if (strlen($firstname) <= 1 || strlen($firstname) >= 70) {
                $error["firstname"] = "La longueur de chaine n'est pas bonne";
            }
        }
    } else { // retourne une erreur dans le tableau d'erreurs
        $error["firstname"] = "Vous devez entrer un prénom!!";
    }
    /*********************************************pseudonym*******************************************************************/

    // pseudonym : nettoyage et validation
    $pseudonym = trim(filter_input(INPUT_POST, 'pseudonym', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
    //on vérifie si $pseudonym n'est pas vide
    if (!empty($pseudonym)) {
        $testRegex = preg_match('/' . REGEX_NO_NUMBER . '/', $pseudonym);
        // vérification du format
        if (!$testRegex) {
            $error["pseudonym"] = "Le pseudonym n'est pas au bon format!!";
        } else {
            // vérification de la longeur de la chaine de caractère
            if (strlen($pseudonym) <= 1 || strlen($pseudonym) >= 70) {
                $error["pseudonym"] = "La longueur de chaine n'est pas bonne";
            }
        }
    } else { // retourne une erreur dans le tableau d'erreurs
        $error["pseudonym"] = "Vous devez entrer un pseudonym!!";
    }
    /******************************************email**********************************************************************/

    // email : nettoyage et validation
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    //   on vérifie si $email n'est pas vide
    if (!empty($email)) {
        $testEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        // vérification du format
        if (!$testEmail) {
            $error["email"] = "L'adresse email n'est pas au bon format!!";
        }
    } else { // retourne une erreur dans le tableau d'erreurs
        $error["email"] = "L'adresse email est obligatoire!!";
    }
    /********************************************password********************************************************************/
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if ($password1 != $password2) {
        $errorsArray['password'] = 'Les mots de passe sont différents';
    } else {
        // on hash le mot de passe avant de l'envoyer en base
        $password = password_hash($password1, PASSWORD_DEFAULT);
    }
    /*****************************************error***********************************************************************/

    if (empty($error)) {
        //on passe les infos du user pour hydrater l'objet user
        $user = new User($id = NULL, $pseudonym, $firstname, $lastname, $email, $password, $deleted_at  = NULL, $registered_at = NULL, $id_role = 1, $confirmation_token = NULL);

        // appel de la méthode create de l'objet user qui remplie la base de données
        $response = $user->create();

        if ($response !== true) {
            $customMessage = $response;
        } else {
            $customMessage = 'Vous avez bien était enregistré !!!';
        }
    }
}
// appel du fichier header.php
include_once(dirname(__FILE__) . '/../views/templates/header.php');
// appel du fichier singUp.php
include_once(dirname(__FILE__) . '/../views/signUp.php');
// appel du fichier footer
include_once(dirname(__FILE__) . '/../views/templates/footer.php');
