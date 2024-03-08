<?php
// appel des fichiers
require_once dirname(__FILE__) . '/../model/User.php';
// on verifie si la methode $_POST existe
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // email :nettoyage et validation
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    //   on vérifie si email n'est pas vide
    if (!empty($email)) {
        $testEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        // vérifie le format
        if (!$testEmail) {
            $error["email"] = "L'adresse email n'est pas au bon format!!";
        }
    } else {
        $error["email"] = "L'adresse mail est obligatoire!!";
    }
    $user = User::getByEmail($email);
    //si l'email n'est pas en base de données
    if($user == false){
        $erreur = "Votre compte n'existe pas encore inscrivez vous !!";
    }
    //comment revériffier l'email????
    //$user->forgottenPassword();
    //var_dump($user);
}
// appel header
include(dirname(__FILE__) . '/../views/templates/header.php');
// appel vue registrationForm

include(dirname(__FILE__) . '/../views/lostPassword.php');

// appel footer
include(dirname(__FILE__) . '/../views/templates/footer.php');