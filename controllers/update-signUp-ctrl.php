<?php
session_start();

$user = $_SESSION['user'];

// appel fichiers 
require_once(dirname(__FILE__) . '/../utils/regex.php');
require_once(dirname(__FILE__) . '/../model/User.php');
/*************************désactivé le compte ******************************************************************************/
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['disabledUser'] == 'true' ) {
    User::deactivated($user->id);
    header('location: /../controllers/signOut-ctrl.php');
}
/*************************maj compte ******************************************************************************/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*************************************************Lastname***************************************************************/
    // Lastname : nettoyage et validation
    $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
    // vérifie si Lastname n'est pas vide
    if (!empty($lastname)) {
        $testRegex = preg_match('/' . REGEX_NO_NUMBER . '/', $lastname);
        // on vérifie le format
        if (!$testRegex) {
            $error["lastname"] = "Le nom n'est pas au bon format!!";
        } else {
            // vérifie si la chaine de caractaire est conforme en longeur
            if (strlen($lastname) <= 1 || strlen($lastname) >= 70) {
                $error["lastname"] = "La longueur de chaine n'est pas bonne";
            }
        }
    } else { // retourne une erreur dans le tableau d'erreurs
        $error["lastname"] = "Vous devez entrer un nom!!";
    }
    /*********************************************firstname*******************************************************************/

    // firstname : nettoyage et validation
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
    // firstname on vérifie si firstname n'est pas vide
    if (!empty($firstname)) {
        $testRegex = preg_match('/' . REGEX_NO_NUMBER . '/', $firstname);
        // on vérifie le format
        if (!$testRegex) {
            $error["firstname"] = "Le prénom n'est pas au bon format!!";
        } else {
            // vérifie si la chaine de caractaire est conforme en longeur
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
    //  on vérifie si pseudonym n'est pas vide
    if (!empty($pseudonym)) {
        $testRegex = preg_match('/' . REGEX_NO_NUMBER . '/', $pseudonym);
        // on vérifie le format
        if (!$testRegex) {
            $error["pseudonym"] = "Le pseudonym n'est pas au bon format!!";
        } else {
            // vérifie si la chaine de caractaire est conforme en longeur
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
    //  on vérifie si email n'est pas vide
    if (!empty($email)) {
        $testEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        // on vérifie le format
        if (!$testEmail) {
            $error["email"] = "L'adresse email n'est pas au bon format!!";
        }
    } else {
        $error["email"] = "L'adresse mail est obligatoire!!";
    }
    /********************************************password********************************************************************/
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if ($password1 != $password2) {
        $errorsArray['password'] = 'Les mots de passe sont différents';
    } else {
        $password = password_hash($password1, PASSWORD_DEFAULT);
    }
    /*****************************************mail verrif***********************************************************************/
    //test si l'ancien et le nouveau email sont identiques
    if($user->email === $email){
        $customMessage = 'Pas de changement de email';
        $verifMail = true;
    }else{
        //test si le nouveau email existe dans la base de données
        if(User::isExist($email)){
            $customMessage = 'Email deja utiliser';
            $verifMail = false;
        }else{
            echo 'nouveau email';
            $verifMail = true;
        }
    }
        /*****************************************pseudonym verrif***********************************************************************/
    //test si l'ancien et le nouveau pseudonym sont identiques 
    if($user->pseudonym === $pseudonym){
        $customMessage = 'Pas de changement de pseudonym';
        $verifPseudonym = true;
    }else{
        //test si le nouveau email existe dans la base de données
        if(User::isExistPseudonym($pseudonym)){
            $customMessage = 'Pseudonym deja utiliser';
            $verifPseudonym = false;
        }else{
            echo 'nouveau pseudonym';
            $verifPseudonym = true;
        }
    }
    /*****************************************error***********************************************************************/
    if (empty($error) && $verifMail == true && $verifPseudonym == true ) {
        //on passe les infos du user pour hydrater l'objet user
        $user = new User($id = $user->id, $pseudonym, $firstname, $lastname, $email, $password, $deleted_at  = NULL, $registered_at = NULL, $id_role = 1, $confirmation_token = NULL);

        // appel de la méthode update de l'objet user qui remplie la base de données
        $response = $user->updateSignUp();

        if ($response !== true) {
            $customMessage = $response;
        } else {
            $customMessage = 'Vous avez bien éte enregistré !!!';
            include_once(dirname(__FILE__) . '/../controllers/update-signUp-ctrl.php');
        }
    }
}
// appel header
include_once(dirname(__FILE__) . '/../views/templates/header.php');
// appel vue update-signUp
include_once(dirname(__FILE__) . '/../views/update-signUp.php');
// appel footer
include_once(dirname(__FILE__) . '/../views/templates/footer.php');
